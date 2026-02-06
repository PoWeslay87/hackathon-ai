<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Governance Health Dashboard - Earth AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html {
            font-size: 14.5px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .glass-card {
            background: rgba(17, 24, 39, 0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            background: rgba(17, 24, 39, 0.6);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-4px);
        }

        .stat-glow-blue {
            filter: drop-shadow(0 0 15px rgba(59, 130, 246, 0.3));
        }

        .stat-glow-emerald {
            filter: drop-shadow(0 0 15px rgba(16, 185, 129, 0.3));
        }

        .stat-glow-purple {
            filter: drop-shadow(0 0 15px rgba(139, 92, 246, 0.3));
        }
    </style>
</head>

<body class="bg-[#0b0f19] min-h-screen p-6 md:p-12 relative">
    <!-- Cosmic Aura -->
    <div class="fixed inset-0 pointer-events-none -z-10 bg-[#060910]">
        <!-- Technical Grid -->
        <div class="absolute inset-0 opacity-[0.1]"
            style="background-image: 
                linear-gradient(#1e293b 1px, transparent 1px), 
                linear-gradient(90deg, #1e293b 1px, transparent 1px);
             background-size: 40px 40px;">
        </div>
        <div class="absolute top-[-10%] left-[-5%] w-[60%] h-[60%] bg-blue-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[60%] h-[60%] bg-indigo-900/10 rounded-full blur-[120px]">
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <div class="flex items-center gap-2 text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mb-3">
                    <a href="{{ url('/') }}" class="hover:text-blue-400 transition-colors">Platform</a>
                    <span class="opacity-30">/</span>
                    <span class="text-blue-400">Governance Dashboard</span>
                </div>
                <h1 class="text-4xl font-bold text-white tracking-tight">AI Health <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-blue-400 to-indigo-400">Overview</span>
                </h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex flex-col items-end">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">System Status</span>
                    <span class="flex items-center gap-2 text-emerald-400 font-bold text-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Fully Operational
                    </span>
                </div>
                <a href="{{ url('/') }}"
                    class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 px-6 rounded-2xl transition-all shadow-xl shadow-blue-900/20 active:scale-95 text-sm">
                    Back to Terminal
                </a>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Health Score Card -->
            <div
                class="md:col-span-2 glass-card rounded-3xl p-8 flex flex-col justify-between min-h-[280px] relative overflow-hidden group">
                <div
                    class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all duration-700">
                </div>

                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-1">Safety Health
                            Score</p>
                        <h3 class="text-6xl font-black text-white stat-glow-emerald">{{ round($safetyHealth) }}%</h3>
                    </div>
                    <div
                        class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>

                <div class="relative z-10">
                    <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden mb-4 border border-white/5">
                        <div class="h-full bg-linear-to-r from-emerald-600 to-teal-400 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.5)]"
                            style="width: {{ $safetyHealth }}%"></div>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Sistem AI Anda beroperasi dalam batas parameter keamanan yang aman. <span
                            class="text-emerald-400 font-bold">Resiko Rendah</span> terdeteksi dalam 24 jam terakhir.
                    </p>
                </div>
            </div>

            <!-- Risk Avg Card -->
            <div class="glass-card rounded-3xl p-8 flex flex-col justify-between min-h-[280px]">
                <div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] mb-1">Avg. Risk Score</p>
                    <h3 class="text-5xl font-black text-white stat-glow-blue">{{ number_format($avgRisk, 1) }}%</h3>
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-xs text-blue-400 font-bold uppercase">Optimized</span>
                        <div class="flex-1 h-px bg-blue-500/20"></div>
                    </div>
                    <p class="text-slate-500 text-xs">Semakin rendah skor resiko, semakin akurat dan aman respon dari
                        asisten AI Anda.</p>
                </div>
            </div>
        </div>

        <!-- Secondary Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Flagged Logs -->
            <div class="glass-card rounded-2xl p-6 border-l-4 border-red-500/50">
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[9px] mb-2">Flagged Responses</p>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-white">{{ $totalFlagged }}</span>
                    <span class="text-xs text-red-400 font-bold pb-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"
                                clip-rule="evenodd" />
                        </svg>
                        Need Audit
                    </span>
                </div>
            </div>

            <!-- Total Logs -->
            <div class="glass-card rounded-2xl p-6">
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[9px] mb-2">Total Interactions</p>
                <span class="text-3xl font-bold text-white">{{ $totalLogs }}</span>
            </div>

            <!-- Knowledge Docs -->
            <div class="glass-card rounded-2xl p-6">
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[9px] mb-2">Memory Sources</p>
                <span class="text-3xl font-bold text-white">{{ $totalKnowledge }}</span>
            </div>

            <!-- Active Policies -->
            <div class="glass-card rounded-2xl p-6">
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[9px] mb-2">Active Policies</p>
                <span class="text-3xl font-bold text-white">{{ $activePolicies }}</span>
            </div>
        </div>

        <!-- Bottom Actions -->
        <div class="mt-12 flex flex-col md:flex-row gap-4">
            <a href="{{ url('/audit-logs') }}"
                class="flex-1 glass-card p-6 rounded-2xl flex items-center justify-between hover:border-blue-500/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white italic">Audit Trail Terperinci</h4>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">Detail per-cakapan & Log
                            Keamanan</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="{{ url('/knowledge') }}"
                class="flex-1 glass-card p-6 rounded-2xl flex items-center justify-between hover:border-emerald-500/30">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-white italic">Basis Pengetahuan AI</h4>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">Kelola Memori & Data Dokumen
                        </p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</body>

</html>
