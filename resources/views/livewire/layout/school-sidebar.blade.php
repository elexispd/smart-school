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
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Academic Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Academic</div>
            <div x-data="{ open: false }" class="space-y-1">
                <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Classes & Subjects
                    </div>
                    <svg :class="{'rotate-180': open}" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" x-transition class="pl-10 pr-2 space-y-1 mt-1">
                    <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Class</a>
                    <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Class Arm</a>
                    <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">Subjects</a>
                </div>
            </div>
        </div>

        <!-- People Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">People</div>
            <div class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Students
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Teachers
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Board Members
                </a>
            </div>
        </div>

        <!-- Assessment Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Assessment</div>
            <div class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Scoresheet
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Result Mastersheet
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Compilation
                </a>
            </div>
        </div>

        <!-- Finance Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Finance</div>
            <div class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Fee Management
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Fees Manager
                </a>
            </div>
        </div>

        <!-- Administration Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</div>
            <div class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Session & Term
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Broadcast
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Reports
                </a>
            </div>
        </div>

        <!-- Account Section -->
        <div>
            <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Account</div>
            <div class="space-y-1">
                <a href="{{ route('profile') }}" wire:navigate class="{{ request()->routeIs('profile') ? 'flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-xl' : 'flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    My Profile
                </a>
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
