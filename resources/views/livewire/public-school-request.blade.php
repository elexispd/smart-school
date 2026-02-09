<div class="min-h-screen bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
    <!-- Floating School Items Background - Subtle -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
        <div class="absolute top-10 left-5 animate-float"><svg class="w-16 h-16 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1z"/></svg></div>
        <div class="absolute top-32 right-10 animate-float-slow"><svg class="w-20 h-20 text-teal-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/></svg></div>
        <div class="absolute bottom-20 left-20 animate-float-delayed"><svg class="w-18 h-18 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg></div>
        <div class="absolute top-1/4 right-1/4 animate-float"><svg class="w-14 h-14 text-teal-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8v12c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V8c0-1.86 1.28-3.41 3-3.86V2h3v2h4V2h3v2.14c1.72.45 3 2 3 3.86z"/></svg></div>
        <div class="absolute bottom-1/3 right-16 animate-float-slow"><svg class="w-16 h-16 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1z"/></svg></div>
        <div class="absolute top-1/2 left-1/3 animate-float-delayed"><svg class="w-12 h-12 text-teal-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/></svg></div>
        <div class="absolute top-2/3 right-1/3 animate-float"><svg class="w-14 h-14 text-emerald-300" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg></div>
        <div class="absolute bottom-10 right-1/4 animate-float-slow"><svg class="w-16 h-16 text-teal-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20 8v12c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V8c0-1.86 1.28-3.41 3-3.86V2h3v2h4V2h3v2.14c1.72.45 3 2 3 3.86z"/></svg></div>
    </div>

    <style>
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes float-slow { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-30px); } }
        @keyframes float-delayed { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-25px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 7s ease-in-out infinite; }
    </style>

    <!-- Content -->
    <div class="relative z-10 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        @if($submitted)
            <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-12 text-center">
                <div class="w-24 h-24 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Request Submitted Successfully!</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">Thank you for your interest. Our team will review your request and contact you within 24-48 hours.</p>
                <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Home
                </a>
            </div>
        @else
            <div class="max-w-7xl mx-auto space-y-8">
                <!-- Header -->
                <div class="text-center space-y-4">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl mb-4">
                        <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Request School Onboarding</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Join our platform and transform your school's digital experience</p>
                </div>

                <form wire:submit="submit" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- LEFT SIDE -->
                    <div class="space-y-6">
                        <!-- School Information -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold">1</div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">School Information</h2>
                                    <p class="text-gray-500 dark:text-gray-400">Basic details about your institution</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">School Full Name *</label>
                                    <input type="text" wire:model="school_name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('school_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Acronym</label>
                                    <input type="text" wire:model="acronym" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="e.g. SHS">
                                    @error('acronym') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">School Email *</label>
                                    <input type="email" wire:model="school_email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('school_email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Phone Number *</label>
                                    <input type="tel" wire:model="phone" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">School Motto <span class="text-gray-400 font-normal">(Optional)</span></label>
                                    <input type="text" wire:model="moto" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Excellence in Education">
                                    @error('moto') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Details -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl font-bold">3</div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Location Details</h2>
                                    <p class="text-gray-500 dark:text-gray-400">Physical address of the campus</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Address *</label>
                                    <input type="text" wire:model="address" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">City *</label>
                                    <input type="text" wire:model="city" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">State *</label>
                                    <input type="text" wire:model="state" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('state') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Country *</label>
                                    <input type="text" wire:model="country" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="space-y-6">
                        <!-- Admin Credentials -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-bold">2</div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Credentials</h2>
                                    <p class="text-gray-500 dark:text-gray-400">Account details for school administrator</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                                    <input type="text" wire:model="admin_name" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('admin_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                                    <input type="email" wire:model="admin_email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    @error('admin_email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                                    <input type="password" wire:model="admin_password" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Minimum 8 characters">
                                    @error('admin_password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Message -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                                <div class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center text-xl font-bold">4</div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Additional Information</h2>
                                    <p class="text-gray-500 dark:text-gray-400">Tell us more about your school</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Message <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <textarea wire:model="message" rows="10" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Tell us more about your school..."></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="lg:col-span-2 pt-6 flex items-center justify-between">
                        <a href="/" class="inline-flex items-center gap-2 px-6 py-3 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Back to Home
                        </a>
                        <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <span wire:loading.remove wire:target="submit">Submit Request</span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Processing...
                            </span>
                            <svg wire:loading.remove wire:target="submit" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
