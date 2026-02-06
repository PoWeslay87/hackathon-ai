<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Global Scaling */
        html {
            font-size: 14.5px;
        }

        /* Consistent 70% scale */

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
        <div class="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] bg-emerald-900/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-blue-900/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Manajemen <span
                        class="text-emerald-400">Pengetahuan</span></h1>
                <p class="text-slate-400 text-base mt-1">Input data PDF/Jurnal Anda di sini agar dibaca oleh AI.</p>
            </div>
            <a href="{{ url('/') }}"
                class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:scale-105 active:scale-95 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Chat
            </a>
        </div>

        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium flex items-center gap-2 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Left: Input Form -->
            <div class="space-y-6">
                <div class="glass-panel p-6 rounded-2xl shadow-xl border-t border-white/10">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Tambah Data Baru
                    </h2>

                    <form action="{{ route('knowledge.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-slate-400 text-sm font-medium mb-1.5">Judul Dokumen</label>
                            <input type="text" name="title" required id="doc-title"
                                class="w-full bg-[#0b0f19] border border-slate-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-xl px-4 py-3 text-white placeholder-slate-600 transition-all outline-none"
                                placeholder="Contoh: Jurnal AI 2024.pdf">
                        </div>

                        <!-- Magic Upload Zone -->
                        <div class="relative group">
                            <label class="block text-slate-400 text-sm font-medium mb-1.5">Upload File (PDF /
                                Teks)</label>
                            <div
                                class="relative w-full h-12 flex items-center justify-center bg-slate-800/50 border border-dashed border-slate-600 rounded-xl hover:border-emerald-500/50 hover:bg-emerald-500/5 transition-all cursor-pointer overflow-hidden">
                                <input type="file" id="file-upload" accept=".pdf,.txt,.md"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <span
                                    class="text-xs text-slate-400 flex items-center gap-2 pointer-events-none group-hover:text-emerald-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Klik atau Geser File PDF/TXT ke sini
                                </span>
                            </div>
                            <p id="upload-status" class="text-[10px] text-emerald-400 mt-1 hidden">Sedang membaca
                                file...</p>
                        </div>

                        <div>
                            <label class="block text-slate-400 text-sm font-medium mb-1.5">Isi Konten (Otomatis
                                Terisi)</label>
                            <textarea name="content" required rows="8" id="doc-content"
                                class="w-full bg-[#0b0f19] border border-slate-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 rounded-xl px-4 py-3 text-white placeholder-slate-600 transition-all outline-none resize-none"
                                placeholder="Teks dari file akan muncul di sini..."></textarea>
                            <p class="text-xs text-slate-500 mt-2 text-right">AI akan membaca teks ini untuk menjawab
                                pertanyaan.</p>
                        </div>

                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-medium py-3 rounded-xl transition-all shadow-lg shadow-emerald-900/20 active:scale-95">
                            Simpan ke Memori AI
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: List -->
            <div class="space-y-6">
                <div class="glass-panel p-6 rounded-2xl shadow-xl border-t border-white/10 h-full">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                        Daftar Dokumen Aktif
                    </h2>

                    <div class="space-y-3 overflow-y-auto max-h-[600px] pr-2 custom-scrollbar">
                        @if ($documents->isEmpty())
                            <div
                                class="text-center py-10 text-slate-500 border-2 border-dashed border-slate-800 rounded-xl">
                                <p>Belum ada dokumen.</p>
                                <p class="text-xs">Input data di sebelah kiri.</p>
                            </div>
                        @else
                            @foreach ($documents as $doc)
                                <div
                                    class="group p-4 bg-slate-800/50 hover:bg-slate-800 border border-slate-700 rounded-xl transition-all">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3
                                            class="font-semibold text-slate-200 group-hover:text-white transition-colors">
                                            {{ $doc->title }}</h3>
                                        <span
                                            class="text-[10px] bg-slate-900 border border-slate-700 px-1.5 py-0.5 rounded text-slate-400 font-mono">ID:
                                            {{ $doc->id }}</span>
                                    </div>
                                    <p class="text-slate-400 text-xs line-clamp-2 mb-3">
                                        {{ Str::limit($doc->content, 100) }}</p>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-600">{{ $doc->created_at->diffForHumans() }}</span>
                                        <div class="flex gap-2">
                                            <!-- Simple Edit Trigger (Populate form) -->
                                            <button
                                                onclick="editDoc('{{ $doc->id }}', '{{ addslashes($doc->title) }}', formContent('{{ base64_encode($doc->content) }}'))"
                                                class="text-blue-400 hover:text-blue-300 hover:underline">Edit</button>

                                            <form action="{{ route('knowledge.destroy', $doc->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus dokumen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-400 hover:text-red-300 hover:underline">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- PDF.js Legacy (Better compatibility) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        const fileInput = document.getElementById('file-upload');
        const contentArea = document.getElementById('doc-content');
        const titleInput = document.getElementById('doc-title');
        const statusMsg = document.getElementById('upload-status');

        fileInput.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Auto-fill title if empty
            if (!titleInput.value) {
                titleInput.value = file.name;
            }

            statusMsg.classList.remove('hidden');
            statusMsg.textContent = "Membaca file: " + file.name + "...";

            try {
                if (file.type === 'application/pdf') {
                    const text = await parsePdf(file);
                    contentArea.value = text;
                    statusMsg.textContent = "Berhasil membaca PDF! (" + text.length + " karakter)";
                } else {
                    // Text files
                    const text = await file.text();
                    contentArea.value = text;
                    statusMsg.textContent = "Berhasil membaca Teks!";
                }
            } catch (err) {
                console.error(err);
                statusMsg.textContent = "Gagal membaca file: " + err.message;
                statusMsg.classList.add('text-red-400');
            }
        });

        async function parsePdf(file) {
            const arrayBuffer = await file.arrayBuffer();
            const pdf = await pdfjsLib.getDocument({
                data: arrayBuffer
            }).promise;
            let fullText = "";

            for (let i = 1; i <= pdf.numPages; i++) {
                const page = await pdf.getPage(i);
                const textContent = await page.getTextContent();
                const pageText = textContent.items.map(item => item.str).join(' ');
                fullText += `--- Halaman ${i} ---\n${pageText}\n\n`;
            }
            return fullText;
        }

        function editDoc(id, title, encodedContent) {
            // Decoding base64 to avoid quote escaping issues in inline JS
            const content = atob(encodedContent);
            document.getElementById('doc-title').value = title;
            document.getElementById('doc-content').value = content;
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            // Ideally change form action to update, but for Hackathon MVP, simpler to "Create New" or manually delete old one.
            // Let's keep it simple: Just populates for easy re-creation/updates.
            alert("Mode Edit: Silakan ubah dan simpan sebagai dokumen baru (Hapus yang lama jika perlu).");
        }

        function formContent(c) {
            return c;
        }
    </script>
</body>

</html>
