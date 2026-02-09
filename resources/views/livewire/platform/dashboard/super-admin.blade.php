@php
    $totalSchools = \App\Models\School::count();
    $activeSchools = \App\Models\School::where('is_active', true)->count();
    $totalStudents = \App\Models\Student::count();
    $totalStaff = \App\Models\Staff::count();
    $totalUsers = \App\Models\User::count();
    $recentSchools = \App\Models\School::latest()->take(5)->get();
@endphp

<x-app-layout>
    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="mag-card mag-card-emerald p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Schools</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalSchools }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-medium bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $activeSchools }} Active
                    </span>
                    <span class="text-gray-400 mx-2">•</span>
                    <span class="text-gray-500 dark:text-gray-400">{{ $totalSchools - $activeSchools }} Inactive</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="mag-card mag-card-blue p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalStudents) }}</h3>
                    </div>
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Across all schools</span>
                </div>
            </div>

             <!-- Card 3 -->
            <div class="mag-card mag-card-orange p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Staff</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalStaff) }}</h3>
                    </div>
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl text-orange-600 dark:text-orange-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Across all schools</span>
                </div>
            </div>

             <!-- Card 4 -->
            <div class="mag-card mag-card-purple p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalUsers) }}</h3>
                    </div>
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl text-purple-600 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">System-wide</span>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Table Section -->
            <div class="lg:col-span-2 mag-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Active Schools</h3>
                        <p class="text-sm text-gray-500 mt-1">Manage registered institutions</p>
                    </div>
                    <a href="{{ route('super_admin.schools') }}" wire:navigate class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1 hover:gap-2 transition-all">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-700">
                                <th class="pb-3 font-medium">School Name</th>
                                <th class="pb-3 font-medium">Onboarding</th>
                                <th class="pb-3 font-medium">Status</th>
                                <th class="pb-3 font-medium">Admin</th>
                                <th class="pb-3 font-medium"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentSchools as $school)
                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-lg shadow-sm">🏫</div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $school->name }}</p>
                                            <p class="text-xs text-gray-500">{{ collect([$school->city, $school->country])->filter()->implode(', ') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: 100%"></div>
                                        </div>
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-400">100%</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $school->is_active ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900' : 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 border border-red-100 dark:border-red-900' }}">{{ $school->is_active ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td class="py-4">
                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white dark:border-gray-800 flex items-center justify-center text-xs font-bold text-gray-600 shadow-sm">{{ strtoupper(substr($school->name, 0, 2)) }}</div>
                                    </div>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('super_admin.schools') }}" wire:navigate class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                    No schools registered yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="mag-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">System Load</h3>
                    <div class="text-emerald-500 bg-emerald-50 rounded-lg p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>

                <div class="relative flex items-center justify-center py-4">
                    <!-- Circular Progress Placeholder -->
                    <div class="w-48 h-48 rounded-full border-8 border-gray-50 dark:border-gray-700 flex items-center justify-center relative shadow-inner">
                        <div class="absolute inset-0 rounded-full border-8 border-emerald-500 border-t-transparent rotate-45" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);"></div>
                        <div class="text-center">
                            <span class="block text-4xl font-bold text-gray-900 dark:text-white">64%</span>
                            <span class="text-sm text-gray-500">Capacity Used</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="text-center p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="text-emerald-500 mb-1">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">8</div>
                        <div class="text-xs text-gray-500">Servers</div>
                    </div>
                     <div class="text-center p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="text-blue-500 mb-1">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">12</div>
                        <div class="text-xs text-gray-500">Jobs</div>
                    </div>
                     <div class="text-center p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 transition-colors cursor-pointer">
                        <div class="text-orange-500 mb-1">
                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-lg font-bold text-gray-900 dark:text-white">14</div>
                        <div class="text-xs text-gray-500">Queued</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
