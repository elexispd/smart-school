<?php

use Livewire\Volt\Component;

new class extends Component
{
    //
}; ?>

@php
    $user = auth()->user();
    $isSchoolUser = $user->school_id && ($user->hasRole('school_admin') || $user->hasRole('teacher'));
    $isPlatformUser = $user->hasRole('super_admin');
@endphp

@if($isSchoolUser)
    @include('livewire.layout.school-sidebar')
@elseif($isPlatformUser)
    @include('livewire.layout.platform-sidebar')
@else
    {{-- Student or other roles --}}
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
            <div>
                <div class="px-2 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Main</div>
                <div class="space-y-1">
                    <a href="{{ route('student.dashboard') }}" wire:navigate class="{{ request()->routeIs('student.dashboard') ? 'flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-xl transition-colors' : 'flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-xl transition-colors group' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('student.dashboard') ? 'text-emerald-600' : 'text-gray-400 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        My Progress
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
@endif
