<?php

namespace App\Http\Controllers;

use App\Repositories\UserRoleRepository;
use App\Traits\AddToast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Throwable;

class UserRoleController extends Controller
{
    use AddToast;
    protected $user_role_repo;

    public function __construct(
        UserRoleRepository $user_role_repo
    ) {
        $this->user_role_repo = $user_role_repo;
        // $this->middleware('permission:view roles', ['only' => ['index']]);
        // $this->middleware('permission:create roles', ['only' => ['create']]);
        // $this->middleware('permission:edit roles', ['only' => ['edit']]);
        // $this->middleware('permission:delete roles', ['only' => ['destroy']]);
        // $this->middleware('permission:status roles', ['only' => ['changeStatus']]);
    }

    public function index()
    {
        return Inertia::render('User_role/Index', ['roles' => $this->user_role_repo->getRoles()]);
    }

    public function create()
    {
        $data = $this->user_role_repo->permissionsData();
        return Inertia::render('User_role/Create', ['permissions' => $data]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->user_role_repo->createRole($request->all());
        } catch (Throwable $th) {
            DB::rollback();
            if ($th instanceof ValidationException) throw $th;
            $this->addToast('error', 'Error Message', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Created', 'User Role Successfully Created');
        return redirect()->route('user-roles.index');
    }

    public function edit(string $id)
    {
        $data = $this->user_role_repo->permissionsData();
        $role = Role::where('id', $id)->first();
        return Inertia::render('User_role/Edit', [
            'role' => $role->load('permissions'),
            'permissions' => $data,
        ]);
    }

    public function update(Request $request, Role $user_role)
    {
        DB::beginTransaction();
        try {
            $this->user_role_repo->updateRole($request->all(), $user_role);
        } catch (Throwable $th) {
            DB::rollback();
            if ($th instanceof ValidationException) throw $th;
            $this->addToast('error', 'Error Message', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Updated', 'User Role Successfully Updated');
        return redirect()->route('user-roles.index');
    }

    public function destroy(Role $user_role)
    {
        DB::beginTransaction();
        try {
            $this->user_role_repo->delete($user_role);
        } catch (Throwable $th) {
            DB::rollback();
            if ($th->getCode() == 400) {
                $this->addToast('error', 'Cannot Delete', $th->getMessage());
                return back();
            }
            if ($th instanceof ValidationException) throw $th;
            $this->addToast('error', 'Error Message', 'Something Went Wrong');
            return back();
        }
        DB::commit();
        $this->addToast('success', 'Deleted', 'User Role Successfully Deleted');
        return redirect()->route('user-roles.index');
    }
}
