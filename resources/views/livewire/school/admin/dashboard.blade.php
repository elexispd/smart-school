@php
    $totalStudents = \App\Models\Student::count();
    $activeStudents = \App\Models\Student::where('status', 'active')->count();
    $totalStaff = \App\Models\Staff::count();
    $activeStaff = \App\Models\Staff::where('status', 'active')->count();
    $totalClasses = \App\Models\SchoolClass::where('is_active', true)->count();
    $currentSession = \App\Models\Session::where('is_current', true)->first();

    $classDistribution = \App\Models\SchoolClass::where('is_active', true)
        ->withCount('classArms')
        ->get()
        ->map(function($class) {
            $studentCount = \App\Models\Student::whereHas('classArm', fn($q) => $q->where('class_id', $class->id))->count();
            return [
                'name' => $class->name,
                'students' => $studentCount,
                'arms' => $class->class_arms_count,
            ];
        });

    $totalCapacity = $totalStudents > 0 ? $totalStudents : 1;
    $recentStudents = \App\Models\Student::with(['user', 'currentClass'])->latest()->take(5)->get();
@endphp

<x-app-layout>
    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                    <span class="flex items-center text-blue-600 dark:text-blue-400 font-medium bg-blue-50 dark:bg-blue-900/20 px-2 py-0.5 rounded-full">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        {{ $activeStudents }} Active
                    </span>
                    <span class="text-gray-400 mx-2">•</span>
                    <span class="text-gray-500 dark:text-gray-400">{{ $totalStudents - $activeStudents }} Inactive</span>
                </div>
            </div>

            <div class="mag-card mag-card-purple p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Staff</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalStaff) }}</h3>
                    </div>
                    <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl text-purple-600 dark:text-purple-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center text-purple-600 dark:text-purple-400 font-medium bg-purple-50 dark:bg-purple-900/20 px-2 py-0.5 rounded-full">
                        {{ $activeStaff }} Active
                    </span>
                    <span class="text-gray-400 mx-2">•</span>
                    <span class="text-gray-500 dark:text-gray-400">{{ $totalStaff - $activeStaff }} Inactive</span>
                </div>
            </div>

            <div class="mag-card mag-card-emerald p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Classes</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalClasses }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Active classes</span>
                </div>
            </div>

            <div class="mag-card mag-card-orange p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Session</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mt-2">{{ $currentSession?->name ?? 'Not Set' }}</h3>
                    </div>
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/20 rounded-xl text-orange-600 dark:text-orange-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">{{ $currentSession ? ucfirst($currentSession->current_term) . ' Term' : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">


            <!-- Recent Students -->
            <div class="lg:col-span-3 mag-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Students</h3>
                        <p class="text-sm text-gray-500 mt-1">Latest student registrations</p>
                    </div>
                    <a href="{{ route('school.users', ['filter' => 'student']) }}" wire:navigate class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1 hover:gap-2 transition-all">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase border-b border-gray-100 dark:border-gray-700">
                                <th class="pb-3 font-medium">Student</th>
                                <th class="pb-3 font-medium">Admission No</th>
                                <th class="pb-3 font-medium">Class</th>
                                <th class="pb-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentStudents as $student)
                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold shadow-sm">
                                            {{ substr($student->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $student->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $student->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $student->admission_number }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $student->currentClass?->name ?? '-' }}</span>
                                </td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-gray-50 text-gray-600' }}">
                                        {{ ucfirst($student->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 dark:text-gray-400">No students registered yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

             <!-- Quick Actions Sidebar -->
            <div class="mag-card p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('school.users', ['filter' => 'student']) }}" wire:navigate class="block relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl transform group-hover:scale-105 transition-transform duration-300"></div>
                        <div class="relative p-4 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">Add Student</h4>
                                <p class="text-blue-100 text-xs">Register new</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('school.users', ['filter' => 'staff']) }}" wire:navigate class="block relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl transform group-hover:scale-105 transition-transform duration-300"></div>
                        <div class="relative p-4 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">Manage Staff</h4>
                                <p class="text-purple-100 text-xs">View teachers</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('student-payments.index') }}" wire:navigate class="block relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl transform group-hover:scale-105 transition-transform duration-300"></div>
                        <div class="relative p-4 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">Record Payment</h4>
                                <p class="text-emerald-100 text-xs">Student fees</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('school.staff-assignments') }}" wire:navigate class="block relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl transform group-hover:scale-105 transition-transform duration-300"></div>
                        <div class="relative p-4 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-sm">Teacher Subjects</h4>
                                <p class="text-orange-100 text-xs">Assign subjects</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Student Enrollment Overview -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-4">Student Enrollment</h4>
                    <div class="space-y-4">
                        @forelse($classDistribution as $class)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $class['name'] }}</span>
                                </div>
                                <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $class['students'] }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-600 rounded-full transition-all" style="width: {{ $totalCapacity > 0 ? ($class['students'] / $totalCapacity * 100) : 0 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $class['arms'] }} section(s)</p>
                        </div>
                        @empty
                        <p class="text-center text-gray-500 dark:text-gray-400 py-4 text-sm">No classes available</p>
                        @endforelse
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
