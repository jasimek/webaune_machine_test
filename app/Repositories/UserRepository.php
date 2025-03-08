<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Models\User;
use App\Models\UserDepartmentUnit;
use Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserRepository
{
	public function storeUser($data)
	{

		// dd($data['role']);


		$this->validateData($data);
		$this->validateFirstNameAndLastName($data);
		// $this->validateDepartmentHead($data);
		// $this->validateUnitHead($data);
		$user = User::create([
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'] ?? null,
			'email' => $data['email'] ?? null,
			'phone' => $data['phone'] ?? null,
			'password' => Hash::make('123456'),

		]);

		$role = Role::find($data['role']);
		$user->assignRole($role);
		return $user;
	}

	public function update($data, User $user)
	{
		if ($user->id == 1) {
			throw new Exception('This User Can Not Edit', 400);
			return;
		}
		$data['id'] = $user->id;
		$this->validateData($data, true);
		$this->validateFirstNameAndLastName($data, true);
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'] ?? null;
		$user->email = $data['email'] ?? null;
		$user->phone = $data['phone'] ?? null;
		$user->save();
		if (!$user->roles->isEmpty() && $data['role']) {
			foreach ($user->roles as $role) {
				$user->removeRole($role);
			}
		}
		$user->assignRole($data['role']);
	}

	public function changeStatus(User $user)
	{
		if ($user->id == 1) {
			throw new Exception('This User Can Not Edit', 400);
			return;
		}
		$user->status = !$user->status;
		$user->save();
		return $user;
	}

	public function getAllUsers()
	{
		return User::get();
	}

	public function getAllActiveUsers()
	{
		return User::where('status', true)->get();
	}

	public function getPhysicianUsers()
	{
		return User::where('type', 'physician')->where('status', true)->get();
	}

	public function getAllQualityTeamUsers()
	{
		return User::where('type', 'quality_team')->orWhere('type', 'supervisor')->where('status', true)->get();
	}

	public function changePassword($data, $user)
	{
		if ($user->id == 1 || $user->id == Auth::user()['id']) {
			throw new Exception('This User Can Not Edit', 400);
			return;
		}
		$this->passwordValidateData($data);
		$user->password = Hash::make($data['password']);
		$user->save();
		return $user;
	}

	public function deleteUser(User $user)
	{
		if ($user->id == 1 || $user->id == Auth::user()['id']) {
			throw new Exception('This User Can Not Delete', 400);
			return;
		}
		$user->delete();
		return true;
	}

	public function checkMail($data)
	{
		$this->mailValidate($data);
		$user = User::where('email', $data['email'])->first();
		if (!$user) {
			throw new Exception('Please Enter Correct Email', 400);
			return;
		}
		return $user;
	}

	public function resetPassword(HttpRequest $request)
	{
		$this->resetPasswordValidateData($request->all());
		$status = Password::reset(
			$request->only('email', 'password', 'confirm_password', 'token'),
			function (User $user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));
				$user->save();
				event(new PasswordReset($user));
			}
		);
		return $status;
	}



	public function validateData($data, $for_update = false)
	{


		validator(
			$data,
			[
				'first_name' => 'required|max:100',
				'last_name' => 'required|max:100',
				'email' => 'bail|required|unique:users,email' . ($for_update ? ',' . $data['id'] : ''),
				'phone' => 'bail|required',
				'role' => 'bail|required',
			],
		)->validate();
	}

	public function validateFirstNameAndLastName($data, $from_update = false)
	{
		if ($from_update) {
			$user = User::where('id', '!=', $data['id'])->where('first_name', $data['first_name'])->where('last_name', $data['last_name'])->count();
			if ($user > 0) {
				throw new Exception('Full name already taken', 101);
				return;
			}
		} else {
			$user = User::where('first_name', $data['first_name'])->where('last_name', $data['last_name'])->count();
			if ($user > 0) {
				throw new Exception('Full name already taken', 101);
				return;
			}
		}
	}

	public function passwordValidateData($data)
	{
		validator($data, [
			'password' => 'bail|required|min:6',
			'confirm_password' => 'bail|required|min:6|same:password'
		])->validate();
	}

	public function resetPasswordValidateData($data)
	{
		validator($data, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'bail|required|min:6',
			'confirm_password' => 'bail|required|min:6|same:password'
		])->validate();
	}

	public function mailValidate($data)
	{
		validator($data, [
			'email' => 'bail|required|email',
		])->validate();
	}

	public function validateDepartmentHead($data, $from_update = false)
	{
		if ($data['is_department_head']) {
			if ($from_update) {
				$user = User::where('facility_id', $data['facility_id'])->where('department_id', $data['department_id'])->where('is_department_head', $data['is_department_head'])->where('id', '!=', $data['id'])->first();
				if (!$user) {
					return true;
				} else {
					throw new Exception('Department Head is Already used in this facility', 6001);
				}
			} else {

				$user = User::where('facility_id', $data['facility_id'])->where('department_id', $data['department_id'])->where('is_department_head', $data['is_department_head'])->count();
				if ($user > 0) {
					throw new Exception('Department Head is Already used in this facility', 6001);
				} else {
					return true;
				}
			}
		}
	}

	public function validateUnitHead($data, $from_update = false)
	{
		if ($data['is_unit_head']) {
			if ($from_update) {
				$user = User::where('facility_id', $data['facility_id'])->where('department_id', $data['department_id'])->where('unit_id', $data['unit_id'])->where('is_unit_head', $data['is_unit_head'])->where('id', '!=', $data['id'])->first();
				if (!$user) {
					return true;
				} else {
					throw new Exception('Unit Head is Already used in this Department', 6001);
				}
			} else {
				$user = User::where('facility_id', $data['facility_id'])->where('department_id', $data['department_id'])->where('unit_id', $data['unit_id'])->where('is_unit_head', $data['is_unit_head'])->count();
				if ($user > 0) {
					throw new Exception('Unit Head is Already used in this Department', 6001);
				} else {
					return true;
				}
			}
		}
	}
}
