<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">Onboard New School</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Register a new institution and its administrator.
            </p>
        </div>

        <!-- Main Form -->
        <form wire:submit="register" class="space-y-6">
            <!-- School Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-subtle hover-lift p-6 md:p-8 space-y-6 border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">1</div>
                     <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">School Information</h2>
                        <p class="text-base text-gray-500 dark:text-gray-400">Basic details about the institution</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">School Full Name</label>
                        <input type="text" wire:model="school_name" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="e.g. Springfield High School">
                        @error('school_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Acronym</label>
                        <input type="text" wire:model="acronym" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="e.g. SHS">
                        @error('acronym') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Admin Credentials Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-subtle hover-lift p-6 md:p-8 space-y-6 border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold">2</div>
                     <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Credentials</h2>
                        <p class="text-base text-gray-500 dark:text-gray-400">Setup the primary administrator account</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Admin Name</label>
                        <input type="text" wire:model="admin_name" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="Full Name">
                        @error('admin_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
                        <input type="email" wire:model="admin_email" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="admin@school.com">
                        @error('admin_email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" wire:model="admin_password" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="********">
                        @error('admin_password') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-subtle hover-lift p-6 md:p-8 space-y-6 border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl font-bold">3</div>
                     <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Information</h2>
                        <p class="text-base text-gray-500 dark:text-gray-400">How to reach the school</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">School Email</label>
                        <input type="email" wire:model="school_email" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="info@school.com">
                        @error('school_email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Phone Number</label>
                        <input type="text" wire:model="school_phone" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="+1 234 567 8900">
                        @error('school_phone') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">School Moto <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <input type="text" wire:model="school_moto" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="Excellence in Education">
                        @error('school_moto') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Location Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-subtle hover-lift p-6 md:p-8 space-y-6 border border-gray-100 dark:border-gray-700 animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold">4</div>
                     <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Location Details</h2>
                        <p class="text-base text-gray-500 dark:text-gray-400">Physical address of the campus</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Address</label>
                        <input type="text" wire:model="address" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="123 Education Lane">
                        @error('address') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">City</label>
                            <input type="text" wire:model="city" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="New York">
                            @error('city') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">State</label>
                            <input type="text" wire:model="state" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="NY">
                            @error('state') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Country</label>
                            <input type="text" wire:model="country" class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 transition-colors" placeholder="United States">
                            @error('country') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button type="submit" wire:loading.attr="disabled" wire:target="register" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-xl transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="register">
                        Complete Registration
                    </span>
                    <span wire:loading wire:target="register">
                        Processing...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
