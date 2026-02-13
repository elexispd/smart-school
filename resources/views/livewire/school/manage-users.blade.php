<div class="py-6">
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif
    <style>
        @media print {
            body * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; }
            .print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 no-print">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    @if($filterRole === 'student')
                        Students
                    @elseif($filterRole === 'staff')
                        Staff
                    @else
                        Users
                    @endif
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if($filterRole === 'student')
                        Manage students
                    @elseif($filterRole === 'staff')
                        Manage staff members
                    @else
                        Manage students and staff
                    @endif
                </p>
            </div>
            @if(auth()->user()->role === 'school_admin')
            <div class="flex gap-2">
                @if($filterRole === 'student')
                <button wire:click="openImportModal" wire:loading.attr="disabled" wire:target="openImportModal" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2 disabled:opacity-50">
                    <svg wire:loading.remove wire:target="openImportModal" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <svg wire:loading wire:target="openImportModal" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Import Excel
                </button>
                @endif
                <button wire:click="create" wire:loading.attr="disabled" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-50 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                    <svg wire:loading.remove wire:target="create" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <svg wire:loading wire:target="create" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Add {{ $filterRole ? ucfirst($filterRole) : 'User' }}
                </button>
            </div>
            @endif
        </div>

        <!-- Search and Role Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <!-- Search -->
                <div class="lg:col-span-8">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input wire:model.live="search" type="text" placeholder="Search by name or email..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:text-white">
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="lg:col-span-2">
                    <select wire:model.live="filterRole" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                        <option value="">All Roles</option>
                        <option value="student">Students</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>

                <!-- View Mode Toggle -->
                <div class="lg:col-span-2 flex gap-2">
                    <button wire:click="$set('viewMode', 'grid')" class="flex-1 px-3 py-2.5 {{ $viewMode === 'grid' ? 'bg-emerald-600 text-white' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} border border-gray-300 dark:border-gray-600 rounded-lg font-medium transition-colors flex items-center justify-center gap-1.5" title="Grid View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span class="text-xs">Grid</span>
                    </button>
                    <button wire:click="$set('viewMode', 'table')" class="flex-1 px-3 py-2.5 {{ $viewMode === 'table' ? 'bg-emerald-600 text-white' : 'bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} border border-gray-300 dark:border-gray-600 rounded-lg font-medium transition-colors flex items-center justify-center gap-1.5" title="Table View">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span class="text-xs">Table</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Class Filters and Export Actions -->
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 mb-6">
            <!-- Left: Class Filters -->
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by:</span>
                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-1.5">
                    <svg class="w-4 h-4 text-gray-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <select wire:model.live="filterClass" class="border-0 bg-transparent px-2 py-1 text-sm focus:ring-0 dark:text-white">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-1.5 {{ !$filterClass ? 'opacity-50' : '' }}">
                    <svg class="w-4 h-4 text-gray-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    <select wire:model.live="filterClassArm" class="border-0 bg-transparent px-2 py-1 text-sm focus:ring-0 dark:text-white" {{ !$filterClass ? 'disabled' : '' }}>
                        <option value="">{{ $filterClass ? 'All Arms' : 'Select Class' }}</option>
                        @if($filterClass)
                            @foreach($filterClassArms as $arm)
                            <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $users->total() }} {{ $users->total() === 1 ? 'user' : 'users' }}</span>
            </div>

            <!-- Right: Export Actions -->
            <div class="flex flex-wrap gap-2">
                <button wire:click="exportCsv" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Excel
                </button>
                <button wire:click="exportPdf" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    PDF
                </button>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors flex items-center gap-2 text-sm font-medium shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </button>
            </div>
        </div>

        @if($viewMode === 'grid')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 print-area">
            @forelse($users as $user)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                            <span class="text-emerald-600 dark:text-emerald-300 font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-white">{{ $user->name }}</h3>
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full {{ $user->role === 'student' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200' : 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-200' }}">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="truncate">{{ $user->email }}</span>
                    </div>
                    @if($user->student)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <span>{{ $user->student->admission_number }}</span>
                    </div>
                    @if($user->student->currentClass)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>{{ $user->student->currentClass->name }}</span>
                    </div>
                    @endif
                    @elseif($user->staff && $user->staff->staff_id)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                        <span>{{ $user->staff->staff_id }}</span>
                    </div>
                    @endif
                    <div>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @if(auth()->user()->role === 'school_admin')
                <div class="flex gap-2 pt-4 border-t border-gray-200 dark:border-gray-700 no-print">
                    <button wire:click="view('{{ $user->id }}')" class="flex-1 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 font-medium rounded-lg text-sm">
                        View
                    </button>
                    <button wire:click="toggleStatus('{{ $user->id }}')" class="flex-1 px-3 py-2 {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'bg-yellow-50 hover:bg-yellow-100 text-yellow-600' : 'bg-green-50 hover:bg-green-100 text-green-600' }} font-medium rounded-lg text-sm">
                        {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'Deactivate' : 'Activate' }}
                    </button>
                    <button wire:click="edit('{{ $user->id }}')" class="px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button wire:click="delete('{{ $user->id }}')" class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 dark:text-gray-400">No users found</p>
            </div>
            @endforelse
        </div>
        @else
        <div class="overflow-x-auto -mx-4 sm:mx-0 print-area">
            <div class="inline-block min-w-full align-middle">
                <div class="bg-white dark:bg-gray-800 sm:rounded-xl shadow-sm border-0 sm:border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        @if($filterRole === 'staff')
                        <!-- Staff Table -->
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">S/N</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Staff Number</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase no-print">Status</th>
                                @if(auth()->user()->role === 'school_admin')
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase no-print">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->staff?->staff_id ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->staff?->gender ? ucfirst($user->staff->gender) : '-' }}</td>
                                <td class="px-6 py-4 no-print"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $user->staff && $user->staff->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $user->staff && $user->staff->status === 'active' ? 'Active' : 'Inactive' }}</span></td>
                                @if(auth()->user()->role === 'school_admin')
                                <td class="px-6 py-4 text-right no-print">
                                    <div class="inline-flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-1">
                                        <button wire:click="view('{{ $user->id }}')" class="p-2 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button wire:click="toggleStatus('{{ $user->id }}')" class="p-2 {{ $user->staff && $user->staff->status === 'active' ? 'text-yellow-600 hover:bg-yellow-100' : 'text-green-600 hover:bg-green-100' }} rounded-md transition-colors" title="{{ $user->staff && $user->staff->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $user->staff && $user->staff->status === 'active' ? '18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                                        </button>
                                        <button wire:click="edit('{{ $user->id }}')" class="p-2 text-blue-600 hover:bg-blue-100 rounded-md transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="delete('{{ $user->id }}')" class="p-2 text-red-600 hover:bg-red-100 rounded-md transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">No staff found</td></tr>
                            @endforelse
                        </tbody>
                        @else
                        <!-- Student Table -->
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">S/N</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Admission Number</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Class</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Class Arm</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase no-print">Status</th>
                                @if(auth()->user()->role === 'school_admin')
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase no-print">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->student ? $user->student->admission_number : ($user->staff ? $user->staff->staff_id : '-') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->student?->currentClass?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->student?->classArm?->name ?? '-' }}</td>
                                <td class="px-6 py-4 no-print"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'Active' : 'Inactive' }}</span></td>
                                @if(auth()->user()->role === 'school_admin')
                                <td class="px-6 py-4 text-right no-print">
                                    <div class="inline-flex items-center gap-1 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-1">
                                        <button wire:click="view('{{ $user->id }}')" class="p-2 text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md transition-colors" title="View Details">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                        <button wire:click="toggleStatus('{{ $user->id }}')" class="p-2 {{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'text-yellow-600 hover:bg-yellow-100' : 'text-green-600 hover:bg-green-100' }} rounded-md transition-colors" title="{{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? 'Deactivate' : 'Activate' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ ($user->student && $user->student->status === 'active') || ($user->staff && $user->staff->status === 'active') ? '18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' : '9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path></svg>
                                        </button>
                                        <button wire:click="edit('{{ $user->id }}')" class="p-2 text-blue-600 hover:bg-blue-100 rounded-md transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </button>
                                        <button wire:click="delete('{{ $user->id }}')" class="p-2 text-red-600 hover:bg-red-100 rounded-md transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">No users found</td></tr>
                            @endforelse
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-6">{{ $users->links() }}</div>
    </div>

    @if($showModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl p-6 max-h-[90vh] overflow-y-auto">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $userId ? 'Edit User' : 'Add ' . ($role ? ucfirst($role) : 'User') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name *</label>
                            <input wire:model="name" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @if($role === 'staff')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                            <input wire:model="email" type="email" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password {{ $userId ? '' : '*' }}</label>
                            <input wire:model="password" type="password" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white" placeholder="{{ $userId ? 'Leave blank to keep current' : '' }}">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @if(!$userId)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role *</label>
                            <select wire:model.live="role" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Role</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                            </select>
                            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif
                        @endif

                        @if($role === 'student')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admission Number *</label>
                            <input wire:model="admission_number" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('admission_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class *</label>
                            <select wire:model.live="current_class_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('current_class_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class Arm *</label>
                            <select wire:model="class_arm_id" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white" {{ !$current_class_id ? 'disabled' : '' }}>
                                <option value="">{{ $current_class_id ? 'Select Class Arm' : 'Select Class First' }}</option>
                                @foreach($classArms as $arm)
                                <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                                @endforeach
                            </select>
                            @error('class_arm_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @elseif($role === 'staff')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Staff ID</label>
                            <input wire:model="staff_id" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('staff_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        @if($role)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date of Birth</label>
                            <input wire:model="date_of_birth" type="date" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gender</label>
                            <select wire:model="gender" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Group</label>
                            <select wire:model="blood_group" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                            @error('blood_group') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admission Date</label>
                            <input wire:model="admission_date" type="date" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('admission_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                            <textarea wire:model="address" rows="2" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white"></textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Guardian Name</label>
                            <input wire:model="guardian_name" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('guardian_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Guardian Phone</label>
                            <input wire:model="guardian_phone" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('guardian_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Guardian Email</label>
                            <input wire:model="guardian_email" type="email" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('guardian_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Guardian Relationship</label>
                            <input wire:model="guardian_relationship" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('guardian_relationship') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Emergency Contact</label>
                            <input wire:model="emergency_contact" type="text" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                            @error('emergency_contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                            <select wire:model="status" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Medical Conditions</label>
                            <textarea wire:model="medical_conditions" rows="2" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:text-white"></textarea>
                            @error('medical_conditions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        @endif
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button wire:click="closeModal" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors disabled:opacity-50">Cancel</button>
                        <button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showDeleteModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-10 w-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Delete User?</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">This will permanently delete the user and all associated data.</p>
                    <div class="flex gap-3">
                        <button wire:click="closeModal" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors disabled:opacity-50">Cancel</button>
                        <button wire:click="confirmDelete" wire:loading.attr="disabled" wire:target="confirmDelete" class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="confirmDelete">Yes, Delete</span>
                            <svg wire:loading wire:target="confirmDelete" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showViewModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-3xl p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex items-start gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center flex-shrink-0">
                            <span class="text-emerald-600 dark:text-emerald-300 font-bold text-2xl">{{ substr($name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $email }}</p>
                            <div class="flex gap-2 mt-2">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $role === 'student' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">{{ ucfirst($role) }}</span>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ ucfirst($status) }}</span>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        @if($role === 'student')
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Student Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div><span class="text-xs text-gray-500 dark:text-gray-400">Admission Number:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $admission_number }}</p></div>
                                @if($current_class_id)
                                <div><span class="text-xs text-gray-500 dark:text-gray-400">Class:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $classes->find($current_class_id)?->name ?? '-' }}</p></div>
                                @endif
                                @if($class_arm_id)
                                <div><span class="text-xs text-gray-500 dark:text-gray-400">Class Arm:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $classArms->find($class_arm_id)?->name ?? '-' }}</p></div>
                                @endif
                            </div>
                        </div>
                        @elseif($role === 'staff' && $staff_id)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Staff Information</h4>
                                <button wire:click="viewStaffSubjects('{{ $userId }}')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    View Subjects
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div><span class="text-xs text-gray-500 dark:text-gray-400">Staff ID:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $staff_id }}</p></div>
                            </div>
                        </div>
                        @endif

                        @if($date_of_birth || $gender || $blood_group)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Personal Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                @if($date_of_birth)<div><span class="text-xs text-gray-500 dark:text-gray-400">Date of Birth:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($date_of_birth)->format('M d, Y') }}</p></div>@endif
                                @if($gender)<div><span class="text-xs text-gray-500 dark:text-gray-400">Gender:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($gender) }}</p></div>@endif
                                @if($blood_group)<div><span class="text-xs text-gray-500 dark:text-gray-400">Blood Group:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $blood_group }}</p></div>@endif
                                @if($admission_date)<div><span class="text-xs text-gray-500 dark:text-gray-400">Admission Date:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($admission_date)->format('M d, Y') }}</p></div>@endif
                            </div>
                        </div>
                        @endif

                        @if($address)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Address</h4>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $address }}</p>
                        </div>
                        @endif

                        @if($guardian_name || $guardian_phone || $guardian_email)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Guardian Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                @if($guardian_name)<div><span class="text-xs text-gray-500 dark:text-gray-400">Name:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $guardian_name }}</p></div>@endif
                                @if($guardian_phone)<div><span class="text-xs text-gray-500 dark:text-gray-400">Phone:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $guardian_phone }}</p></div>@endif
                                @if($guardian_email)<div><span class="text-xs text-gray-500 dark:text-gray-400">Email:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $guardian_email }}</p></div>@endif
                                @if($guardian_relationship)<div><span class="text-xs text-gray-500 dark:text-gray-400">Relationship:</span><p class="text-sm font-medium text-gray-900 dark:text-white">{{ $guardian_relationship }}</p></div>@endif
                            </div>
                        </div>
                        @endif

                        @if($emergency_contact)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Emergency Contact</h4>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $emergency_contact }}</p>
                        </div>
                        @endif

                        @if($medical_conditions)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Medical Conditions</h4>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $medical_conditions }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors">Close</button>
                        <button wire:click="edit('{{ $userId }}')" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showImportModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Import Students from Excel</h3>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Upload an Excel file with columns: name, admission_number, gender</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class *</label>
                        <select wire:model.live="importClassId" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('importClassId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Class Arm *</label>
                        <select wire:model="importClassArmId" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg" {{ !$importClassId ? 'disabled' : '' }}>
                            <option value="">{{ $importClassId ? 'Select Class Arm' : 'Select Class First' }}</option>
                            @foreach($classArms as $arm)
                            <option value="{{ $arm->id }}">{{ $arm->name }}</option>
                            @endforeach
                        </select>
                        @error('importClassArmId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excel File *</label>
                        <input wire:model="importFile" type="file" accept=".xlsx,.xls,.csv" class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg">
                        @error('importFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex gap-3">
                        <button wire:click="closeModal" class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg">Cancel</button>
                        <button wire:click="importStudents" wire:loading.attr="disabled" class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg disabled:opacity-50">Import</button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    @if($showSubjectsModal)
        @teleport('body')
        <div class="fixed inset-0 z-50 overflow-y-auto" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="absolute inset-0" wire:click="closeModal"></div>
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Assigned Subjects (Current Term)</h3>
                    @if(count($staffSubjects) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Subject</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Class</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($staffSubjects as $item)
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $item['subject'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $item['class'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">No subjects assigned for current term</p>
                    @endif
                    <div class="mt-6">
                        <button wire:click="closeModal" class="w-full px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>
