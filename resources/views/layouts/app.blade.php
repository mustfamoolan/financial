<!DOCTYPE html>
<html class="light" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'قائمة العمليات - Aeon Finance')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Manrope:wght@400;500;700;800&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#ffb692",
                        "surface": "#f7f9fb",
                        "outline": "#6e7979",
                        "on-primary-fixed-variant": "#004f56",
                        "on-surface": "#191c1e",
                        "primary-fixed-dim": "#82d3de",
                        "on-primary": "#ffffff",
                        "inverse-primary": "#82d3de",
                        "surface-tint": "#006972",
                        "inverse-surface": "#2d3133",
                        "surface-variant": "#e0e3e5",
                        "surface-container-highest": "#e0e3e5",
                        "on-background": "#191c1e",
                        "inverse-on-surface": "#eff1f3",
                        "secondary-fixed-dim": "#bcc7dd",
                        "secondary-fixed": "#d8e3fa",
                        "on-surface-variant": "#3e4949",
                        "on-secondary-fixed": "#111c2c",
                        "on-tertiary-container": "#fff9f7",
                        "background": "#f7f9fb",
                        "secondary": "#545f72",
                        "on-secondary-fixed-variant": "#3c475a",
                        "primary-container": "#247e88",
                        "on-tertiary-fixed": "#341100",
                        "primary": "#00646d",
                        "primary-fixed": "#9ff0fb",
                        "surface-container-high": "#e6e8ea",
                        "outline-variant": "#bdc9c8",
                        "on-primary-container": "#ecfdff",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed-variant": "#733512",
                        "tertiary-fixed": "#ffdbcb",
                        "surface-container-low": "#f2f4f6",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "tertiary": "#8b4823",
                        "surface-dim": "#d8dadc",
                        "secondary-container": "#d5e0f7",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#eceef0",
                        "on-primary-fixed": "#001f23",
                        "on-secondary-container": "#586377",
                        "surface-bright": "#f7f9fb",
                        "tertiary-container": "#a96039",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-headline { font-family: 'Manrope', sans-serif; }
        .teal-gradient { background: linear-gradient(135deg, #00646d 0%, #247e88 100%); }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body x-data="layoutApp()" class="bg-surface text-on-surface font-body antialiased min-h-screen flex selection:bg-primary-container selection:text-on-primary-container">

<!-- SideNavBar -->
<nav :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full md:translate-x-0'" 
     class="fixed right-0 top-0 h-screen w-64 bg-white dark:bg-slate-950 flex flex-col py-6 px-4 space-y-2 z-50 transition-transform duration-300 shadow-[0_0_40px_rgba(0,0,0,0.02)] border-l border-surface-container-high transition-colors">
    
    <div class="mb-8 px-2 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary overflow-hidden">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">account_balance</span>
        </div>
        <div>
            <h2 class="text-lg font-black tracking-tighter text-teal-800 dark:text-teal-200 font-headline">Aeon Finance</h2>
            <p class="text-xs text-on-surface-variant">The Financial Atelier</p>
        </div>
    </div>

    <div class="flex-1 space-y-1">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-slate-50 text-teal-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'text-primary' : '' }}" style="font-variation-settings: 'FILL' 1;">dashboard</span>
            <span>لوحة التحكم</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all group" href="#">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
            <span>العمليات</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all group" href="#">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">account_balance</span>
            <span>الحسابات</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all group" href="#">
            <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">analytics</span>
            <span>التقارير</span>
        </a>
    </div>

    <div class="mt-auto pt-6 border-t border-surface-container-high space-y-1">
        <div class="px-4 py-4 mb-4 rounded-xl bg-surface-container-low flex flex-col items-center text-center">
            <span class="material-symbols-outlined text-primary mb-2">star</span>
            <p class="text-xs text-on-surface font-medium mb-3">Experience full curation</p>
            <button class="w-full py-2 px-4 rounded-lg bg-white text-primary text-xs font-bold hover:bg-surface transition-colors shadow-sm border border-slate-100">Upgrade to Premium</button>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 transition-all group">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span class="text-xs">تسجيل الخروج</span>
            </button>
        </form>
    </div>
</nav>

<!-- Sidebar Overlay (Mobile) -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden backdrop-blur-sm transition-opacity duration-300"></div>

<!-- Main Content Area -->
<main class="flex-1 w-full md:pr-64 min-h-screen flex flex-col">
    <!-- TopNavBar -->
    <header class="w-full sticky top-0 z-40 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-md flex justify-between items-center px-8 h-20 md:h-24 transition-all">
        <div class="flex items-center gap-4 flex-1">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 text-primary">
                <span class="material-symbols-outlined">menu</span>
            </button>
            @yield('header_title')
        </div>
        <div class="flex items-center gap-6">
            <div class="hidden md:flex items-center bg-white rounded-full px-4 py-2 shadow-sm border border-surface-container-highest">
                <span class="material-symbols-outlined text-on-surface-variant ml-2 text-lg">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm text-on-surface placeholder-on-surface-variant w-48 font-body" placeholder="بحث..." type="text"/>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-slate-200/50 transition-all">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="w-10 h-10 rounded-full flex items-center justify-center text-on-surface-variant hover:bg-slate-200/50 transition-all">
                    <span class="material-symbols-outlined">settings</span>
                </button>
                <div class="w-10 h-10 rounded-full overflow-hidden bg-surface-container-high border-2 border-white shadow-sm mr-2">
                    <img alt="User profile" class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=00646d&color=fff"/>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6 md:p-8 flex-1">
        @yield('content')
    </div>
</main>

<script>
    function layoutApp() {
        return {
            sidebarOpen: false,
            init() {
                console.log('Premium Layout Initialized');
            }
        }
    }
</script>
@stack('scripts')
</body>
</html>
