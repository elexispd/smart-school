<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 pb-12">
        <!-- Profile Header -->
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-lg"></div>
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <livewire:profile-picture-upload :model="auth()->user()" />
                    <div class="text-center sm:text-left flex-1">
                        <h1 class="text-4xl font-bold text-white mb-2">{{ auth()->user()->name }}</h1>
                        <p class="text-emerald-100 text-lg mb-4">{{ auth()->user()->email }}</p>
                        <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                {{ ucfirst(auth()->user()->role ?? 'User') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-white/20 backdrop-blur-sm text-white border border-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Joined {{ auth()->user()->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Update Profile Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Profile Information</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update your account details</p>
                        </div>
                    </div>
                    <livewire:profile.update-profile-information-form />
                </div>

                <!-- Update Password -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Security</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Manage your password</p>
                        </div>
                    </div>
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="mt-6">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/10 dark:to-orange-900/10 rounded-2xl shadow-lg border border-red-200 dark:border-red-900/30 p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-xl">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Danger Zone</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Permanently delete your account</p>
                        </div>
                    </div>
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
