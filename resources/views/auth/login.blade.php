<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>تسجيل الدخول - Aeon Finance</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#00646d",
                        "on-primary": "#ffffff",
                        "surface": "#f7f9fb",
                        "on-surface": "#191c1e",
                        "primary-container": "#247e88",
                    },
                    fontFamily: {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .teal-gradient { background: linear-gradient(135deg, #00646d 0%, #247e88 100%); }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex items-center justify-center p-6 selection:bg-primary/20">
    <div class="w-full max-w-md">
        <div class="bg-white p-10 rounded-[2rem] shadow-[0_20px_50px_rgba(0,100,109,0.08)] border border-slate-100 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute -top-12 -left-12 w-48 h-48 bg-primary/5 rounded-full blur-3xl"></div>
            
            <div class="text-center mb-10 relative z-10">
                <div class="w-20 h-20 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                    <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                </div>
                <h1 class="text-3xl font-headline font-bold text-teal-900 tracking-tight mb-2">Aeon Finance</h1>
                <p class="text-slate-500 font-medium text-sm">The Financial Atelier</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6 relative z-10 text-right">
                @csrf
                
                <div>
                    <label for="email" class="block text-xs font-bold text-teal-800 mb-2 mr-1 uppercase tracking-widest">البريد الإلكتروني</label>
                    <div class="relative group">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-primary/20 rounded-2xl py-4 pr-12 pl-4 transition-all text-right font-medium"
                            placeholder="your@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-2 mr-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-teal-800 mb-2 mr-1 uppercase tracking-widest">كلمة المرور</label>
                    <div class="relative group">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                        <input type="password" id="password" name="password" required
                            class="w-full bg-slate-50 border-none ring-1 ring-slate-100 focus:ring-2 focus:ring-primary/20 rounded-2xl py-4 pr-12 pl-4 transition-all text-right font-medium"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-2 mr-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between py-2 flex-row-reverse">
                    <div class="flex items-center flex-row-reverse">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-primary bg-slate-50 border-slate-200 rounded focus:ring-primary/20">
                        <label for="remember" class="mr-2 text-sm text-slate-500 font-medium">تذكرني</label>
                    </div>
                    <a href="#" class="text-sm text-primary font-bold hover:underline">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" class="w-full teal-gradient text-on-primary py-4 rounded-2xl font-bold shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center justify-center gap-2 group">
                    <span>دخول النظام</span>
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-[-4px] transition-transform">arrow_right_alt</span>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                <p class="text-xs text-slate-400 font-medium tracking-tight">Experience full curation</p>
            </div>
        </div>
    </div>
</body>
</html>
