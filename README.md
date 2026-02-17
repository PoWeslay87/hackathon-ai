🤖 Hackathon-AI

AI Document & Article QnA using Google Gemini API

Hackathon-AI adalah aplikasi web berbasis Artificial Intelligence yang menggunakan Google Gemini API (Gemini Studio) untuk membaca dokumen atau artikel yang diunggah pengguna, lalu memberikan jawaban berdasarkan isi dokumen tersebut.

Aplikasi ini membantu pengguna:

Mengunggah artikel atau dokumen

Mengajukan pertanyaan tentang isi dokumen

Mendapatkan jawaban otomatis dari AI sesuai konten dokumen

🌐 Demo: https://hackathon-ai-flax.vercel.app

✨ Fitur Utama

📄 Upload dokumen / artikel (PDF / text)

🤖 AI membaca dan memahami isi dokumen

💬 Tanya jawab berdasarkan dokumen sendiri

⚡ Menggunakan Google Gemini API (Gemini Studio)

🌍 Web-based application

🔐 API Key menggunakan file .env

🛠️ Teknologi yang Digunakan

Backend: PHP (Laravel / API service)

Frontend: Blade / HTML / CSS / JavaScript

AI Model: Google Gemini API (Gemini Studio)

Database: MySQL

Hosting: Vercel / Web Hosting

Version Control: GitHub

📂 Struktur Project
hackathon-ai/
│── api/
│── app/
│── bootstrap/
│── config/
│── database/
│── public/
│── resources/
│── routes/
│── storage/
│── tests/
│── .env.example
│── README.md

🚀 Cara Instalasi
1. Clone Repository
git clone https://github.com/PoWeslay87/hackathon-ai.git
cd hackathon-ai

2. Install Dependency
composer install

3. Copy File Environment
cp .env.example .env

4. Set API Key Gemini

Buka file .env lalu isi:

GEMINI_API_KEY=your_api_key_here


Dapatkan API Key dari:
https://ai.google.dev/

▶️ Cara Menjalankan
php artisan serve


Lalu buka di browser:

http://localhost:8000

📘 Cara Menggunakan Aplikasi

Upload dokumen atau artikel (PDF/Text)

Sistem membaca dan memproses isi dokumen

Ketik pertanyaan terkait dokumen

AI akan menjawab berdasarkan isi dokumen tersebut

Contoh:

Upload artikel tentang "AI"
Tanya: Apa kesimpulan dari artikel ini?
Jawaban: AI akan menjawab sesuai isi artikel

🎯 Tujuan Project

Project ini dibuat untuk:

Hackathon AI

Pembelajaran AI API (Gemini)

Sistem Document Question Answering

Pengembangan aplikasi AI berbasis web

👨‍💻 Developer

Weslay Charles Yarinap
GitHub: https://github.com/PoWeslay87

📜 License

Project ini menggunakan lisensi MIT License.
Bebas digunakan untuk pembelajaran dan pengembangan.
