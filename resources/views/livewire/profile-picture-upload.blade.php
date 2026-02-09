<div class="flex flex-col items-center gap-4">
    <div class="relative group">
        @if ($photo)
            <img src="{{ $photo->temporaryUrl() }}" class="w-32 h-32 rounded-full object-cover border-4 border-emerald-500 shadow-xl">
        @elseif ($currentPhoto)
            <img src="{{ Storage::url($currentPhoto) }}" class="w-32 h-32 rounded-full object-cover border-4 border-white/30 shadow-xl">
        @else
            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-5xl font-bold text-white border-4 border-white/30 shadow-xl">
                {{ strtoupper(substr($model->name ?? 'U', 0, 1)) }}
            </div>
        @endif
        
        @if ($currentPhoto && !$photo)
            <button wire:click="remove" type="button" class="absolute top-0 right-0 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 text-red-600 rounded-full p-2 shadow-lg transition-all opacity-0 group-hover:opacity-100" title="Remove photo">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        @endif
    </div>

    <div class="flex gap-3">
        <label class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-semibold rounded-lg cursor-pointer transition-all border border-white/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ $photo ? 'Change' : 'Upload' }}
            <input type="file" wire:model="photo" accept="image/*" class="hidden">
        </label>

        @if ($photo)
            <button wire:click="save" type="button" class="px-4 py-2 bg-white hover:bg-gray-100 text-emerald-600 font-semibold rounded-lg transition-all shadow-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Save
            </button>
        @endif
    </div>

    @error('photo') 
        <span class="text-red-100 text-sm bg-red-500/20 px-3 py-1 rounded-lg">{{ $message }}</span> 
    @enderror

    <div wire:loading wire:target="photo,save" class="text-sm text-white/80 bg-white/10 px-3 py-1 rounded-lg backdrop-blur-sm">
        <svg class="animate-spin h-4 w-4 inline" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
    </div>
</div>
