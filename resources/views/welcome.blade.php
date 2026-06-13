<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería Dinámica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* El motor de la Aurora Atardecer con orbes móviles */
        .aurora-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            background: linear-gradient(-45deg, #111122, #222233);
        }

        .orbe {
            position: absolute;
            border-radius: 50%;
            filter: blur(150px);
            opacity: 0.6;
        }

        .orbe-1 {
            width: 600px;
            height: 600px;
            background: #9d174d;
            top: -100px;
            left: -100px;
            animation: move1 20s ease-in-out infinite;
        }

        .orbe-2 {
            width: 500px;
            height: 500px;
            background: #ea580c;
            bottom: -100px;
            right: -100px;
            animation: move2 25s ease-in-out infinite;
        }

        @keyframes move1 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20vw, 20vh); }
        }

        @keyframes move2 {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-15vw, -15vh); }
        }

        /* Estilo Apple para las flechas del carrusel */
        .swiper-button-next,
        .swiper-button-prev {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: 30px;
            border-radius: 50%;
            transform: scale(0.7);
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(0.8);
        }

        /* Scrollbar elegante para la barra lateral */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>

<body class="h-screen w-screen overflow-hidden flex bg-slate-900 font-sans text-white">

    <div class="aurora-container">
        <div class="orbe orbe-1"></div>
        <div class="orbe orbe-2"></div>
    </div>

    <div class="absolute top-6 right-6 z-50 flex gap-3">
        <select id="palette-selector"
            class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all outline-none cursor-pointer appearance-none text-center">
            <option value="atardecer" class="bg-slate-800 text-white py-2" selected>Atardecer (Default)</option>
            <option value="oceano" class="bg-slate-800 text-white py-2">Océano (Frío)</option>
            <option value="bosque" class="bg-slate-800 text-white py-2">Bosque (Naturaleza)</option>
            <option value="aurora" class="bg-slate-800 text-white py-2">Aurora (Apple)</option>
        </select>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white px-5 py-2 rounded-full text-sm font-semibold transition-all">
                Cerrar Sesión
            </button>
        </form>
    </div>

    <div id="toast-container" class="absolute top-20 right-6 z-50 flex flex-col gap-3">
        @if ($errors->any())
            <div class="toast-alert bg-red-500/80 backdrop-blur-md border border-red-400 text-white px-6 py-4 rounded-2xl shadow-xl transition-all duration-500">
                <ul class="list-disc pl-4 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="toast-alert bg-emerald-500/80 backdrop-blur-md border border-emerald-400 text-white px-6 py-4 rounded-2xl shadow-xl font-medium transition-all duration-500">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="relative z-10 w-full h-full p-6 pt-20 flex gap-6">

        <aside class="w-64 lg:w-80 h-full bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 flex flex-col shadow-2xl">
            <h2 class="text-3xl font-light tracking-wide mb-6">imágenes</h2>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-3">
                @forelse($items as $slide)
                    <div data-index="{{ $loop->index }}" onclick="swiper.slideToLoop(this.dataset.index)"
                        class="flex items-center gap-3 p-3 bg-white/5 hover:bg-white/10 border border-white/5 hover:border-white/20 rounded-xl transition-all cursor-pointer group active:scale-95">
                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-black/40 flex-shrink-0">
                            <img src="{{ Storage::disk('s3')->temporaryUrl($slide->ruta, now()->addMinutes(60)) }}"
                                class="w-full h-full object-cover opacity-70 group-hover:opacity-100 transition">
                        </div>
                        <div class="truncate text-sm font-medium text-white/80 group-hover:text-white">
                            {{ $slide->titulo ?: 'Imagen #' . $slide->id }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-white/40 text-sm">No hay imágenes en la base de datos.</p>
                    </div>
                @endforelse
            </div>
        </aside>

        <main class="flex-1 h-full flex flex-col items-center justify-between pb-6">

            <div class="w-full max-w-7xl h-[70%] bg-white/10 backdrop-blur-xl border border-white/20 rounded-[2rem] p-4 shadow-2xl">
                <div class="swiper mySwiper w-full h-full rounded-2xl overflow-hidden bg-black/40">
                    <div class="swiper-wrapper">
                        @forelse($items as $slide)
                            <div class="swiper-slide relative flex items-center justify-center">
                                <img src="{{ Storage::disk('s3')->temporaryUrl($slide->ruta, now()->addMinutes(60)) }}" class="w-full h-full object-contain">
                                @if($slide->titulo)
                                    <div class="absolute bottom-6 px-6 py-2 bg-black/60 backdrop-blur-md rounded-full border border-white/10">
                                        <h3 class="text-white font-medium">{{ $slide->titulo }}</h3>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="swiper-slide flex items-center justify-center">
                                <p class="text-white/60 font-medium">La galería está vacía.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>

            <div class="w-full max-w-2xl mt-6 bg-white/10 backdrop-blur-xl border border-white/20 rounded-[1.5rem] p-6 shadow-2xl">
                <form action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="text" name="titulo" placeholder="Título de la imagen (Opcional)"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all">

                    <input type="file" name="imagen" required
                        class="w-full text-xs text-white/70 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-semibold file:bg-white/20 file:text-white hover:file:bg-white/30 cursor-pointer transition-all">

                    <button type="submit"
                        class="w-full bg-white/90 hover:bg-white text-indigo-950 font-bold py-3 rounded-xl text-sm transition-all shadow-lg active:scale-95">
                        Añadir Slide
                    </button>
                </form>
            </div>
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            slidesPerView: 1,
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            }
        });

        setTimeout(() => {
            const toasts = document.querySelectorAll('.toast-alert');
            toasts.forEach(toast => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-20px)';
                setTimeout(() => toast.remove(), 500);
            });
        }, 4000);

        const select = document.getElementById('palette-selector');
        const orbe1 = document.querySelector('.orbe-1');
        const orbe2 = document.querySelector('.orbe-2');

        function aplicarPaleta(paleta) {
            if (paleta === 'oceano') {
                orbe1.style.background = '#0d9488'; orbe2.style.background = '#1e3a8a';
            } else if (paleta === 'bosque') {
                orbe1.style.background = '#166534'; orbe2.style.background = '#a16207';
            } else if (paleta === 'aurora') {
                orbe1.style.background = '#6366f1'; orbe2.style.background = '#a855f7';
            } else {
                orbe1.style.background = '#9d174d'; orbe2.style.background = '#ea580c';
            }
        }

        const paletaGuardada = localStorage.getItem('paleta-seleccionada') || 'atardecer';
        select.value = paletaGuardada;
        aplicarPaleta(paletaGuardada);

        select.addEventListener('change', (e) => {
            localStorage.setItem('paleta-seleccionada', e.target.value);
            aplicarPaleta(e.target.value);
        });
    </script>
</body>

</html>
