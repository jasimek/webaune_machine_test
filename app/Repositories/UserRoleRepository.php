<?php

namespace App\Repositories;

use Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;

class UserRoleRepository
{
    public function permissionsData()
    {
        $permissions = Permission::get();
        $data['count'] = $permissions->count();
        $data['permission'] = [];
        foreach ($permissions as $permission) {
            if (str_contains($permission, 'dashboard')) {
                $data['permission']['dashboard'][] = $permission;
            } else if (str_contains($permission, 'users')) {
                $data['permission']['users'][] = $permission;
            } else if (str_contains($permission, 'roles')) {
                $data['permission']['roles'][] = $permission;
            } else if (str_contains($permission, 'facility')) {
                $data['permission']['facility'][] = $permission;
            } else if (str_contains($permission, 'departments')) {
                $data['permission']['departments'][] = $permission;
            } else if (str_contains($permission, 'units')) {
                $data['permission']['units'][] = $permission;
            } else if (str_contains($permission, 'global settings')) {
                $data['permission']['global settings'][] = $permission;
            } else if (str_contains($permission, 'commitee owners')) {
                $data['permission']['commitee owners'][] = $permission;
            } else if (str_contains($permission, 'privacy policy')) {
                $data['permission']['privacy policy'][] = $permission;
            } else if (str_contains($permission, 'policy management')) {
                $data['permission']['policy management'][] = $permission;
            } else if (str_contains($permission, 'quality standard')) {
                $data['permission']['quality standard'][] = $permission;
            } else if (str_contains($permission, 'indicator categories')) {
                $data['permission']['indicator categories'][] = $permission;
            } else if (str_contains($permission, 'quality indicator')) {
                $data['permission']['quality indicator'][] = $permission;
            } else if (str_contains($permission, 'my indicator')) {
                $data['permission']['my indicator'][] = $permission;
            } else if (str_contains($permission, 'audit standard-chapter')) {
                $data['permission']['audit standard-chapter'][] = $permission;
            } else if (str_contains($permission, 'audit measure')) {
                $data['permission']['audit measure'][] = $permission;
            } else if (str_contains($permission, 'audit scoring matrix')) {
                $data['permission']['audit scoring matrix'][] = $permission;
            } else if (str_contains($permission, 'audit element')) {
                $data['permission']['audit element'][] = $permission;
            } else if (str_contains($permission, 'audits')) {
                $data['permission']['audits'][] = $permission;
            } else if (str_contains($permission, 'my audit')) {
                $data['permission']['my audit'][] = $permission;
            } else if (str_contains($permission, 'incident categories')) {
                $data['permission']['incident categories'][] = $permission;
            } else if (str_contains($permission, 'injury outcome')) {
                $data['permission']['injury outcome'][] = $permission;
            } else if (str_contains($permission, 'nature of treatment')) {
                $data['permission']['nature of treatment'][] = $permission;
            } else if (str_contains($permission, 'type of incident')) {
                $data['permission']['type of incident'][] = $permission;
            } else if (str_contains($permission, 'contributing factors')) {
                $data['permission']['contributing factors'][] = $permission;
            } else if (str_contains($permission, 'incidents')) {
                $data['permission']['incidents'][] = $permission;
            } else if (str_contains($permission, 'action')) {
                $data['permission']['action'][] = $permission;
            }
        }
        return $data;
    }

    public function createRole($data)
    {
        $this->validateData($data);

        try {
            $role = Role::create([
                'guard_name' => 'web',
                'name' => $data['name'],
            ]);

            $role->givePermissionTo($data['permissions']);
        } catch (Throwable $th) {

            throw $th;
        }
        return $role;
    }

    public function updateRole($data, $role)
    {
        $data['id'] = $role->id;
        $this->validateData($data, true);
        $role->name = $data['name'];
        $role->save();
        $role->syncPermissions($data['permissions']);
        return $role;
    }

    public function getRoles()
    {
        return Role::where('id', '>', 1)->where('guard_name', 'web')->get();
    }

    public function delete($role)
    {
        if ($role->users->count() > 0) {
            throw new Exception('This role has user cannot Delete', 400);
            return;
        } else {
            $role->delete();
        }
    }

    public function validateData($data, $for_update = false)
    {
        validator($data, [
            'name' => 'bail|required|string|unique:roles,name' . ($for_update ? ',' . $data['id'] : ''),
            'permissions' => 'bail|nullable|array',
        ])->validate();
    }
}
