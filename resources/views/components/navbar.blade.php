{{-- Navbar Component --}}
<header class="sticky top-0 z-40 bg-white/80 backdrop-blur-lg border-b border-gray-100 transition-colors duration-300"
    id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group" id="navbar-logo">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold text-gray-900">SPA Armonía</span>
                    <span class="block text-xs text-gray-500 -mt-0.5">Panel de Administración</span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-1" id="desktop-nav">
                <a href="{{ route('dashboard') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </span>
                </a>
                <a href="{{ route('citas.index') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('citas.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Citas
                    </span>
                </a>
                <a href="{{ route('masajistas.index') }}"
                    class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('masajistas.*') ? 'text-primary-700 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Masajistas
                    </span>
                </a>
                <a href="{{ route('citas.create') }}" class="btn-primary text-sm ml-2" id="btn-nueva-cita">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nueva Cita
                </a>
            </nav>

            {{-- Mobile Menu Toggle --}}
            <button x-data @click="$dispatch('toggle-mobile-menu')"
                class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100" id="mobile-menu-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
        class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1" id="mobile-menu" x-cloak>
        <a href="{{ route('dashboard') }}"
            class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('citas.index') }}"
            class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Citas</a>
        <a href="{{ route('masajistas.index') }}"
            class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Masajistas</a>
        <a href="{{ route('citas.create') }}" class="block btn-primary text-sm text-center mt-2">+ Nueva Cita</a>
    </div>
</header>