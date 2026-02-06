<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Assistant - Premium Dark Mode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        /* GLOBAL SCALING: Makes the UI look ~70% size */
        html {
            font-size: 14.5px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
            overflow: hidden;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: rgba(10, 15, 30, 0.85);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: relative;
            background: radial-gradient(circle at top right, rgba(29, 78, 216, 0.05), transparent);
        }

        /* Custom scrollbar - Thin & Elegant */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }

        /* Typography Refinement */
        .prose p {
            margin-bottom: 0.8em;
            line-height: 1.6;
        }

        .prose strong {
            color: #f1f5f9;
            font-weight: 600;
        }

        .prose code {
            color: #93c5fd;
            font-family: monospace;
            background: rgba(147, 197, 253, 0.1);
            padding: 0.2em 0.4em;
            border-radius: 0.3em;
        }

        .prose pre {
            background: #020617;
            padding: 1.25em;
            border-radius: 1em;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin: 1em 0;
            overflow-x: auto;
        }

        /* Typing Cursor */
        .typing-cursor::after {
            content: '▋';
            animation: blink 1s step-start infinite;
            color: #60a5fa;
            margin-left: 2px;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        /* Risk Badges */
        .risk-badge-low {
            @apply bg-emerald-500/10 text-emerald-400 border-emerald-500/20 shadow-[0_0_15px_rgba(16, 185, 129, 0.05)];
        }

        .risk-badge-medium {
            @apply bg-yellow-500/10 text-yellow-400 border-yellow-500/20 shadow-[0_0_15px_rgba(234, 179, 8, 0.05)];
        }

        .risk-badge-high {
            @apply bg-red-500/10 text-red-400 border-red-500/20 shadow-[0_0_15px_rgba(239, 68, 68, 0.05)];
        }

        .source-tag {
            @apply text-[10px] bg-slate-900 border border-slate-700/50 rounded px-2 py-0.5 text-slate-400 hover:text-blue-400 transition-colors cursor-default;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 50;
                height: 100%;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 45;
            }

            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>
</head>

<body class="selection:bg-indigo-500/30">
    <!-- Styles for Highlight.js -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/tokyo-night-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    <!-- Background Decoration -->
    <div class="fixed inset-0 pointer-events-none -z-10 bg-[#060910]">
        <!-- Technical Grid -->
        <div class="absolute inset-0 opacity-[0.15]"
            style="background-image: 
                linear-gradient(#1e293b 1px, transparent 1px), 
                linear-gradient(90deg, #1e293b 1px, transparent 1px);
             background-size: 40px 40px;">
        </div>
        <!-- Cosmic Glows -->
        <div class="absolute top-[-10%] left-[-5%] w-[60%] h-[60%] bg-blue-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[60%] h-[60%] bg-indigo-600/10 rounded-full blur-[120px]">
        </div>
    </div>

    <div class="flex h-screen overflow-hidden relative">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar flex-col p-4 z-50">
            <!-- New Chat Button -->
            <button onclick="resetSession()"
                class="flex items-center gap-3 w-full p-3.5 mb-6 rounded-2xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all text-white font-medium group">
                <div
                    class="w-8 h-8 rounded-xl bg-blue-600/20 flex items-center justify-center text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span>Chat Baru</span>
            </button>

            <!-- Navigation Links -->
            <div class="space-y-1.5 mb-8">
                @if (session('is_admin'))
                    <p class="px-3 text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-3">Internal Tools
                    </p>
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-all text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Health Dashboard</span>
                    </a>
                    <a href="{{ url('/knowledge') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 transition-all text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Knowledge Base</span>
                    </a>
                    <a href="{{ url('/audit-logs') }}"
                        class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-slate-400 hover:text-indigo-400 hover:bg-indigo-500/10 transition-all text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Audit Trail</span>
                    </a>
                @else
                    <div class="px-4 py-5 rounded-2xl bg-white/5 border border-white/5 mt-4">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">AI Integrity</p>
                        <p class="text-xs text-slate-400 leading-relaxed mb-3">
                            Platform ini diawasi oleh 3 lapis kebijakan tata kelola untuk memastikan respon aman dan
                            bebas bias.
                        </p>
                        <div
                            class="flex items-center gap-2 text-[9px] text-blue-400 font-bold uppercase tracking-tighter">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></div>
                            Automated Guard Activated
                        </div>
                    </div>
                @endif

                @if (session('is_admin'))
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all text-sm font-bold italic">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar Admin</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Chat History -->
            <div class="flex-1 overflow-y-auto px-2">
                <p class="px-2 text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-4">Riwayat Sesi</p>
                <div class="space-y-1">
                    @if (session('chat_history'))
                        @foreach (array_reverse(session('chat_history')) as $chat)
                            @if ($chat['role'] === 'user')
                                <div
                                    class="px-3 py-2.5 rounded-xl text-[11px] text-slate-400 hover:bg-white/5 hover:text-white cursor-pointer truncate transition-all border border-transparent hover:border-white/5 active:scale-95">
                                    {{ Str::limit($chat['parts'][0]['text'], 32) }}
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="px-3 py-8 text-center text-[10px] text-slate-600 italic">Belum ada percakapan</div>
                    @endif
                </div>
            </div>

            <!-- Footer Branding -->
            <div class="pt-4 border-t border-white/5 mt-auto">
                <div class="flex items-center gap-3 px-2">
                    <div
                        class="w-9 h-9 rounded-2xl bg-linear-to-tr from-indigo-600 to-blue-600 flex items-center justify-center text-white font-black shadow-lg shadow-blue-900/40">
                        E</div>
                    <div>
                        <p class="text-[12px] font-bold text-white tracking-tight">EARTH AI</p>
                        <p class="text-[9px] text-slate-500 uppercase tracking-widest font-medium">Enterprise v2.1</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Header -->
            <header
                class="h-16 border-b border-white/5 flex items-center justify-between px-6 bg-[#0b0f19]/60 backdrop-blur-xl z-20">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="md:hidden p-2 -ml-2 text-slate-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)]">
                        </div>
                        <h2 class="text-sm font-semibold text-white tracking-wide">Platform Tata Kelola AI</h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="hidden sm:inline px-2 py-0.5 rounded-md bg-blue-500/10 text-[9px] font-bold text-blue-400 border border-blue-500/20 uppercase tracking-widest">Ground-ing
                        Active</span>
                </div>
            </header>

            <!-- Chat Area -->
            <div class="flex-1 overflow-y-auto p-4 md:p-10 space-y-10 scroll-smooth" id="chat-container">
                @if (empty(session('chat_history')))
                    <div id="welcome-screen"
                        class="flex flex-col items-center justify-center h-full text-center space-y-8 animate-fade-in max-w-lg mx-auto">
                        <div
                            class="relative w-32 h-32 bg-[#0F172A] rounded-4xl flex items-center justify-center border border-slate-700/50 shadow-2xl overflow-hidden group">
                            <div
                                class="absolute inset-0 bg-linear-to-tr from-blue-600/30 to-purple-600/30 group-hover:scale-110 transition-transform duration-1000">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-blue-400 relative z-10"
                                viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 01.75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 019.75 22.5a.75.75 0 01-.75-.75v-4.131A15.838 15.838 0 016.382 15H2.25a.75.75 0 01-.75-.75 6.75 6.75 0 017.815-6.666zM15 6.75a2.25 2.25 0 100 4.5 2.25 2.25 0 000-4.5z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-4xl font-black text-white mb-4 tracking-tighter">Hai, Kami Siap Membantu!
                            </h2>
                            <p class="text-slate-400 text-base leading-relaxed">
                                Tanyakan apa pun tentang kebijakan perusahaan. Gunakan menu <span
                                    class="text-emerald-400 font-medium">Knowledge</span> untuk mengunggah dokumen
                                referensi Anda sendiri.
                            </p>
                        </div>
                    </div>
                @else
                    @foreach (session('chat_history') as $chat)
                        @if ($chat['role'] === 'user')
                            <div class="flex justify-end mb-6 animate-fade-in">
                                <div
                                    class="bg-blue-600 text-white rounded-3xl rounded-tr-md px-6 py-4 max-w-[85%] md:max-w-[70%] shadow-xl shadow-blue-900/20 text-[15px] leading-relaxed border border-white/10">
                                    {{ $chat['parts'][0]['text'] }}
                                </div>
                            </div>
                        @else
                            <div class="flex justify-start gap-5 mb-10 animate-fade-in">
                                <div
                                    class="w-10 h-10 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 mt-1 shadow-lg overflow-hidden relative">
                                    <div class="absolute inset-0 bg-blue-500/5"></div>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-blue-400 relative z-10" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                </div>
                                <div
                                    class="glass-panel text-slate-200 rounded-3xl rounded-tl-md px-8 py-6 max-w-[85%] md:max-w-[75%] border border-white/5 relative">
                                    @php
                                        $riskScore = $chat['risk_score'] ?? 0;
                                        $riskClass =
                                            $riskScore > 70
                                                ? 'text-rose-400 border-rose-500/30 bg-rose-500/5'
                                                : ($riskScore > 30
                                                    ? 'text-amber-400 border-amber-500/30 bg-amber-500/5'
                                                    : 'text-emerald-400 border-emerald-500/30 bg-emerald-500/5');

                                        $riskLabel =
                                            $riskScore > 70
                                                ? 'Unsafe Content'
                                                : ($riskScore > 30
                                                    ? 'Review Required'
                                                    : 'Verified Safe');
                                    @endphp
                                    <div
                                        class="flex items-center flex-wrap gap-3 mb-5 text-[10px] uppercase font-bold tracking-widest opacity-60">
                                        <span
                                            class="px-2.5 py-1 rounded-full border {{ $riskClass }}">{{ $riskLabel }}
                                            ({{ $riskScore }}%)
                                        </span>
                                        <span
                                            class="text-indigo-400 bg-indigo-500/5 px-2.5 py-1 rounded-full border border-indigo-500/20">Confidence:
                                            {{ $chat['confidence_score'] ?? 0 }}%</span>

                                        @if (!empty($chat['safety_reasoning']))
                                            <span
                                                class="text-slate-400 border border-white/10 px-2.5 py-1 rounded-full italic normal-case font-medium">
                                                Reason: {{ $chat['safety_reasoning'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="prose prose-invert prose-sm max-w-none">
                                        {!! Str::markdown($chat['parts'][0]['text']) !!}
                                    </div>

                                    @if (!empty($chat['sources']) && is_array($chat['sources']))
                                        <div class="mt-8 flex flex-col gap-2.5 border-t border-white/5 pt-5">
                                            @foreach ($chat['sources'] as $src)
                                                @php
                                                    $title = is_array($src)
                                                        ? $src['title'] ?? 'Sumber Asli'
                                                        : "Sumber #{$src}";
                                                    $title = str_replace(['ID:', 'id:'], '', $title);
                                                @endphp
                                                <div
                                                    class="flex items-center gap-2.5 text-xs text-emerald-400/80 bg-emerald-500/5 px-4 py-2.5 rounded-xl border border-emerald-500/10 w-fit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="font-medium">Referensi: <span
                                                            class="font-bold text-emerald-300 underline shadow-sm">{{ $title }}</span></span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            <!-- Input Area -->
            <div class="p-6 md:p-10 bg-[#0b0f19]/30 backdrop-blur-3xl border-t border-white/5">
                <form id="chat-form" class="max-w-4xl mx-auto relative">
                    <div id="loading-indicator" class="absolute -top-14 left-0 right-0 hidden animate-fade-in">
                        <div
                            class="flex items-center gap-3 text-slate-400 text-[10px] font-bold bg-slate-900/80 backdrop-blur-md px-5 py-2.5 rounded-full border border-white/10 w-fit mx-auto shadow-2xl uppercase tracking-widest">
                            <span class="animate-spin text-blue-400">⟳</span>
                            AI Sedang Menganalisis...
                        </div>
                    </div>

                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-linear-to-r from-blue-600/30 to-indigo-600/30 rounded-3xl blur-xl opacity-0 group-focus-within:opacity-100 transition duration-700">
                        </div>
                        <div
                            class="relative flex items-center gap-3 bg-[#0F172A]/90 border border-slate-700/60 rounded-3xl p-2 pl-7 focus-within:border-blue-500/50 focus-within:bg-[#0F172A] transition-all shadow-2xl">
                            <input type="text" id="prompt-input"
                                class="flex-1 bg-transparent py-5 text-white focus:outline-none placeholder-slate-600 text-base font-medium"
                                placeholder="Bagaimana cara mengatasi..." required autocomplete="off">

                            <button type="submit"
                                class="bg-linear-to-tr from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white p-5 rounded-2xl transition-all shadow-xl active:scale-90 group-active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-center text-[9px] text-slate-600 mt-6 uppercase tracking-[0.3em] font-bold opacity-60">
                    Gunakan AI dengan Bijak • Data Terenkripsi</p>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const side = document.getElementById('sidebar');
            const over = document.getElementById('sidebar-overlay');
            side.classList.toggle('open');
            over.classList.toggle('open');
        }

        const form = document.getElementById('chat-form');
        const container = document.getElementById('chat-container');
        const loading = document.getElementById('loading-indicator');
        const input = document.getElementById('prompt-input');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const prompt = input.value;
            if (!prompt) return;

            document.getElementById('welcome-screen')?.remove();
            appendMessage('user', prompt);
            input.value = '';
            loading.classList.remove('hidden');
            scrollToBottom();

            try {
                const response = await fetch("{{ route('beranda.ask') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        prompt: prompt
                    })
                });

                const data = await response.json();
                loading.classList.add('hidden');
                appendAiResponse(data);
            } catch (error) {
                loading.classList.add('hidden');
                appendMessage('error', "Koneksi terganggu. Pastikan server aktif.");
            }
        });

        function appendMessage(role, text) {
            const div = document.createElement('div');
            div.className = role === 'user' ? 'flex justify-end mb-6' : 'mb-6';
            if (role === 'user') {
                div.innerHTML =
                    `<div class="bg-blue-600 text-white rounded-3xl rounded-tr-md px-6 py-4 max-w-[85%] md:max-w-[70%] shadow-xl text-[15px] leading-relaxed border border-white/10 animate-fade-in">${text}</div>`;
            } else {
                div.innerHTML =
                    `<div class="text-red-400 text-[11px] px-4 py-2 border border-red-900/30 bg-red-900/10 rounded-xl w-fit mx-auto italic">${text}</div>`;
            }
            container.appendChild(div);
            scrollToBottom();
        }

        function appendAiResponse(data) {
            const div = document.createElement('div');
            div.className = 'flex justify-start gap-5 mb-10 animate-fade-in';

            let riskClass = data.risk_score > 70 ?
                'text-rose-400 border-rose-500/30 bg-rose-500/5' :
                (data.risk_score > 30 ?
                    'text-amber-400 border-amber-500/30 bg-amber-500/5' :
                    'text-emerald-400 border-emerald-500/30 bg-emerald-500/5');
            let riskLabel = data.risk_score > 70 ? 'Unsafe Content' : (data.risk_score > 30 ? 'Review Required' :
                'Verified Safe');

            let reasoningHtml = data.safety_reasoning ?
                `<span class="text-slate-400 border border-white/10 px-2.5 py-1 rounded-full italic normal-case font-medium">Reason: ${data.safety_reasoning}</span>` :
                '';

            let sourcesHtml = '';
            if (data.sources && Array.isArray(data.sources) && data.sources.length > 0) {
                sourcesHtml = '<div class="mt-8 flex flex-col gap-2.5 border-t border-white/5 pt-5">';
                data.sources.forEach(src => {
                    let title = (typeof src === 'object' && src !== null) ? (src.title || 'Sumber Asli') :
                        `Sumber #${src}`;
                    title = title.replace(/ID:|id:/g, '');
                    sourcesHtml += `
                        <div class="flex items-center gap-2.5 text-xs text-emerald-400/80 bg-emerald-500/5 px-4 py-2.5 rounded-xl border border-emerald-500/10 w-fit animate-fade-in">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium">Referensi: <span class="font-bold text-emerald-300 underline shadow-sm">${title}</span></span>
                        </div>`;
                });
                sourcesHtml += '</div>';
            }

            const uniqueId = 'type-' + Date.now();
            div.innerHTML = `
                <div class="w-10 h-10 rounded-2xl bg-slate-800 border border-slate-700 flex items-center justify-center shrink-0 mt-1 shadow-lg relative"><div class="absolute inset-0 bg-blue-500/5"></div><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400 relative z-10" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" /></svg></div>
                <div class="glass-panel text-slate-200 rounded-3xl rounded-tl-md px-8 py-6 max-w-[85%] md:max-w-[75%] border border-white/5 relative">
                    <div class="flex items-center flex-wrap gap-3 mb-5 text-[10px] uppercase font-bold tracking-widest opacity-60">
                        <span class="px-2.5 py-1 rounded-full border ${riskClass}">${riskLabel} (${data.risk_score}%)</span>
                        <span class="text-indigo-400 bg-indigo-500/5 px-2.5 py-1 rounded-full border border-indigo-500/20">Confidence: ${data.confidence_score}%</span>
                        ${reasoningHtml}
                    </div>
                    <div class="prose prose-invert prose-sm max-w-none typing-cursor" id="${uniqueId}"></div>
                    ${sourcesHtml}
                </div>`;
            container.appendChild(div);
            scrollToBottom();
            typeWriter(data.text, uniqueId);
        }

        function typeWriter(text, elementId) {
            const element = document.getElementById(elementId);
            let i = 0;

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    scrollToBottom();
                    setTimeout(type, 8);
                } else {
                    element.innerHTML = marked.parse(text);
                    element.classList.remove('typing-cursor');
                    hljs.highlightAll();
                }
            }
            type();
        }

        function scrollToBottom() {
            container.scrollTop = container.scrollHeight;
        }

        async function resetSession() {
            if (confirm('Buka percakapan baru?')) {
                await fetch("{{ route('beranda.reset') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                location.reload();
            }
        }
    </script>
</body>

</html>
