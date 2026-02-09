<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
            }
            @keyframes float-slow {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-15px) rotate(-3deg); }
            }
            @keyframes float-slower {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-10px) rotate(2deg); }
            }
            @keyframes drift {
                0%, 100% { transform: translate(0, 0) rotate(0deg); }
                33% { transform: translate(10px, -10px) rotate(3deg); }
                66% { transform: translate(-10px, 10px) rotate(-3deg); }
            }
            @keyframes drift-slow {
                0%, 100% { transform: translate(0, 0) rotate(0deg); }
                50% { transform: translate(-15px, -15px) rotate(-5deg); }
            }
            .float-animation { animation: float 6s ease-in-out infinite; }
            .float-animation-slow { animation: float-slow 8s ease-in-out infinite; }
            .float-animation-slower { animation: float-slower 10s ease-in-out infinite; }
            .drift-animation { animation: drift 12s ease-in-out infinite; }
            .drift-animation-slow { animation: drift-slow 15s ease-in-out infinite; }
            
            .wave-pattern {
                background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
                position: relative;
                overflow: hidden;
            }
            .wave-pattern::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: 
                    radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(96, 165, 250, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(147, 197, 253, 0.1) 0%, transparent 50%);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex bg-gradient-to-br from-gray-50 to-gray-100 lg:bg-white">
            <!-- Left Side - Illustration -->
            <div class="hidden lg:flex lg:w-1/2 wave-pattern relative flex-col justify-center items-center text-center p-12">
                <!-- Floating Elements -->
                <div class="absolute top-20 left-20 float-animation opacity-60">
                    <svg class="w-12 h-12 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5z"/>
                    </svg>
                </div>
                <div class="absolute top-40 right-32 float-animation-slow opacity-50">
                    <svg class="w-10 h-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div class="absolute bottom-32 left-32 float-animation-slower opacity-50">
                    <svg class="w-14 h-14 text-blue-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/>
                    </svg>
                </div>
                <div class="absolute top-1/2 right-20 float-animation opacity-40">
                    <svg class="w-8 h-8 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                </div>
                <div class="absolute bottom-20 right-40 float-animation-slow opacity-50">
                    <svg class="w-10 h-10 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.5 4.5c-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5-1.45 0-3.15.3-4.5 1.05v13.65c1.35-.75 3.05-1.05 4.5-1.05 1.95 0 4.05.4 5.5 1.5 1.45-1.1 3.55-1.5 5.5-1.5 1.45 0 3.15.3 4.5 1.05V5.55c-1.35-.75-3.05-1.05-4.5-1.05z"/>
                    </svg>
                </div>
                
                <div class="relative z-10 max-w-lg">
                    <div class="flex items-center justify-center mb-8">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center shadow-lg">
                            <img src="{{ asset('images/app_logo.png') }}" alt="App Logo" class="w-10 h-10 object-contain">
                        </div>
                        <span class="ml-3 text-2xl font-bold text-blue-900">Class Optima</span>
                    </div>
                    
                    <h1 class="text-5xl font-extrabold text-blue-600 mb-2 leading-tight">
                        Simplify <span class="relative inline-block">
                            Scheduling
                            <svg class="absolute w-full h-4 -bottom-2 left-0" viewBox="0 0 200 10" preserveAspectRatio="none">
                                <path d="M0 5 Q 100 10 200 5" stroke="#fb923c" stroke-width="4" fill="none" />
                            </svg>
                        </span>
                    </h1>
                    <h2 class="text-4xl font-bold text-blue-500 mb-12">
                        And Timetable<br>Management
                    </h2>
                    
                    <!-- 3D Characters -->
                    <div class="relative h-80 w-full flex justify-center items-end mt-8">
                        <div class="text-9xl">👩🎓👨🎓</div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-4 sm:p-8 relative overflow-hidden">
                <!-- Subtle Animated Objects on White Background -->
                <div class="absolute top-10 right-10 drift-animation opacity-10">
                    <svg class="w-16 h-16 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L3 7v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-9-5z"/>
                    </svg>
                </div>
                <div class="absolute bottom-20 left-10 drift-animation-slow opacity-10">
                    <svg class="w-20 h-20 text-orange-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div class="absolute top-1/3 left-5 drift-animation opacity-8">
                    <svg class="w-12 h-12 text-pink-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/>
                    </svg>
                </div>
                <div class="absolute bottom-1/3 right-5 drift-animation-slow opacity-8">
                    <svg class="w-14 h-14 text-blue-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1z"/>
                    </svg>
                </div>

                <!-- Mobile Card Container -->
                <div class="w-full max-w-md relative z-10 bg-white lg:bg-transparent rounded-2xl lg:rounded-none shadow-2xl lg:shadow-none p-6 sm:p-8 lg:p-0">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
