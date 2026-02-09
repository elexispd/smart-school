<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Roles & Permissions</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage user roles and permissions</p>
            </div>
            <div class="flex gap-3">
                @if(auth()->user()->hasPermission('edit permissions'))
                <button wire:click="$set('showAddPermissionModal', true)" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                    Add Permission
                </button>
                @endif
                @if(auth()->user()->hasPermission('create roles'))
                <button wire:click="$set('showAddRoleModal', true)" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                    Add Role
                </button>
                @endif
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6 flex gap-2 border-b border-gray-200 dark:border-gray-700">
            <button wire:click="$set('userType', 'saas')" class="px-6 py-3 font-semibold transition-colors {{ $userType === 'saas' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                SaaS Admin Roles
            </button>
            <button wire:click="$set('userType', 'school')" class="px-6 py-3 font-semibold transition-colors {{ $userType === 'school' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                School User Roles
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Roles -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Roles</h3>
                <div class="space-y-2">
                    @forelse($roles as $role)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $role->name }}</p>
                                <p class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</p>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="showInfo({{ $role->id }})" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded flex items-center gap-1" title="View permissions">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Info
                                </button>
                                @if(auth()->user()->hasPermission('assign roles'))
                                <button wire:click="openAssignModal({{ $role->id }})" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded flex items-center gap-1" wire:loading.attr="disabled" wire:target="openAssignModal({{ $role->id }})">
                                    <span wire:loading.remove wire:target="openAssignModal({{ $role->id }})">Assign</span>
                                    <span wire:loading wire:target="openAssignModal({{ $role->id }})" class="flex items-center gap-1">
                                        <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Loading...
                                    </span>
                                </button>
                                @endif
                                @if(auth()->user()->hasPermission('edit roles'))
                                <button wire:click="editRole({{ $role->id }})" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded flex items-center gap-1" wire:loading.attr="disabled" wire:target="editRole({{ $role->id }})">
                                    <span wire:loading.remove wire:target="editRole({{ $role->id }})">Edit</span>
                                    <span wire:loading wire:target="editRole({{ $role->id }})" class="flex items-center gap-1">
                                        <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Loading...
                                    </span>
                                </button>
                                @endif
                                @if(auth()->user()->hasPermission('delete roles'))
                                <button wire:click="deleteRole({{ $role->id }})" wire:confirm="Delete this role?" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded flex items-center gap-1" wire:loading.attr="disabled" wire:target="deleteRole({{ $role->id }})">
                                    <span wire:loading.remove wire:target="deleteRole({{ $role->id }})">Delete</span>
                                    <span wire:loading wire:target="deleteRole({{ $role->id }})" class="flex items-center gap-1">
                                        <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Loading...
                                    </span>
                                </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No roles created yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Permissions</h3>
                <div class="space-y-2">
                    @forelse($permissions as $permission)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg flex justify-between items-center">
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $permission->name }}</p>
                            <div class="flex gap-2">
                                @if(auth()->user()->hasPermission('edit permissions'))
                                <button wire:click="editPermission({{ $permission->id }})" class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-xs rounded flex items-center gap-1" wire:loading.attr="disabled" wire:target="editPermission({{ $permission->id }})">
                                    <span wire:loading.remove wire:target="editPermission({{ $permission->id }})">Edit</span>
                                    <span wire:loading wire:target="editPermission({{ $permission->id }})" class="flex items-center gap-1">
                                        <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Loading...
                                    </span>
                                </button>
                                @endif
                                @if(auth()->user()->hasPermission('edit permissions'))
                                <button wire:click="deletePermission({{ $permission->id }})" wire:confirm="Delete this permission?" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded flex items-center gap-1" wire:loading.attr="disabled" wire:target="deletePermission({{ $permission->id }})">
                                    <span wire:loading.remove wire:target="deletePermission({{ $permission->id }})">Delete</span>
                                    <span wire:loading wire:target="deletePermission({{ $permission->id }})" class="flex items-center gap-1">
                                        <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Loading...
                                    </span>
                                </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No permissions created yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Role Modal -->
    @if($showAddRoleModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showAddRoleModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add New Role</h3>
                <form wire:submit="addRole">
                    <input type="text" wire:model="roleName" placeholder="Role name (e.g., editor)" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 mb-4">
                    @error('roleName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showAddRoleModal', false)" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Add Permission Modal -->
    @if($showAddPermissionModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showAddPermissionModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add New Permission</h3>
                <form wire:submit="addPermission">
                    <input type="text" wire:model="permissionName" placeholder="Permission name (e.g., edit-posts)" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-4">
                    @error('permissionName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showAddPermissionModal', false)" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Assign Permissions Modal -->
    @if($showAssignModal && $selectedRole)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showAssignModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Assign Permissions to {{ $selectedRole->name }}</h3>
                <form wire:submit="assignPermissions">
                    <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
                        @foreach($permissions as $permission)
                            <label class="flex items-center gap-2 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded cursor-pointer">
                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}" class="rounded text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-900 dark:text-white">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showAssignModal', false)" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg flex items-center justify-center gap-2" wire:loading.attr="disabled" wire:target="assignPermissions">
                            <span wire:loading.remove wire:target="assignPermissions">Save</span>
                            <span wire:loading wire:target="assignPermissions" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Edit Role Modal -->
    @if($showEditRoleModal && $editingRole)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showEditRoleModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Edit Role</h3>
                <form wire:submit="updateRole">
                    <input type="text" wire:model="roleName" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 mb-4">
                    @error('roleName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showEditRoleModal', false)" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Edit Permission Modal -->
    @if($showEditPermissionModal && $editingPermission)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showEditPermissionModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Edit Permission</h3>
                <form wire:submit="updatePermission">
                    <input type="text" wire:model="permissionName" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-4">
                    @error('permissionName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <div class="flex gap-3">
                        <button type="button" wire:click="$set('showEditPermissionModal', false)" class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Info Modal -->
    @if($showInfoModal && $infoRole)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="$set('showInfoModal', false)"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $infoRole->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Role Permissions</p>
                    </div>
                </div>
                
                @if($infoRole->permissions->count())
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($infoRole->permissions as $permission)
                            <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $permission->name }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <p class="text-gray-500 dark:text-gray-400">No permissions assigned to this role</p>
                    </div>
                @endif
                
                <div class="mt-6">
                    <button type="button" wire:click="$set('showInfoModal', false)" class="w-full px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>
