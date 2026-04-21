<!DOCTYPE html>
<html lang="es" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="SPA Armonía - Tu espacio de relajación y bienestar. Gestión de citas, servicios y masajistas.">

    <title>@yield('titulo', 'SPA Armonía')</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Cambios calendario --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Cambios calendario --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col">

    @hasSection('no-navbar')
    @else
        <x-navbar />
    @endif

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-primary-600 text-white font-medium animate-slide-down"
            id="flash-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show"
            class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg bg-red-600 text-white font-medium animate-slide-down max-w-md"
            id="flash-error">
            <button @click="show = false" class="absolute top-1 right-2 text-white/80 hover:text-white">&times;</button>
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Aquí se inyecta el contenido de cada vista hija --}}
    <main class="flex-1">
        @yield('contenido')
    </main>

    @hasSection('no-footer')
    @else
        <x-footer />
    @endif

    @stack('scripts')

    {{-- Session protection: warn & auto-logout when closing tab/browser --}}
    @auth('admin')
    <script>
        (function() {
            // Flag to track intentional navigation (clicking links/submitting forms)
            let isIntentionalNavigation = false;

            // Mark all link clicks and form submissions as intentional
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a[href]');
                if (link && !link.getAttribute('href').startsWith('#') && !link.getAttribute('href').startsWith('javascript:')) {
                    isIntentionalNavigation = true;
                }
            });

            document.addEventListener('submit', function(e) {
                isIntentionalNavigation = true;
            });

            // Show confirmation dialog when trying to close the tab/browser
            window.addEventListener('beforeunload', function(e) {
                if (!isIntentionalNavigation) {
                    e.preventDefault();
                    // Modern browsers display a generic message, but we set returnValue for compatibility
                    e.returnValue = '⚠️ Si cierras esta pestaña, tu sesión se cerrará y tendrás que iniciar sesión nuevamente.';
                    return e.returnValue;
                }
            });

            // When the page actually unloads (tab/browser closed), send logout request
            window.addEventListener('unload', function() {
                if (!isIntentionalNavigation) {
                    // Use sendBeacon for reliable delivery during page unload
                    const formData = new FormData();
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    navigator.sendBeacon('{{ route("logout") }}', formData);
                }
            });
        })();
    </script>
    @endauth
</body>

</html>