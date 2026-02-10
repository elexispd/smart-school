<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('school.classes') }}" wire:navigate class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Classes
            </a>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Assign Subjects to {{ $class->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select compulsory subjects for this class</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subjects as $subject)
            <div wire:click="toggleSubject('{{ $subject->id }}')" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border-2 {{ in_array($subject->id, $selectedSubjects) ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20' : 'border-gray-200 dark:border-gray-700' }} p-4 cursor-pointer hover:border-emerald-400 transition-all">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $subject->name }}</h3>
                        @if($subject->code)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 font-mono">{{ $subject->code }}</p>
                        @endif
                    </div>
                    <div class="ml-3">
                        @if(in_array($subject->id, $selectedSubjects))
                        <svg class="w-6 h-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        @else
                        <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd"></path></svg>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div>
                    <h4 class="font-semibold text-blue-900 dark:text-blue-200">Selected: {{ count($selectedSubjects) }} subjects</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">Click on any subject card to add or remove it from this class</p>
                </div>
            </div>
        </div>
    </div>
</div>
