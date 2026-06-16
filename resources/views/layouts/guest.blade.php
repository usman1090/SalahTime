<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen bg-slate-950 text-white">
            <div class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
                <section class="relative hidden overflow-hidden lg:flex">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_20%,rgba(20,184,166,0.24),transparent_30%),linear-gradient(135deg,#07111f_0%,#102235_50%,#0f172a_100%)]"></div>
                    <div class="relative z-10 flex w-full flex-col justify-between px-12 py-10">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-3 text-white">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/15">
                                <x-application-logo class="h-7 w-7 fill-current text-teal-300" />
                            </span>
                            <span>
                                <span class="block text-lg font-semibold">SalahTime</span>
                                <span class="block text-sm text-slate-300">Prayer accountability dashboard</span>
                            </span>
                        </a>

                        <div class="max-w-xl">
                            <p class="mb-4 text-sm font-semibold uppercase tracking-[0.28em] text-teal-200">Daily worship, clearly tracked</p>
                            <h1 class="text-5xl font-semibold leading-tight text-white">Stay consistent with every Salah.</h1>
                            <p class="mt-5 text-lg leading-8 text-slate-300">
                                Record prayers, review streaks, and keep your groups aligned from one calm, focused workspace.
                            </p>
                            <div class="mt-8 grid grid-cols-3 gap-4">
                                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                    <p class="text-2xl font-semibold">5</p>
                                    <p class="mt-1 text-sm text-slate-300">daily prayers</p>
                                </div>
                                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                    <p class="text-2xl font-semibold">24/7</p>
                                    <p class="mt-1 text-sm text-slate-300">progress view</p>
                                </div>
                                <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                                    <p class="text-2xl font-semibold">Teams</p>
                                    <p class="mt-1 text-sm text-slate-300">group support</p>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-slate-400">Built for simple, private, and consistent Salah tracking.</p>
                    </div>
                </section>

                <main class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-10 text-slate-900 sm:px-6 lg:px-8">
                    <div class="w-full max-w-md">
                        <div class="mb-8 flex items-center justify-center gap-3 lg:hidden">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900">
                                <x-application-logo class="h-7 w-7 fill-current text-teal-300" />
                            </span>
                            <span class="text-xl font-semibold">SalahTime</span>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
