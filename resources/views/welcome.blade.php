<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ form: 'login', showLoginPassword: false, showRegisterPassword: false, showRegisterPasswordConfirmation: false, splashVisible: true, isMobile: window.innerWidth < 768, loginPassword: '', registerPassword: '', registerPasswordConfirmation: '' }" @resize.window="isMobile = window.innerWidth < 768" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>MHLHUILLIER_EMS – Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/ml2.png') }}">
    {{-- Alpine.js for toggle --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Load the app's compiled CSS and JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* White → red vertical gradient backdrop (no animation) */
        .bg-polish-static {
            background: linear-gradient(
                180deg,
                #ffffff 0%,
                #fff5f5 20%,
                #ffe0e0 40%,
                #ffa7a7 65%,
                #ff0000 85%,
                #da2323 100%
            );
            background-attachment: fixed;
            min-height: 100vh;
        }
        /* Mobile splash screen */
        .splash-container {
            position: fixed;
            inset: 0;
            z-index: 50;
            background: linear-gradient(
                180deg,
                #ffffff 0%,
                #fff5f5 20%,
                #ffe0e0 40%,
                #ffb0b0 65%,
                #d62828 85%,
                #8B0000 100%
            );
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        .splash-container.hidden-splash {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        /* Astonishing drop shadow animation for logo */
        @keyframes logoGlow {
            0%, 100% {
                filter: drop-shadow(0 10px 30px rgba(139, 0, 0, 0.4)) drop-shadow(0 0 60px rgba(139, 0, 0, 0.2));
                transform: scale(1) translateY(0);
            }
            25% {
                filter: drop-shadow(0 15px 40px rgba(139, 0, 0, 0.6)) drop-shadow(0 0 80px rgba(178, 34, 34, 0.4));
                transform: scale(1.05) translateY(-5px);
            }
            50% {
                filter: drop-shadow(0 20px 50px rgba(139, 0, 0, 0.7)) drop-shadow(0 0 100px rgba(178, 34, 34, 0.5));
                transform: scale(1.08) translateY(-10px);
            }
            75% {
                filter: drop-shadow(0 15px 40px rgba(139, 0, 0, 0.6)) drop-shadow(0 0 80px rgba(178, 34, 34, 0.4));
                transform: scale(1.05) translateY(-5px);
            }
        }
        .logo-animated {
            animation: logoGlow 3s ease-in-out infinite;
        }
        /* Floating particles */
        @keyframes floatUp {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.7;
            }
            100% {
                transform: translateY(-120px) scale(0);
                opacity: 0;
            }
        }
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            animation: floatUp 2s ease-in infinite;
            pointer-events: none;
        }
        .particle:nth-child(1) { left: 20%; animation-delay: 0s; animation-duration: 2.2s; }
        .particle:nth-child(2) { left: 40%; animation-delay: 0.4s; animation-duration: 2.5s; }
        .particle:nth-child(3) { left: 60%; animation-delay: 0.8s; animation-duration: 2s; }
        .particle:nth-child(4) { left: 75%; animation-delay: 1.2s; animation-duration: 2.3s; }
        .particle:nth-child(5) { left: 30%; animation-delay: 1.6s; animation-duration: 2.7s; }
        .particle:nth-child(6) { left: 55%; animation-delay: 0.2s; animation-duration: 2.1s; }
        .particle:nth-child(7) { left: 80%; animation-delay: 1s; animation-duration: 2.4s; }
        .particle:nth-child(8) { left: 10%; animation-delay: 1.4s; animation-duration: 2.6s; }
        /* Clean white card with subtle red accent */
        .auth-card {
            background: #ffffff;
            border: 1px solid #f1d9d9;
            box-shadow:
                0 1px 2px rgba(139, 0, 0, 0.04),
                0 12px 32px -8px rgba(139, 0, 0, 0.18),
                0 4px 12px -4px rgba(0, 0, 0, 0.06);
        }
        /* Reusable compact input field style */
        .field-input {
            display: block;
            width: 100%;
            padding: 0.6rem 0.75rem 0.6rem 2.25rem;
            font-size: 0.8rem;
            color: #1b1b18;
            background-color: #ffffff;
            border: 1.5px solid #e5cccc;
            border-radius: 0.6rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            transition: border-color .2s, box-shadow .2s, background-color .2s;
        }
        .field-input:hover {
            border-color: #d4a8a8;
            background-color: #fffafa;
        }
        .field-input:focus {
            outline: none;
            border-color: #8B0000;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.12), 0 1px 2px rgba(0,0,0,0.03);
        }
        .field-input::placeholder {
            color: #b8a8a8;
        }
        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #4b4b48;
            margin-bottom: 0.3rem;
            letter-spacing: 0.01em;
        }
        /* Input icon positioning */
        .field-wrap {
            position: relative;
        }
        .field-icon {
            position: absolute;
            left: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            color: #b88a8a;
            pointer-events: none;
            transition: color .2s;
        }
        .field-input:focus ~ .field-icon {
            color: #8B0000;
        }
        /* Select needs less left padding (icon) */
        .field-input.select-field {
            padding-left: 2.25rem;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238B0000' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.6rem center;
            background-size: 1rem;
            padding-right: 2rem;
        }
        /* Primary action button */
        .btn-primary {
            width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: #ffffff;
            background: linear-gradient(135deg, #8B0000 0%, #6b0000 100%);
            border-radius: 0.6rem;
            box-shadow: 0 4px 12px -2px rgba(139, 0, 0, 0.35), 0 2px 4px rgba(0,0,0,0.06);
            transition: transform .15s ease, box-shadow .2s ease, background .2s ease;
            letter-spacing: 0.02em;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #7A0019 0%, #5c0000 100%);
            box-shadow: 0 6px 18px -2px rgba(139, 0, 0, 0.45), 0 3px 6px rgba(0,0,0,0.08);
            transform: translateY(-1px);
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px -1px rgba(139, 0, 0, 0.35);
        }
        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.25), 0 4px 12px -2px rgba(139, 0, 0, 0.35);
        }
        /* Checkbox accent */
        .field-checkbox {
            height: 1rem;
            width: 1rem;
            color: #8B0000;
            border-color: #d4a8a8;
            border-radius: 0.25rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .field-checkbox:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.12);
        }
        /* Toggle link */
        .toggle-link {
            color: #8B0000;
            font-weight: 600;
            transition: color .2s;
        }
        .toggle-link:hover {
            color: #5c0000;
            text-decoration: underline;
        }
        /* Divider line under headings */
        .heading-divider {
            width: 2.5rem;
            height: 3px;
            border-radius: 9999px;
            background: linear-gradient(to right, #8B0000, #b22222);
            margin: 0.5rem auto 0;
        }
        /* Flexible form container with smooth height transitions */
        .form-container {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            transition: height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Form wrapper for smooth transitions */
        .form-wrapper {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        /* Smooth form fade and scale transitions */
        [x-cloak] { display: none; }
        .form-fade-in {
            animation: formFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-fade-out {
            animation: formFadeOut 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes formFadeIn {
            0% {
                opacity: 0;
                transform: scale(0.98);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes formFadeOut {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0.98);
            }
        }
        /* Logo section stays fixed and doesn't move */
        .logo-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: none;
            will-change: auto;
            flex-shrink: 0;
        }
        /* Auth card with smooth layout */
        .auth-card-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: none;
            will-change: auto;
        }
    </style>
</head>
<body class="min-h-screen bg-polish-static text-[#1b1b18] relative overflow-x-hidden">

    {{-- ============ MOBILE SPLASH SCREEN ============ --}}
    <div x-show="splashVisible && isMobile"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="splash-container">
        {{-- Floating particles --}}
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <div class="flex flex-col items-center justify-center px-8">
            {{-- Logo with astonishing drop shadow animation --}}
            <div class="relative mb-8">
                <img src="{{ asset('images/ml2.png') }}" alt="MHLHUILLIER Logo" class="w-28 h-28 object-contain logo-animated"/>
            </div>

            {{-- Brand name text label --}}
            <p class="text-3xl font-extrabold tracking-wider text-white drop-shadow-lg mb-2"
               style="text-shadow: 0 2px 10px rgba(139,0,0,0.5), 0 0 40px rgba(255,255,255,0.3);">
                MHLHUILLIER
            </p>
            <p class="text-sm font-medium text-white/80 tracking-wide mb-10"
               style="text-shadow: 0 1px 4px rgba(0,0,0,0.3);">
                Employee Work Automation
            </p>

            {{-- GET STARTED button --}}
            <button @click="splashVisible = false"
                    class="px-10 py-3.5 bg-white text-[#8B0000] font-bold text-sm tracking-widest uppercase rounded-full shadow-2xl hover:shadow-[0_8px_30px_rgba(139,0,0,0.5)] hover:scale-105 active:scale-95 transition-all duration-300"
                    style="box-shadow: 0 8px 32px rgba(139,0,0,0.35), 0 0 60px rgba(255,255,255,0.15);">
                GET STARTED
            </button>
        </div>

        {{-- Footer --}}
        <div class="absolute bottom-6 left-0 right-0 text-center">
            <p class="text-xs text-white/50 tracking-wide">
                &copy; {{ date('Y') }} MLHUILLIER v.1.0
            </p>
        </div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col md:flex-row">

        {{-- Branding / logo section (left on desktop, top on mobile) --}}
        <section class="logo-section px-6 py-8 lg:p-12">
            <div class="max-w-xs text-center">
              <!--  <div class="inline-flex items-center justify-center p-3 mb-4 rounded-2xl bg-white shadow-lg shadow-red-900/10 ring-1 ring-red-100">
                    <img src="{{ asset('images/ml2.png') }}" alt="Brand logo" class="w-20 sm:w-24 h-auto mx-auto"/>
                </div>-->
                 <img src="{{ asset('images/ml2.png') }}" alt="Brand logo" class="w-20 sm:w-24 h-auto mx-auto"/>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#8B0000]">MHLHUILLIER</h1>
                <h2 class="text-sm sm:text-base font-medium text-[#7A0019] mt-1">Employee Work Automation</h2>
                <div class="mt-4 mx-auto h-1 w-20 rounded-full bg-gradient-to-r from-[#8B0000] to-transparent"></div>
            </div>
        </section>

        {{-- Authentication card (right on desktop, bottom on mobile) --}}
        <section class="auth-card-container px-4 py-6 sm:px-6 lg:p-12">
            <div class="w-full max-w-sm auth-card rounded-2xl">
                <div class="form-container" :style="form === 'login' ? { height: 'auto', minHeight: '380px' } : { height: 'auto', minHeight: '600px' }">

                {{-- ============ LOGIN FORM ============ --}}
                <div x-show="form === 'login'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="p-6 sm:p-7 space-y-4 absolute inset-0">
                    <div class="text-center">
                        <h2 class="text-xl font-bold text-[#8B0000]">Welcome Back</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Sign in to your account</p>
                        <div class="heading-divider"></div>
                    </div>
                    <form method="POST" action="{{ Route::has('login') ? route('login') : '/login' }}">
                        @csrf
                        <div class="space-y-3">
                            {{-- Email --}}
                            <div>
                                <label class="field-label">Email</label>
                                <div class="field-wrap">
                                    <input type="email" name="email" required class="field-input" placeholder="you@example.com"/>
                                    <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            {{-- Password --}}
                            <div>
                                <label class="field-label">Password</label>
                                <div class="relative">
                                    <div class="field-wrap">
                                        <input :type="showLoginPassword ? 'text' : 'password'" name="password" required x-model="loginPassword" class="field-input pr-10" placeholder="••••••••"/>
                                        <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.83 0 1.5-.67 1.5-1.5S12.83 8 12 8s-1.5.67-1.5 1.5S11.17 11 12 11zm6-3V6a6 6 0 00-12 0v2H4v12h16V8h-2z"/>
                                        </svg>
                                    </div>
                                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#8B0000] focus:outline-none" @click="showLoginPassword = !showLoginPassword" aria-label="Toggle password visibility">
                                        <svg x-show="!showLoginPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 4C6.4 4 3.4 6.6 2.4 10 3.4 13.4 6.4 16 10 16s6.6-2.6 7.6-6C16.6 6.6 13.6 4 10 4zm0 10a4 4 0 100-8 4 4 0 000 8z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg x-show="showLoginPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="display:none;">
                                            <path fill-rule="evenodd" d="M3.1 3.1a1 1 0 011.4 0l13.4 13.4a1 1 0 01-1.4 1.4l-2.1-2.1c-1.1.6-2.4.9-3.8.9-5 0-9-4-9-8 0-1.4.4-2.7 1.1-3.8L3.1 3.1zm6.9 6.9l-2.3-2.3c.2-.2.4-.3.6-.4.3.1.6.1.9.1a4 4 0 013.8 5.1l-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            {{-- Remember me --}}
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="remember" class="field-checkbox">
                                <span class="text-xs text-gray-700">Remember Me</span>
                            </label>
                            {{-- Submit --}}
                            <button type="submit" class="btn-primary">
                                Login
                            </button>
                        </div>
                    </form>
                    <p class="text-center text-xs text-gray-600">
                        Don’t have an account?
                        <a href="#" @click.prevent="form='register'" class="toggle-link">Create account</a>
                    </p>
                </div>

                {{-- ============ REGISTER FORM (compact) ============ --}}
                <div x-show="form === 'register'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"
                     class="p-6 sm:p-7 space-y-3 absolute inset-0" style="display:none;">
                    <div class="text-center">
                        <h2 class="text-xl font-bold text-[#8B0000]">Create Your Account</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Get started in seconds</p>
                        <div class="heading-divider"></div>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="space-y-2.5">
                            {{-- Full name --}}
                            <div>
                                <label class="field-label">Full Name</label>
                                <div class="field-wrap">
                                    <input type="text" name="name" required class="field-input" placeholder="Juan Dela Cruz"/>
                                    <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            {{-- Role --}}
                            <div>
                                <label class="field-label">Role</label>
                                <div class="field-wrap">        
                                    <select name="role" required class="field-input select-field">
                                        <option value="Admin">Admin</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                    <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a3 3 0 10-3-3"/>
                                    </svg>
                                </div>
                            </div>
                            {{-- Email --}}
                            <div>
                                <label class="field-label">Email</label>
                                <div class="field-wrap">
                                    <input type="email" name="email" required class="field-input" placeholder="you@example.com"/>
                                    <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            {{-- Password --}}
                            <div>
                                <label class="field-label">Password</label>
                                <div class="relative">
                                    <div class="field-wrap">
                                        <input :type="showRegisterPassword ? 'text' : 'password'" name="password" required x-model="registerPassword" class="field-input pr-10" placeholder="••••••••"/>
                                        <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c.83 0 1.5-.67 1.5-1.5S12.83 8 12 8s-1.5.67-1.5 1.5S11.17 11 12 11zm6-3V6a6 6 0 00-12 0v2H4v12h16V8h-2z"/>
                                        </svg>
                                    </div>
                                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#8B0000] focus:outline-none" @click="showRegisterPassword = !showRegisterPassword" aria-label="Toggle password visibility">
                                        <svg x-show="!showRegisterPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 4C6.4 4 3.4 6.6 2.4 10 3.4 13.4 6.4 16 10 16s6.6-2.6 7.6-6C16.6 6.6 13.6 4 10 4zm0 10a4 4 0 100-8 4 4 0 000 8z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg x-show="showRegisterPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="display:none;">
                                            <path fill-rule="evenodd" d="M3.1 3.1a1 1 0 011.4 0l13.4 13.4a1 1 0 01-1.4 1.4l-2.1-2.1c-1.1.6-2.4.9-3.8.9-5 0-9-4-9-8 0-1.4.4-2.7 1.1-3.8L3.1 3.1zm6.9 6.9l-2.3-2.3c.2-.2.4-.3.6-.4.3.1.6.1.9.1a4 4 0 013.8 5.1l-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            {{-- Confirm password --}}
                            <div>
                                <label class="field-label">Confirm Password</label>
                                <div class="relative">
                                    <div class="field-wrap">
                                        <input :type="showRegisterPasswordConfirmation ? 'text' : 'password'" name="password_confirmation" required x-model="registerPasswordConfirmation" class="field-input pr-10" placeholder="••••••••"/>
                                        <svg class="field-icon h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#8B0000] focus:outline-none" @click="showRegisterPasswordConfirmation = !showRegisterPasswordConfirmation" aria-label="Toggle confirm password visibility">
                                        <svg x-show="!showRegisterPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 4C6.4 4 3.4 6.6 2.4 10 3.4 13.4 6.4 16 10 16s6.6-2.6 7.6-6C16.6 6.6 13.6 4 10 4zm0 10a4 4 0 100-8 4 4 0 000 8z" clip-rule="evenodd"/>
                                        </svg>
                                        <svg x-show="showRegisterPasswordConfirmation" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" style="display:none;">
                                            <path fill-rule="evenodd" d="M3.1 3.1a1 1 0 011.4 0l13.4 13.4a1 1 0 01-1.4 1.4l-2.1-2.1c-1.1.6-2.4.9-3.8.9-5 0-9-4-9-8 0-1.4.4-2.7 1.1-3.8L3.1 3.1zm6.9 6.9l-2.3-2.3c.2-.2.4-.3.6-.4.3.1.6.1.9.1a4 4 0 013.8 5.1l-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            {{-- Submit --}}
                            <button type="submit" class="btn-primary">
                                Register
                            </button>
                        </div>
                    </form>
                    <p class="text-center text-xs text-gray-600">
                        Already have an account?
                        <a href="#" @click.prevent="form='login'" class="toggle-link">Login</a>
                    </p>
                </div>

                </div>
            </div>
        </section>
    </div>

    @if (session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('status') }}',
            confirmButtonColor: '#8B0000',
            confirmButtonText: 'OK',
            width: '22rem',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
    @endif
</body>
</html>