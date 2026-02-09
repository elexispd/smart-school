<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Activity Logs</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track system and school activities</p>
        </div>

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <nav class="flex gap-8">
                <button
                    wire:click="switchTab('saas')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'saas' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    SAAS Logs
                </button>
                <button
                    wire:click="switchTab('school')"
                    class="py-4 px-1 border-b-2 font-medium text-sm transition-colors {{ $activeTab === 'school' ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    School Logs
                </button>
            </nav>
        </div>

        <!-- Filters -->
        <div class="mb-6 flex gap-4">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search activities..."
                class="flex-1 px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-emerald-500 focus:ring-emerald-500"
            >
            @if($activeTab === 'school')
                <select
                    wire:model.live="selectedSchool"
                    class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">All Schools</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md">
            @if($activities->count())
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($activities as $activity)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full {{ $activeTab === 'saas' ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30' }} flex items-center justify-center">
                                        <svg class="w-5 h-5 {{ $activeTab === 'saas' ? 'text-blue-600 dark:text-blue-400' : 'text-emerald-600 dark:text-emerald-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-base font-semibold text-gray-900 dark:text-white">
                                                {{ $activity->description }}
                                            </p>
                                            <div class="mt-2 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                @if($activity->causer)
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                        {{ $activity->causer->name }}
                                                    </span>
                                                @endif
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ $activity->created_at->format('M d, Y h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($activity->properties && count($activity->properties) > 0)
                                        <div class="mt-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                                            @if(isset($activity->properties['attributes']) && isset($activity->properties['old']))
                                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Changes Made:</h4>
                                                <div class="space-y-2">
                                                    @foreach($activity->properties['attributes'] as $key => $newValue)
                                                        @if(isset($activity->properties['old'][$key]) && $activity->properties['old'][$key] != $newValue)
                                                            <div class="text-sm">
                                                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                                <div class="ml-4 mt-1">
                                                                    <div class="flex items-center gap-2">
                                                                        <span class="text-red-600 dark:text-red-400 line-through">{{ is_array($activity->properties['old'][$key]) ? json_encode($activity->properties['old'][$key]) : $activity->properties['old'][$key] }}</span>
                                                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                                                        <span class="text-green-600 dark:text-green-400 font-medium">{{ is_array($newValue) ? json_encode($newValue) : $newValue }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @elseif(isset($activity->properties['attributes']))
                                                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Details:</h4>
                                                <div class="space-y-1">
                                                    @foreach($activity->properties['attributes'] as $key => $value)
                                                        @if(!is_array($value))
                                                        <div class="text-sm">
                                                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                            <span class="text-gray-600 dark:text-gray-400">{{ $value }}</span>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No activity logs found</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $activeTab === 'saas' ? 'SAAS' : 'School' }} activity logs will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>
