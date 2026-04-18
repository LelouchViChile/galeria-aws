<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* El motor de la Aurora Atardecer con orbes móviles */
        .aurora-container {
            position: absolute;
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

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20vw, 20vh);
            }
        }

        @keyframes move2 {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(-15vw, -15vh);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="aurora-container">
        <div class="orbe orbe-1"></div>
        <div class="orbe orbe-2"></div>
    </div>

    <div
        class="w-full max-w-md bg-white/10 backdrop-blur-3xl border border-white/20 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">

        <div
            class="absolute top-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-white/50 to-transparent">
        </div>

        <div class="text-center mb-10 pt-2">
            <h1 class="text-3xl font-bold text-white mb-2 tracking-wide">Bienvenido</h1>
            <p class="text-white/70 text-sm">Ingresa tus credenciales para continuar</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <input type="email" name="email" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/10 transition-all"
                    placeholder="Correo Electrónico">
            </div>

            <div>
                <input type="password" name="password" required
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-4 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/10 transition-all"
                    placeholder="Contraseña">
            </div>

            <div class="pt-4 mb-6">
                <button type="submit"
                    class="w-full bg-white/90 hover:bg-white text-indigo-950 font-extrabold py-4 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] active:scale-95 tracking-wide uppercase">
                    Iniciar Sesión
                </button>
            </div>
        </form>

        <div class="text-center mt-6 border-t border-white/10 pt-4">
            <p class="text-white/70 text-sm mb-4">¿No tienes cuenta?</p>
            <a href="{{ route('register') }}"
                class="inline-block text-white/90 font-semibold border border-white/20 px-6 py-2 rounded-full text-xs hover:bg-white/10 backdrop-blur-md transition-all">
                Regístrate ahora
            </a>
        </div>
    </div>
</body>

</html>