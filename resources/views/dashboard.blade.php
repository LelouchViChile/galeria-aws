<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zona de Peligro: Ruleta Rusa') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-2xl sm:rounded-xl border border-gray-700">
                <div class="p-8 text-white flex flex-col items-center text-center">

                    <h3 class="text-5xl font-extrabold text-red-600 mb-2 tracking-widest uppercase drop-shadow-lg">
                        Ruleta Rusa</h3>
                    <p class="text-gray-400 mb-8 text-lg">Sobrevive a las 5 rondas. Solo hay una bala en el cilindro de
                        6.</p>

                    <div id="cilindro"
                        class="relative w-48 h-48 bg-gray-800 rounded-full border-8 border-gray-600 flex items-center justify-center mb-8 shadow-[0_0_40px_rgba(220,38,38,0.2)] transition-transform duration-700 ease-out">
                        <div class="w-8 h-8 bg-gray-900 rounded-full absolute top-2 shadow-inner"></div>
                        <span class="text-6xl select-none" id="icono-estado">🎲</span>
                    </div>

                    <div class="h-16 mb-6">
                        <p id="mensaje" class="text-2xl font-bold text-yellow-500 animate-pulse">¡Gira el cilindro para
                            empezar tu suerte!</p>
                    </div>

                    <div class="flex flex-wrap justify-center gap-4 w-full">
                        <button id="btn-girar"
                            class="px-8 py-4 bg-blue-700 hover:bg-blue-600 text-white font-bold rounded-lg shadow-lg transition-all transform hover:-translate-y-1">
                            🔄 Girar Cilindro
                        </button>

                        <button id="btn-disparar"
                            class="px-8 py-4 bg-red-700 hover:bg-red-600 text-white font-bold rounded-lg shadow-lg transition-all transform hover:-translate-y-1 hidden">
                            🎯 Apretar Gatillo
                        </button>

                        <button id="btn-reiniciar"
                            class="px-8 py-4 bg-gray-700 hover:bg-gray-600 text-white font-bold rounded-lg shadow-lg transition-all transform hover:-translate-y-1 hidden">
                            🔁 Volver a Jugar
                        </button>
                    </div>

                    <div class="mt-10 text-gray-500 font-mono text-lg border-t border-gray-700 pt-6 w-full">
                        Rondas sobrevivientes: <span id="contador" class="text-white font-bold text-xl">0</span> / 5
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let balaPosicion = 0;
        let recamaraActual = 0;
        let disparos = 0;
        let juegoActivo = false;

        const btnGirar = document.getElementById('btn-girar');
        const btnDisparar = document.getElementById('btn-disparar');
        const btnReiniciar = document.getElementById('btn-reiniciar');
        const mensaje = document.getElementById('mensaje');
        const contador = document.getElementById('contador');
        const cilindro = document.getElementById('cilindro');
        const iconoEstado = document.getElementById('icono-estado');

        // Función para girar el cilindro
        btnGirar.addEventListener('click', () => {
            // Asigna la bala a una posición del 1 al 6
            balaPosicion = Math.floor(Math.random() * 6) + 1;
            recamaraActual = 1;
            disparos = 0;
            juegoActivo = true;

            // Animación visual rotando grados aleatorios
            cilindro.style.transform = `rotate(${Math.floor(Math.random() * 720) + 720}deg)`;
            iconoEstado.innerText = '🔫';

            mensaje.innerText = "Cilindro girado. Tu turno...";
            mensaje.className = "text-2xl font-bold text-white";
            contador.innerText = disparos;

            // Cambiar botones
            btnGirar.classList.add('hidden');
            btnDisparar.classList.remove('hidden');
        });

        // Función para disparar
        btnDisparar.addEventListener('click', () => {
            if (!juegoActivo) return;

            // Pequeña animación de retroceso en el cilindro
            cilindro.style.transform = `rotate(${parseInt(cilindro.style.transform.replace(/[^0-9\-]/g, '')) + 60}deg)`;

            if (recamaraActual === balaPosicion) {
                // El jugador pierde
                juegoActivo = false;
                iconoEstado.innerText = '💀';
                cilindro.classList.replace('bg-gray-800', 'bg-red-900');
                cilindro.classList.replace('border-gray-600', 'border-red-600');

                mensaje.innerText = "¡PUM! Estás muerto.";
                mensaje.className = "text-4xl font-black text-red-500 drop-shadow-[0_0_10px_rgba(220,38,38,0.8)]";

                terminarJuego();
            } else {
                // El jugador se salva (Click)
                disparos++;
                contador.innerText = disparos;
                iconoEstado.innerText = '😅';

                mensaje.innerText = "Click... te has salvado.";
                mensaje.className = "text-2xl font-bold text-green-400";

                recamaraActual++;

                // Si sobrevive 5 disparos, gana
                if (disparos === 5) {
                    juegoActivo = false;
                    iconoEstado.innerText = '🏆';
                    mensaje.innerText = "¡Sobreviviste! Eres libre.";
                    mensaje.className = "text-4xl font-black text-blue-400 animate-bounce";
                    terminarJuego();
                }
            }
        });

        // Función para reiniciar
        btnReiniciar.addEventListener('click', () => {
            btnReiniciar.classList.add('hidden');
            btnGirar.classList.remove('hidden');

            cilindro.classList.replace('bg-red-900', 'bg-gray-800');
            cilindro.classList.replace('border-red-600', 'border-gray-600');
            cilindro.style.transform = 'rotate(0deg)';

            iconoEstado.innerText = '🎲';
            mensaje.innerText = "¡Gira el cilindro para empezar tu suerte!";
            mensaje.className = "text-2xl font-bold text-yellow-500 animate-pulse";
            contador.innerText = "0";
        });

        function terminarJuego() {
            btnDisparar.classList.add('hidden');
            btnReiniciar.classList.remove('hidden');
        }
    </script>
</x-app-layout>