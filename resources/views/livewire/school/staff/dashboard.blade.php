<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
             <div class="text-gray-500 dark:text-gray-400 text-sm uppercase">My Classes</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">--</div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
             <div class="text-gray-500 dark:text-gray-400 text-sm uppercase">Attendance Pending</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">--</div>
        </div>
    </div>
</x-app-layout>
