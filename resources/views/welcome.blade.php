<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Presensi SMKN 1 Sukorejo - Sistem Absensi & Jurnal Mengajar Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        body {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .gradient-blue {
            background: #3b82f6;
        }

        .text-gradient {
            color: #3b82f6;
        }

        /* writing animation */
        .typewriter {
            overflow: hidden;
            border-right: .15em solid white;
            white-space: nowrap;
            animation: typing 3.5s steps(40, end), blink-caret .75s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent
            }

            50% {
                border-color: white;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white-500 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/logo-smk.png') }}" alt="SMKN 1 Sukorejo"
                            class="w-full h-full object-cover">
                    </div>
                    <span class="text-xl font-bold text-gray-900">Presensi SMKN 1 Sukorejo</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#fitur" class="hidden md:block text-gray-600 hover:text-blue-600 transition">Fitur</a>
                    <a href="#tentang" class="hidden md:block text-gray-600 hover:text-blue-600 transition">Tentang</a>
                    <a href="/user/login"
                        class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 hover:shadow-lg transform hover:scale-105 transition duration-300">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Auto Slider -->
    <section class="pt-24 pb-12 overflow-hidden relative min-h-screen flex items-center">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/IMG_20250728_082657.jpg') }}" alt="SMKN 1 Sukorejo"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-6 opacity-0 animate-slideInLeft p-8 rounded-2xl">
                    <div class="inline-block">
                        <span class="bg-blue-100 text-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
                            Sistem Presensi Digital
                        </span>
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                        <div id="typewriter-text"></div>
                    </h1>
                    <p class="text-lg text-white leading-relaxed">
                        Sistem absensi dan jurnal mengajar digital untuk SMKN 1 Sukorejo. Absen cepat, jurnal praktis,
                        rekap otomatis!
                    </p>
                </div>

                <!-- Right Content - Auto Slider -->
                <div class="relative opacity-0 animate-slideInRight delay-200">
                    <div class="relative h-96 rounded-2xl overflow-hidden shadow-2xl">
                        <!-- Slide 1 -->
                        <div class="slide absolute inset-0 transition-opacity duration-1000">
                            <div class="w-full h-full bg-blue-500 flex items-center justify-center p-8">
                                <div class="text-center text-white space-y-4">
                                    <svg class="w-32 h-32 mx-auto animate-float" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-2xl font-bold">Absensi Digital</h3>
                                    <p class="text-blue-100">Catat kehadiran siswa dengan cepat dan akurat</p>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                            <div class="w-full h-full bg-blue-600 flex items-center justify-center p-8">
                                <div class="text-center text-white space-y-4">
                                    <svg class="w-32 h-32 mx-auto animate-float" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    <h3 class="text-2xl font-bold">Jurnal Mengajar</h3>
                                    <p class="text-blue-100">Dokumentasi kegiatan pembelajaran harian</p>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="slide absolute inset-0 transition-opacity duration-1000 opacity-0">
                            <div class="w-full h-full bg-blue-700 flex items-center justify-center p-8">
                                <div class="text-center text-white space-y-4">
                                    <svg class="w-32 h-32 mx-auto animate-float" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <h3 class="text-2xl font-bold">Rekap Otomatis</h3>
                                    <p class="text-blue-100">Laporan kehadiran tersedia kapan saja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slider Indicators -->
                    <div class="flex justify-center space-x-2 mt-6">
                        <button class="indicator w-3 h-3 rounded-full bg-blue-600 transition-all duration-300"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                        <button class="indicator w-3 h-3 rounded-full bg-gray-300 transition-all duration-300"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 opacity-0 animate-fadeInUp">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Semua yang Anda butuhkan dalam satu platform</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-100 bg-blue-50 p-8 rounded-2xl hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Absensi Praktis</h3>
                    <p class="text-gray-600 leading-relaxed">Catat kehadiran siswa dengan mudah dan cepat. Sistem
                        otomatis mencatat waktu dan tanggal absensi.</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-200 bg-blue-50 p-8 rounded-2xl hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Jurnal Digital</h3>
                    <p class="text-gray-600 leading-relaxed">Isi jurnal mengajar secara online dengan formulir yang
                        mudah dipahami dan tersimpan aman.</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="opacity-0 animate-fadeInUp delay-300 bg-blue-50 p-8 rounded-2xl hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Rekap Instan</h3>
                    <p class="text-gray-600 leading-relaxed">Dapatkan laporan rekap absensi dan jurnal dalam berbagai
                        format dengan satu klik saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-blue">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="opacity-0 animate-fadeInUp space-y-6">
                <h2 class="text-4xl md:text-5xl font-bold text-white">
                    Siap Memulai?
                </h2>
                <p class="text-xl text-blue-100">
                    Bergabunglah dengan sistem presensi digital SMKN 1 Sukorejo sekarang!
                </p>
                <a href="/user/login"
                    class="inline-block bg-white text-blue-600 px-10 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition duration-300">
                    Login Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="tentang" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Presensi SMKN 1 Sukorejo</h3>
                    <p class="text-gray-400">Sistem absensi dan jurnal mengajar digital yang memudahkan proses
                        administrasi sekolah.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Fitur</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Absensi Digital</li>
                        <li>Jurnal Mengajar</li>
                        <li>Rekap Otomatis</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>SMKN 1 Sukorejo</li>
                        <li>Jawa Timur, Indonesia</li>
                        <li>smkn1sukorejo.sch.id</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Presensi SMKN 1 Sukorejo. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Auto Slider
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');

        function showSlide(n) {
            slides.forEach((slide, index) => {
                slide.style.opacity = index === n ? '1' : '0';
            });
            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('bg-blue-600', index === n);
                indicator.classList.toggle('bg-gray-300', index !== n);
                indicator.classList.toggle('w-8', index === n);
                indicator.classList.toggle('w-3', index !== n);
            });
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Auto advance every 4 seconds
        setInterval(nextSlide, 4000);

        // Manual control
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fadeInUp, .animate-slideInLeft, .animate-slideInRight').forEach(el => {
            observer.observe(el);
        });

        // Writing animation
        const text = "Kelola Absensi & Jurnal\nLebih Mudah";
        const speed = 50;
        let i = 0;

        function typeWriter() {
            if (i < text.length) {
                const char = text.charAt(i);
                const element = document.getElementById("typewriter-text");

                if (char === '\n') {
                    element.innerHTML += '<br>';
                } else if (i > text.indexOf('\n')) {
                    element.innerHTML +=
                        `<span class="bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">${char}</span>`;
                } else {
                    element.innerHTML += char;
                }

                i++;
                setTimeout(typeWriter, speed);
            }
        }

        document.addEventListener('DOMContentLoaded', typeWriter);
    </script>
</body>

</html>
