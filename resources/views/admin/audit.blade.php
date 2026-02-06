<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Governance Audit Log</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Global Scaling */
        html {
            font-size: 13.5px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0b0f19;
            color: #e2e8f0;
        }

        .glass-panel {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-[#0b0f19] min-h-screen text-slate-200 p-4 md:p-8 relative overflow-x-hidden">

    <!-- Cosmic Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#060910]">
        <!-- Technical Grid -->
        <div class="absolute inset-0 opacity-[0.1]"
            style="background-image: 
                linear-gradient(#1e293b 1px, transparent 1px), 
                linear-gradient(90deg, #1e293b 1px, transparent 1px);
             background-size: 40px 40px;">
        </div>
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-900/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-900/20 rounded-full blur-[120px]">
        </div>
    </div>

    <div class="w-[98%] mx-auto py-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Audit Trail & <span
                        class="text-blue-400">Governance</span></h1>
                <p class="text-slate-400 text-base mt-1">Immutable record of all AI interactions.</p>
            </div>
            <a href="{{ url('/') }}"
                class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to AI Chat
            </a>
        </div>

        <div class="bg-slate-900/50 backdrop-blur border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left text-slate-300">
                    <thead class="bg-slate-950 text-slate-100 uppercase font-bold text-xs tracking-wider">
                        <tr>
                            <th class="px-3 py-4">Timestamp</th>
                            <th class="px-3 py-4">User</th>
                            <th class="px-3 py-4 min-w-[150px]">Prompt</th>
                            <th class="px-3 py-4 min-w-[200px]">Response</th>
                            <th class="px-3 py-4">Risk</th>
                            <th class="px-3 py-4">Status</th>
                            <th class="px-3 py-4">Reasoning</th>
                            <th class="px-3 py-4">Model</th>
                            <th class="px-3 py-4">Source</th>
                            <th class="px-3 py-4 text-right min-w-[110px]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-[13px]">
                        @foreach ($logs as $log)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-3 py-3 whitespace-nowrap text-slate-400 text-[11px]">
                                    {{ $log->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-3 py-3 font-medium">{{ $log->user_id ?? 'Guest' }}</td>
                                <td class="px-3 py-3">
                                    <div class="line-clamp-1 text-[12px]" title="{{ $log->input_prompt }}">
                                        {{ $log->input_prompt }}
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="line-clamp-1 text-[12px]" title="{{ $log->ai_response }}">
                                        {{ $log->ai_response }}
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <div class="h-1 w-12 bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full {{ $log->risk_score > 70 ? 'bg-red-500' : ($log->risk_score > 30 ? 'bg-yellow-500' : 'bg-emerald-500') }}"
                                                style="width: {{ $log->risk_score }}%"></div>
                                        </div>
                                        <span class="text-[10px]">{{ $log->risk_score }}%</span>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <span
                                        class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-tighter
                                    {{ $log->status === 'flagged' ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' }}">
                                        {{ $log->status }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="max-w-[120px] truncate text-[10px] text-slate-500 italic"
                                        title="{{ $log->safety_reasoning }}">
                                        {{ $log->safety_reasoning ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-3 py-3 whitespace-nowrap">
                                    <span
                                        class="text-[9px] bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded border border-blue-500/20 font-bold uppercase">
                                        {{ str_replace('GEMINI-', '', strtoupper($log->model_version ?? '1.5')) }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 text-[10px] font-mono">
                                    @if (!empty($log->sources_used) && is_array($log->sources_used))
                                        <span class="text-blue-400">ID:{{ count($log->sources_used) }}</span>
                                    @else
                                        <span class="text-slate-600">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-right">
                                    <div class="flex justify-end gap-1">
                                        <button onclick="toggleStatus({{ $log->id }}, 'flagged')"
                                            class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white transition-all border border-red-500/20"
                                            title="Flag as Unsafe">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                            </svg>
                                        </button>
                                        <button onclick="toggleStatus({{ $log->id }}, 'approved')"
                                            class="p-2 rounded-lg bg-emerald-500/10 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all border border-emerald-500/20"
                                            title="Approve">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                        <button onclick="deleteLog({{ $log->id }})"
                                            class="p-2 rounded-lg bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white transition-all border border-red-500/20"
                                            title="Delete Log">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-white/5">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <script>
        async function toggleStatus(id, newStatus) {
            try {
                const response = await fetch(`/audit-logs/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal memperbarui status.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            }
        }

        async function deleteLog(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus log ini secara permanen?')) return;

            try {
                const response = await fetch(`/audit-logs/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    location.reload();
                } else {
                    alert('Gagal menghapus log.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            }
        }
    </script>
</body>

</html>
