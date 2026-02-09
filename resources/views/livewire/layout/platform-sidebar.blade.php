<?php

use Livewire\Volt\Component;

new class extends Component
{
    //
}; ?>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto lg:flex lg:flex-col lg:h-screen lg:sticky lg:top-0">
    <!-- Logo -->
    <div class="px-6 py-8 flex items-center gap-3">
        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-500 text-white shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">ClassOptima</span>
    </div>

    <!-- Navigation -->
    <div class="flex-1 px-4 space-y-6 overflow-y-auto scrollbar-hide">
        <!-- Main Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</div>
            <div class="space-y-1">
                <!-- School Management Section -->
                <div x-data="{ open: {{ request()->routeIs('super_admin.dashboard', 'schools.onboard') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            School Management
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="pl-10 pr-2 space-y-1 mt-1">
                        @if(auth()->user()->hasPermission('view schools'))
                        <a href="{{ route('schools.onboard') }}" wire:navigate class="{{ request()->routeIs('schools.onboard') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            Onboarding Schools
                        </a>
                        @endif
                        @if(auth()->user()->hasPermission('view schools'))
                        <a href="{{ route('super_admin.dashboard') }}" wire:navigate class="{{ request()->routeIs('super_admin.dashboard') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            School Metrics
                        </a>
                        @endif
                        @if(auth()->user()->hasPermission('view schools'))
                        <a href="{{ route('super_admin.schools') }}" wire:navigate class="{{ request()->routeIs('super_admin.schools') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            School List
                        </a>
                        @endif
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            #Bulk School Import
                        </a>
                    </div>
                </div>

                <!-- User Administration Section -->
                <div x-data="{ open: {{ request()->routeIs('super_admin.users') ? 'true' : 'false' }} }" class="mt-2">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            User Administration
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="pl-10 pr-2 space-y-1 mt-1">
                        @if(auth()->user()->hasPermission('view users'))
                        <a href="{{ route('super_admin.users') }}" wire:navigate class="{{ request()->routeIs('super_admin.users') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            All Users
                        </a>
                        @endif
                        <a href="{{ route('super_admin.roles') }}" wire:navigate class="{{ request()->routeIs('super_admin.roles') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            User Roles & Permissions
                        </a>
                        <a href="{{ route('super_admin.activity_logs') }}" wire:navigate class="{{ request()->routeIs('super_admin.activity_logs') ? 'block px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg transition-colors' : 'block px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-colors' }}">
                            User Activity Logs
                        </a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            #User Analytics
                        </a>
                    </div>
                </div>

                <!-- System Configuration Section -->
                <div x-data="{ open: false }" class="mt-2">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            System Settings
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="pl-10 pr-2 space-y-1 mt-1">
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            General Configuration
                        </a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            Email Templates
                        </a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            #Integration Settings
                        </a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                            Backup & Restore
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer group">
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-medium text-gray-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-emerald-600 transition-colors">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-500 truncate">
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                </p>
            </div>
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</aside>
