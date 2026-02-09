<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RolesPermissions extends Component
{
    public $userType = 'saas';
    public $showAddRoleModal = false;
    public $showAddPermissionModal = false;
    public $showAssignModal = false;
    public $showEditRoleModal = false;
    public $showEditPermissionModal = false;
    public $showInfoModal = false;
    public $infoRole = null;
    public $roleName = '';
    public $permissionName = '';
    public $selectedRole = null;
    public $selectedPermissions = [];
    public $editingRole = null;
    public $editingPermission = null;

    public function addRole()
    {
        $this->validate(['roleName' => 'required|unique:roles,name']);
        $type = $this->userType === 'saas' ? 'saas' : 'school';
        $role = Role::create(['name' => $this->roleName, 'type' => $type]);
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties(['attributes' => ['name' => $role->name, 'type' => $role->type]])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Role '{$role->name}' was created");
        
        $this->showAddRoleModal = false;
        $this->roleName = '';
    }

    public function addPermission()
    {
        $this->validate(['permissionName' => 'required|unique:permissions,name']);
        $type = $this->userType === 'saas' ? 'saas' : 'school';
        $permission = Permission::create(['name' => $this->permissionName, 'type' => $type]);
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties(['attributes' => ['name' => $permission->name, 'type' => $permission->type]])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Permission '{$permission->name}' was created");
        
        $this->showAddPermissionModal = false;
        $this->permissionName = '';
    }

    public function openAssignModal($roleId)
    {
        $this->selectedRole = Role::find($roleId);
        $this->selectedPermissions = $this->selectedRole->permissions->pluck('id')->toArray();
        $this->showAssignModal = true;
    }

    public function showInfo($roleId)
    {
        $this->infoRole = Role::with('permissions')->find($roleId);
        $this->showInfoModal = true;
    }

    public function assignPermissions()
    {
        $oldPermissions = $this->selectedRole->permissions->pluck('name')->toArray();
        $permissions = Permission::whereIn('id', $this->selectedPermissions)->get();
        $this->selectedRole->syncPermissions($permissions);
        $newPermissions = $this->selectedRole->fresh()->permissions->pluck('name')->toArray();
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties([
                'old' => ['permissions' => $oldPermissions],
                'attributes' => ['permissions' => $newPermissions]
            ])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Permissions assigned to role '{$this->selectedRole->name}'");
        
        $this->showAssignModal = false;
        $this->selectedRole = null;
    }

    public function editRole($roleId)
    {
        $this->editingRole = Role::find($roleId);
        $this->roleName = $this->editingRole->name;
        $this->showEditRoleModal = true;
    }

    public function updateRole()
    {
        $this->validate(['roleName' => 'required|unique:roles,name,' . $this->editingRole->id]);
        $oldName = $this->editingRole->name;
        $this->editingRole->update(['name' => $this->roleName]);
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties([
                'old' => ['name' => $oldName],
                'attributes' => ['name' => $this->roleName]
            ])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Role '{$oldName}' was updated");
        
        $this->showEditRoleModal = false;
        $this->editingRole = null;
        $this->roleName = '';
    }

    public function deleteRole($roleId)
    {
        $role = Role::find($roleId);
        $roleName = $role->name;
        $role->delete();
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties(['old' => ['name' => $roleName]])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Role '{$roleName}' was deleted");
    }

    public function editPermission($permissionId)
    {
        $this->editingPermission = Permission::find($permissionId);
        $this->permissionName = $this->editingPermission->name;
        $this->showEditPermissionModal = true;
    }

    public function updatePermission()
    {
        $this->validate(['permissionName' => 'required|unique:permissions,name,' . $this->editingPermission->id]);
        $oldName = $this->editingPermission->name;
        $this->editingPermission->update(['name' => $this->permissionName]);
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties([
                'old' => ['name' => $oldName],
                'attributes' => ['name' => $this->permissionName]
            ])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Permission '{$oldName}' was updated");
        
        $this->showEditPermissionModal = false;
        $this->editingPermission = null;
        $this->permissionName = '';
    }

    public function deletePermission($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permissionName = $permission->name;
        $permission->delete();
        
        $causer = Auth::user();
        $logName = ($causer && !$causer->school_id) ? 'saas' : 'school';
        activity($logName)
            ->causedBy($causer)
            ->withProperties(['old' => ['name' => $permissionName]])
            ->tap(fn($activity) => $activity->school_id = $causer->school_id)
            ->log("Permission '{$permissionName}' was deleted");
    }

    public function render()
    {
        $type = $this->userType === 'saas' ? 'saas' : 'school';
        $roles = Role::with('permissions')->where('type', $type)->get();
        $permissions = Permission::where('type', $type)->get();
        return view('livewire.platform.roles-permissions', compact('roles', 'permissions'))
            ->layout('layouts.app')
            ->title('Roles & Permissions');
    }
}
