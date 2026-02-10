<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('school.class-arms') }}" wire:navigate class="inline-flex items-center text-sm text-gray-600 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Class Arms
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Assign Subjects to {{ $classArm->name }}</h2>
        <p class="text-gray-600 dark:text-gray-400">Class: {{ $classArm->schoolClass->name }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Select subjects specific to this class arm. Students in this arm will take these subjects in addition to class-level compulsory subjects.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($subjects as $subject)
            @php
                $isInherited = in_array($subject->id, $classSubjectIds);
                $isAssigned = in_array($subject->id, $assignedSubjectIds);
                $isChecked = $isInherited || $isAssigned;
            @endphp
            <div wire:click="{{ $isInherited ? '' : 'toggleSubject(\'' . $subject->id . '\')' }}" 
                 class="relative bg-white dark:bg-gray-800 rounded-xl shadow-sm border-2 {{ $isChecked ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-600' }} p-6 {{ $isInherited ? 'cursor-not-allowed opacity-75' : 'cursor-pointer' }} transition-all group"
                 wire:loading.class="opacity-50">
                
                @if($isChecked)
                    <div class="absolute top-3 right-3 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                @endif

                @if($isInherited)
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            From Class
                        </span>
                    </div>
                @endif

                <div class="flex items-start gap-3 {{ $isInherited ? 'mt-6' : '' }}">
                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 dark:group-hover:bg-emerald-900/50 transition-colors">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">{{ $subject->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $subject->code }}</p>
                    </div>
                </div>

                @if(!$isInherited)
                <div wire:loading wire:target="toggleSubject('{{ $subject->id }}')" class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 rounded-xl flex items-center justify-center">
                    <svg class="animate-spin h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <p class="mt-4 text-gray-500 dark:text-gray-400">No subjects available</p>
            </div>
        @endforelse
    </div>
</div>
