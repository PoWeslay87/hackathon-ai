<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Earth AI Governance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
            overflow: hidden;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .glass-login {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .glow-overlay {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(59, 130, 246, 0.15), transparent 70%);
            pointer-events: none;
        }
    </style>
</head>

<body>
    <!-- Background Decor -->
    <div class="fixed inset-0 pointer-events-none -z-10 bg-[#060910]">
        <!-- Technical Grid -->
        <div class="absolute inset-0 opacity-[0.1]"
            style="background-image: 
                linear-gradient(#1e293b 1px, transparent 1px), 
                linear-gradient(90deg, #1e293b 1px, transparent 1px);
             background-size: 40px 40px;">
        </div>
        <div class="absolute top-[-20%] left-[-10%] w-[60%] h-[60%] bg-blue-900/20 rounded-full blur-[130px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-indigo-900/20 rounded-full blur-[130px]">
        </div>
    </div>

    <div class="glow-overlay"></div>

    <div class="w-full max-w-md p-8 relative z-10 animate-fade-in">
        <div class="text-center mb-10">
            <div
                class="w-20 h-20 bg-linear-to-tr from-blue-600 to-indigo-600 rounded-3xl mx-auto flex items-center justify-center text-white text-4xl font-black shadow-2xl shadow-blue-900/40 mb-6">
                E
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Governance Access</h1>
            <p class="text-slate-400 mt-2 font-medium">Monitoring & Control Protected Zone</p>
        </div>

        @if (session('error'))
            <div
                class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-medium text-center animate-shake">
                {{ session('error') }}
            </div>
        @endif

        <div class="glass-login p-8 rounded-[2.5rem] border border-white/5">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label
                        class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2 ml-1">Username</label>
                    <input type="text" name="username" required
                        class="w-full bg-slate-950/50 border border-slate-700/50 focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 rounded-2xl px-5 py-4 text-white placeholder-slate-600 transition-all outline-none"
                        placeholder="admin">
                </div>

                <div>
                    <label
                        class="block text-slate-400 text-xs font-bold uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-slate-950/50 border border-slate-700/50 focus:border-blue-500/50 focus:ring-1 focus:ring-blue-500/50 rounded-2xl px-5 py-4 text-white placeholder-slate-600 transition-all outline-none"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full bg-linear-to-tr from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold py-4 rounded-2xl transition-all shadow-xl shadow-blue-900/20 active:scale-95 text-lg">
                    Authenticate
                </button>
            </form>

            <p class="text-center mt-8 text-slate-600 text-[10px] uppercase font-bold tracking-[0.2em]">
                Earth AI Infrastructure v2.1
            </p>
        </div>

        <a href="{{ url('/') }}"
            class="block text-center mt-8 text-slate-500 hover:text-white transition-colors text-xs font-medium">
            ← Back to Public Terminal
        </a>
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</body>

</html>
