<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JCH Raffle Event - Mbloc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Space Grotesk', sans-serif; 
            background-color: #000510;
            margin: 0;
            height: 100vh;
            overflow: hidden; 
        }
        .neon-text { text-shadow: 0 0 10px #fff, 0 0 20px #0ea5e9, 0 0 40px #0ea5e9; }
        .glass { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(20px); border: 1px solid rgba(14, 165, 233, 0.2); }
        input::placeholder { color: rgba(255,255,255,0.1); }
        
        .bg-glow {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .rules-card {
            border-left: 4px solid #0ea5e9;
            background: linear-gradient(90deg, rgba(14, 165, 233, 0.1) 0%, transparent 100%);
        }
    </style>
</head>
<body class="text-white relative flex flex-col items-center justify-center">

    <div class="fixed top-8 right-10 z-50">
        @if (Route::has('login'))
            @auth
                <a href="{{ route('admin.index') }}" class="bg-sky-600 hover:bg-sky-700 text-white text-[10px] font-bold px-4 py-2 rounded-full shadow-lg transition-all uppercase">
                    Admin
                </a>
            @else
                <a href="{{ route('login') }}" class="w-3 h-3 bg-sky-900/30 hover:bg-sky-400 rounded-full block transition-all"></a>
            @endauth
        @endif
    </div>

    <div class="bg-glow opacity-40">
        <div class="absolute top-[-10%] left-[-10%] w-[400px] h-[400px] bg-sky-900 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-blue-800 rounded-full blur-[150px]"></div>
    </div>

    <header class="absolute top-10 w-full flex justify-center z-20">
        <h2 class="text-lg font-bold tracking-[0.3em] text-sky-400 uppercase">
            Jakarta <span class="text-white font-light">Creative</span> Hub
        </h2>
    </header>

    <main class="relative z-10 w-full max-w-6xl mx-auto px-6 h-full flex items-center justify-center">
        
        <div id="step-registration" class="grid grid-cols-12 gap-10 items-center w-full">
            <div class="col-span-7 text-left space-y-6">
                <div>
                    <h1 class="text-7xl font-black tracking-tighter neon-text uppercase leading-none mb-4">
                        GET YOUR<br>LUCK!
                    </h1>
                    <p class="text-lg text-sky-100/50 font-light italic">
                        Tuliskan namamu dan mulai keberuntunganmu hari ini.
                    </p>
                </div>

                <div class="space-y-6">
                    <input type="text" id="participant-name" autocomplete="off"
                        class="w-full bg-transparent border-b border-sky-500/30 text-4xl focus:outline-none focus:border-sky-400 transition-all uppercase font-bold py-3 text-sky-100"
                        placeholder="NAMA KAMU...">
                    
                    <button onclick="startRaffle()" 
                        class="group px-12 py-5 bg-sky-500 text-white text-xl font-black rounded-full transition-all hover:scale-105 hover:bg-sky-400 shadow-[0_10px_40px_rgba(14,165,233,0.3)] uppercase">
                        SPIN NOW!
                    </button>
                </div>
            </div>

            <div class="col-span-5 space-y-4">
                <div class="glass p-6 rounded-3xl rules-card">
                    <h3 class="text-sky-400 font-bold tracking-widest uppercase text-[10px] mb-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-sky-400 rounded-full animate-pulse"></span>
                        How to Play
                    </h3>
                    <ul class="space-y-2 text-sky-100/70 text-xs italic leading-relaxed">
                        <li>01. Selesaikan misi stamp di area event.</li>
                        <li>02. Tunjukkan hasil misi ke Staff JCH.</li>
                        <li>03. Wajib Follow Instagram @jakartacreativehub.</li>
                    </ul>
                </div>

                <div class="glass p-8 rounded-[40px] flex flex-col items-center gap-4 text-center">
                    <div class="p-3 bg-white rounded-2xl shadow-xl">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.instagram.com/jakartacreativehub/" 
                             class="w-32 h-32">
                    </div>
                    <div>
                        <p class="text-[9px] text-sky-400 font-bold tracking-widest uppercase mb-1">Official Instagram</p>
                        <h3 class="text-xl font-bold text-white italic tracking-tight">@jakartacreativehub</h3>
                    </div>
                </div>
            </div>
        </div>

        <div id="step-spinning" class="hidden w-full max-w-2xl text-center space-y-10">
            <h1 class="text-2xl font-bold tracking-[0.5em] text-sky-400 uppercase animate-pulse">GENERATING LUCK...</h1>
            <div id="spinner-box" class="h-40 overflow-hidden relative border-y border-sky-500/50 w-full glass rounded-xl">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
                    <div class="w-full h-[1px] bg-sky-400 shadow-[0_0_15px_rgba(14,165,233,1)]"></div>
                </div>
                <div id="items-container" class="flex flex-col items-center"></div>
            </div>
        </div>

        <div id="step-result" class="hidden w-full max-w-4xl text-center flex flex-col items-center justify-center space-y-6">
            <div class="space-y-1">
                <h2 id="result-title" class="text-xl text-sky-400 font-bold uppercase tracking-[0.4em]">VICTORY!</h2>
                <div id="winner-name-display" class="text-6xl font-black text-white uppercase italic tracking-tighter"></div>
            </div>
            
            <div class="glass w-full py-12 px-6 rounded-[50px] border border-sky-500/10 shadow-2xl">
                <div id="prize-display" class="text-8xl font-black text-sky-400 neon-text leading-none uppercase tracking-tighter"></div>
            </div>
            
            <button onclick="location.reload()" 
                class="px-10 py-4 border border-sky-500/30 text-sky-400 hover:bg-sky-500 hover:text-white transition-all uppercase font-bold tracking-widest rounded-full text-xs">
                READY FOR NEXT WINNER?
            </button>
        </div>
    </main>

    <script>
        const csrfToken = "{{ csrf_token() }}";

        function startRaffle() {
            const nameField = document.getElementById('participant-name');
            const name = nameField.value.trim();
            if(!name) {
                gsap.to(nameField, { x: 10, repeat: 5, yoyo: true, duration: 0.05 });
                return;
            }

            gsap.to("#step-registration", { opacity: 0, y: -20, duration: 0.4, onComplete: () => {
                document.getElementById('step-registration').classList.add('hidden');
                document.getElementById('step-spinning').classList.remove('hidden');
                processDraw(name);
            }});
        }

        async function processDraw(name) {
            try {
                const response = await fetch("{{ route('raffle.draw') }}", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ name: name })
                });
                const result = await response.json();
                const container = document.getElementById('items-container');
                let dummyItems = {!! json_encode($prizes) !!};
                if (dummyItems.length === 0) dummyItems = ["ZONK", "TRY AGAIN"];

                container.innerHTML = '';
                for(let i=0; i<60; i++) {
                    let div = document.createElement('div');
                    div.className = "h-40 flex items-center justify-center text-4xl font-bold opacity-10 text-sky-800 uppercase italic";
                    div.innerText = dummyItems[Math.floor(Math.random() * dummyItems.length)];
                    container.appendChild(div);
                }

                let finalDiv = document.createElement('div');
                const isZonk = result.prize.toLowerCase().includes('zonk');
                finalDiv.className = `h-40 flex items-center justify-center text-6xl font-black uppercase italic ${isZonk ? 'text-slate-700' : 'text-sky-400 neon-text'}`;
                finalDiv.innerText = result.prize; 
                container.appendChild(finalDiv);

                gsap.to(container, { 
                    y: -(container.children.length - 1) * 160, 
                    duration: 6, 
                    ease: "expo.inOut", 
                    onComplete: () => { setTimeout(() => showResult(result), 500); }
                });
            } catch (err) { location.reload(); }
        }

        function showResult(result) {
            gsap.to("#step-spinning", { opacity: 0, duration: 0.4, onComplete: () => {
                document.getElementById('step-spinning').classList.add('hidden');
                document.getElementById('step-result').classList.remove('hidden');
                
                const title = document.getElementById('result-title');
                const isZonk = result.prize.toLowerCase().includes('zonk');
                
                title.innerText = isZonk ? "BETTER LUCK NEXT TIME!" : "VICTORY!";
                title.className = `text-xl font-bold uppercase tracking-[0.4em] ${isZonk ? 'text-slate-500' : 'text-sky-400'}`;
                
                document.getElementById('winner-name-display').innerText = result.winner_name;
                document.getElementById('prize-display').innerText = result.prize;
                
                gsap.from("#step-result", { scale: 0.9, opacity: 0, duration: 0.6, ease: "back.out(1.7)" });
            }});
        }

        document.addEventListener('keydown', (e) => {
            if((e.code === "Space" || e.code === "Enter") && !document.getElementById('step-registration').classList.contains('hidden')) {
                startRaffle();
            }
        });
    </script>
</body>
</html>