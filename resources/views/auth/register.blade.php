<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* El motor de la Aurora Atardecer */
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

<body class="h-screen w-screen overflow-hidden flex items-center justify-center bg-slate-900 font-sans text-white">

    <div class="aurora-container">
        <div class="orbe orbe-1"></div>
        <div class="orbe orbe-2"></div>
    </div>

    <div class="w-full max-w-md bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 shadow-2xl">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold tracking-wide text-white">Crear Cuenta</h2>
            <p class="text-white/50 text-sm mt-2">Ingresa tus datos para continuar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name" placeholder="Nombre de usuario"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all shadow-inner">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs font-medium pl-2" />
            </div>

            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    placeholder="Correo electrónico"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all shadow-inner">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs font-medium pl-2" />
            </div>

            <div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Contraseña"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all shadow-inner">
                <x-input-error :messages="$errors->get('password')"
                    class="mt-2 text-red-400 text-xs font-medium pl-2" />
            </div>

            <div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirmar contraseña"
                    class="w-full bg-white/5 border border-white/10 rounded-xl px-5 py-3 text-sm text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all shadow-inner">
                <x-input-error :messages="$errors->get('password_confirmation')"
                    class="mt-2 text-red-400 text-xs font-medium pl-2" />
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-white/90 hover:bg-white text-indigo-950 font-black py-4 rounded-xl text-xs transition-all shadow-lg active:scale-95 uppercase tracking-[0.2em]">
                    Registrarse
                </button>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}"
                    class="text-white/50 hover:text-white text-xs transition-colors flex items-center justify-center gap-2">
                    ¿Ya tienes cuenta?
                    <span
                        class="bg-white/5 px-4 py-1.5 rounded-full border border-white/10 hover:bg-white/20 transition-all">
                        Inicia sesión
                    </span>
                </a>
            </div>
        </form>
    </div>

</body>

</html>