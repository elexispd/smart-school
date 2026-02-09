<div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Bulk User Import</h3>
    
    <form wire:submit="import" class="space-y-4">
        <div>
            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Excel/CSV File</label>
            <input type="file" wire:model="file" id="file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
            @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Import Users') }}
            </x-primary-button>
            
            <div wire:loading wire:target="import" class="text-sm text-gray-500">
                Importing...
            </div>
        </div>

        @if (session()->has('status'))
            <div class="text-green-600 text-sm">
                {{ session('status') }}
            </div>
        @endif
    </form>
</div>
