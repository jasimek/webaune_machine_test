<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Unit;
use App\Models\User;
use App\Repositories\DepartmentRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRoleRepository;
use App\Traits\AddToast;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Throwable;

class UserController extends Controller
{

    use AddToast;
    protected $user_role_repo;
    protected $user_repo;

    public function __construct(
        UserRoleRepository $user_role_repo,
        UserRepository $user_repository,
    ) {
        $this->user_role_repo = $user_role_repo;
        $this->user_repo = $user_repository;
        // $this->middleware('permission:view users', ['only' => ['index']]);
        // $this->middleware('permission:create users', ['only' => ['create']]);
        // $this->middleware('permission:edit users', ['only' => ['edit']]);
        // $this->middleware('permission:delete users', ['only' => ['destroy']]);
        // $this->middleware('permission:status users', ['only' => ['changeStatus']]);
    }

    public function index()
    {
        return Inertia::render('User/Index', [
            'users' => User::with('roles')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            'roles' => $this->user_role_repo->getRoles(),
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->user_repo->storeUser($request->all());
            // $status = Password::sendResetLink(
            //     $request->only('email')
            // );
        } catch (Throwable $th) {
            DB::rollback();

            dd($th);
            if ($th->getCode() == 6001) {
                return back()->withErrors(['message' => $th->getmessage()]);
            }
            if ($th->getCode() == 101) {
                return back()->withErrors(['message' => $th->getmessage(), 'code' => 101]);
            }
            if ($th instanceof ValidationException) throw $th;
            $this->addToast('error', 'Error Message', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Created', 'User Successfully Created');
        // return $status === Password::RESET_LINK_SENT
        //     ? redirect()->route('users.index')->with(['status' => 'Email has been sended! please check your mail'])
        //     : back()->withErrors(['email' => __($status)]);
        return back();
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'users' => $user->load('roles'),
            'roles' => $this->user_role_repo->getRoles(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $this->user_repo->update($data, $user);
        } catch (Throwable $th) {
            DB::rollback();
            if ($th->getCode() == 101) {
                return back()->withErrors(['message' => $th->getmessage(), 'code' => 101]);
            }
            if ($th->getCode() == 6001) {
                return back()->withErrors(['message' => $th->getmessage()]);
            }
            if ($th instanceof ValidationException) throw $th;
            if ($th->getCode() == 400) {
                $this->addToast('error', 'Error Message', $th->getMessage());
            } else {
                $this->addToast('error', 'Error Message', 'Something Went Wrong');
            }
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Updated', 'User Successfully Updated');
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $this->user_repo->deleteUser($user);
        } catch (Throwable $th) {
            DB::rollback();

            if ($th instanceof ValidationException) throw $th;
            if ($th->getCode() == 400) {
                $this->addToast('error', 'Error Message', $th->getMessage());
            } else {
                $this->addToast('error', 'Cannot Delete', "some data is related to this user cannot delete !");
            }
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Deleted', 'User Successfully Deleted');
        return back();
    }

    public function userLoginPage()
    {
        return Inertia::render('Auth/Login');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        try {
            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }
        } catch (Throwable $th) {
        }

        return back()->withErrors([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    public function checkMail(Request $request)
    {
        try {
            $user = $this->user_repo->checkMail($request->all());
        } catch (Throwable $th) {
            if ($th instanceof ValidationException) throw $th;
            if ($th->getCode() == 400) {
                return back()->withErrors([
                    'error' => $th->getMessage(),
                ]);
            } else {
                $this->addToast('error', 'Error Message', 'Something Went Wrong');
            }
            return back();
        }
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Email has been sended! please check your mail'])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordPage(Request $request, string $token)
    {
        $user = User::where('email', $request['email'])->first();
        return Inertia::render('Auth/ResetNewPassword', [
            'user' => $user,
            'token' => $token
        ]);
    }

    public function resetPassword(HttpRequest $request)
    {
        try {
            $status = $this->user_repo->resetPassword($request);
        } catch (Throwable $th) {
            if ($th instanceof ValidationException) throw $th;
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('forgot-password.success-page')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function forgotPasswordSuccessPage()
    {
        return Inertia::render('Auth/ForgotPasswordSuccess');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function changeStatus(User $user)
    {

        DB::beginTransaction();
        try {
            $this->user_repo->changeStatus($user);
        } catch (Throwable $th) {
            DB::rollback();
            if ($th instanceof ValidationException) throw $th;
            if ($th->getCode() == 400) {
                return response()->json(['message' => $th->getMessage()], 500);
            } else {
                return response()->json(['message' => 'Something Went Wrong'], 500);
            }
        }
        DB::commit();
        return response()->json(['message' => 'Status Updated'], 200);
    }

    public function changePassword(Request $request, User $user)
    {
        DB::beginTransaction();
        try {
            $this->user_repo->changePassword($request->all(), $user);
        } catch (Throwable $th) {
            DB::rollback();
            if ($th instanceof ValidationException) throw $th;
            if ($th->getCode() == 400) {
                $this->addToast('error', 'Error Message', $th->getMessage());
            } else {
                $this->addToast('error', 'Error Message', 'Something Went Wrong');
            }
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Updated', 'Password Successfully Updated');
        return back();
    }

    public function profile()
    {
        return Inertia::render('Profile/Edit');
    }
}
