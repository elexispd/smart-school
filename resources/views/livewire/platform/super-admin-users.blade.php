<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Management</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Manage system users and permissions</p>
            </div>
            <div class="flex gap-3">
                @if(auth()->user()->hasPermission('create users'))
                <button wire:click="addSaasAdmin" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add SaaS Admin
                </button>
                <button wire:click="addUser" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Add School User
                </button>
                @endif
            </div>
        </div>

        <!-- User Type Tabs -->
        <div class="mb-6 flex gap-2 border-b border-gray-200 dark:border-gray-700">

            <button
                wire:click="$set('userType', 'saas')"
                class="px-6 py-3 font-semibold transition-colors {{ $userType === 'saas' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                Platform Admins
            </button>

            <button
                wire:click="$set('userType', 'school')"
                class="px-6 py-3 font-semibold transition-colors {{ $userType === 'school' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                School Users
            </button>

        </div>

        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by name or email..."
                    class="w-full px-4 py-3 pl-12 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-emerald-500 focus:ring-emerald-500"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <select wire:model.live="roleFilter" class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-emerald-500 focus:ring-emerald-500">
                <option value="">All Roles</option>
                <option value="super_admin">Super Admin</option>
                <option value="school_admin">School Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
            <div class="flex gap-2">
                <button wire:click="$set('viewMode', 'grid')" class="flex-1 px-4 py-3 rounded-lg border {{ $viewMode === 'grid' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-700' }} transition-colors">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </button>
                <button wire:click="$set('viewMode', 'table')" class="flex-1 px-4 py-3 rounded-lg border {{ $viewMode === 'table' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-700' }} transition-colors">
                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </button>
            </div>
        </div>

        <!-- Users Grid/Table -->
        <div wire:loading.remove>
            @if($users->count())
                @if($viewMode === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    @foreach($users as $user)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow p-6 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start gap-4 mb-4">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-xl object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-2xl font-bold text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                    <span class="inline-block mt-2 px-3 py-1 text-xs font-semibold rounded-full
                                        @if($user->role === 'super_admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($user->role === 'school_admin') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($user->role === 'teacher') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </div>
                            </div>

                            @if($user->school)
                                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">School</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->school->name }}</p>
                                </div>
                            @endif

                            <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button wire:click="viewUser('{{ $user->id }}')" class="flex-1 px-4 py-2 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700/50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 font-medium rounded-lg transition-colors">
                                    View
                                </button>
                                @if(auth()->user()->hasPermission('edit users'))
                                <button wire:click="editUser('{{ $user->id }}')" class="flex-1 px-4 py-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-medium rounded-lg transition-colors">
                                    Edit
                                </button>
                                @endif
                                @if(auth()->user()->hasPermission('delete users'))
                                <button wire:click="deleteUser('{{ $user->id }}')" class="flex-1 px-4 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-600 dark:text-red-400 font-medium rounded-lg transition-colors">
                                    Delete
                                </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">S/N</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">School</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-sm font-bold text-white">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($user->role === 'super_admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($user->role === 'school_admin') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($user->role === 'teacher') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $user->school->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="viewUser('{{ $user->id }}')" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    @if(auth()->user()->hasPermission('edit users'))
                                    <button wire:click="editUser('{{ $user->id }}')" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-200 mr-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    @endif
                                    @if(auth()->user()->hasPermission('delete users'))
                                    <button wire:click="deleteUser('{{ $user->id }}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No users found</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        @if($search || $roleFilter)
                            No users match your search criteria.
                        @else
                            Get started by adding your first user.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add School User Modal -->
    @if($showAddModal || $showEditModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md">
                    <form wire:submit="{{ $showAddModal ? 'saveUser' : 'updateUser' }}">
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ $showAddModal ? 'Add New User' : 'Edit User' }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password {{ $showEditModal ? '(leave blank to keep current)' : '' }}</label>
                                    <input type="password" wire:model="password" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                                    <select wire:model="role" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="student">Student</option>
                                        <option value="staff">Staff</option>
                                        <option value="admin">Admin</option>
                                        <option value="super_admin">Super Admin</option>
                                    </select>
                                    @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">School (Optional)</label>
                                    <select wire:model="school_id" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                        <option value="">No School</option>
                                        @foreach($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                                {{ $showAddModal ? 'Add User' : 'Update User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Add SaaS Admin Modal -->
    @if($showAddSaasAdminModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md">
                    <form wire:submit="saveSaasAdmin">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-xl">
                                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Add SaaS Admin</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Platform administrator</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                                    <input type="password" wire:model="password" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-800">
                                    <div class="flex gap-2">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-sm text-purple-800 dark:text-purple-300">This admin will have full platform access and can manage all schools.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg transition-colors">
                                Add Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="absolute inset-0" wire:click="closeModal"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Delete User?</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    This will permanently delete the user account. This action cannot be undone.
                </p>
                <div class="flex gap-3">
                    <button type="button" wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">
                        Cancel
                    </button>
                    <button type="button" wire:click="confirmDelete" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    <!-- View User Modal -->
    @if($showViewModal && $viewUser)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl my-8 overflow-hidden">
                    <!-- Header with gradient and close button -->
                    <div class="relative h-32 bg-gradient-to-r from-emerald-500 to-teal-600">
                        <button wire:click="closeModal" class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="px-6 pb-6 relative">
                        <!-- Avatar and Name -->
                        <div class="absolute -top-12 left-6 z-10">
                            @if($viewUser->avatar)
                                <img src="{{ Storage::url($viewUser->avatar) }}" alt="{{ $viewUser->name }}" class="w-24 h-24 rounded-2xl border-4 border-white dark:border-gray-800 shadow-lg object-cover bg-white">
                            @else
                                <div class="w-24 h-24 rounded-2xl border-4 border-white dark:border-gray-800 shadow-lg bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-3xl font-bold text-white">
                                    {{ strtoupper(substr($viewUser->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="ml-32 pt-3 pb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">{{ $viewUser->name }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-semibold rounded-full
                                    @if($viewUser->role === 'super_admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                    @elseif($viewUser->role === 'school_admin') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($viewUser->role === 'teacher') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $viewUser->role)) }}
                                </span>
                            </div>
                        </div>

                        <!-- User Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Basic Information
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Email:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $viewUser->email }}</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">User ID:</span>
                                        <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $viewUser->id }}</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Joined:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Last Update:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- School Information -->
                            @if($viewUser->school)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    School Information
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">School:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->school->name }}</span>
                                    </div>
                                    @if($viewUser->school->acronym)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Acronym:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->school->acronym }}</span>
                                    </div>
                                    @endif
                                    @if($viewUser->school->email)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Email:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->school->email }}</span>
                                    </div>
                                    @endif
                                    @if($viewUser->school->phone)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Phone:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->school->phone }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Staff Information -->
                            @if($viewUser->staff)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Staff Details
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Staff ID:</span>
                                        <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $viewUser->staff->id }}</span>
                                    </div>
                                    @if($viewUser->staff->position ?? false)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Position:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->staff->position }}</span>
                                    </div>
                                    @endif
                                    @if($viewUser->staff->department ?? false)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-24 flex-shrink-0">Department:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->staff->department }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Student Information -->
                            @if($viewUser->student)
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-6">
                                <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Student Details
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-32 flex-shrink-0">Student ID:</span>
                                        <span class="text-sm font-mono text-gray-900 dark:text-white">{{ $viewUser->student->id }}</span>
                                    </div>
                                    @if($viewUser->student->admission_number ?? false)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-32 flex-shrink-0">Admission No:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->student->admission_number }}</span>
                                    </div>
                                    @endif
                                    @if($viewUser->student->class ?? false)
                                    <div class="flex items-start">
                                        <span class="text-sm text-gray-500 dark:text-gray-400 w-32 flex-shrink-0">Class:</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $viewUser->student->class }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 rounded-b-2xl flex justify-end gap-3">
                        @if(auth()->user()->hasPermission('edit users'))
                        <button wire:click="editUser('{{ $viewUser->id }}')" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                            Edit User
                        </button>
                        @endif
                        <button wire:click="closeModal" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>
