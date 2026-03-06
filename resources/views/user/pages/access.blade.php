<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eAlbum Viewer | Premium Experience</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/3/turn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { background-color: #050505; overflow: hidden; font-family: 'Inter', sans-serif; }
        #flipbook-wrapper { perspective: 2000px; display: flex; align-items: center; justify-content: center; }
        #flipbook { width: 1000px; height: 600px; display: none; box-shadow: 0 0 50px rgba(0, 0, 0, 0.8); }
        #flipbook .page { width: 500px; height: 600px; background-color: #fff; line-height: 0; overflow: hidden; }
        #flipbook img { width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
        .hard { background-color: #1a1a1a !important; box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5); }
        #loader { display: none; backdrop-blur: 10px; }
        .spinner { border: 4px solid rgba(255, 255, 255, 0.1); border-top: 4px solid #6366f1; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <div id="access-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 text-center border-t-8 border-indigo-600 relative transform transition-all">
            <button onclick="closeModal()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500 transition-colors">
                <i class="fa-solid fa-circle-xmark text-2xl"></i>
            </button>
            <div class="flex justify-center mb-8">
                <div class="p-5 bg-indigo-50 rounded-3xl shadow-inner">
                    <i class="fa-solid fa-lock-open text-4xl text-indigo-600"></i>
                </div>
            </div>
            <h2 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">eAlbum Access</h2>
            <p class="text-gray-500 mb-10 font-medium">Please enter your unique access code</p>
            <div class="space-y-5">
                <input id="unique_code" type="text"
                    class="w-full px-8 py-5 bg-gray-50 border-2 border-gray-100 rounded-2xl text-center text-xl font-bold tracking-widest outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all uppercase">
                <button onclick="unlockAlbum()" id="unlockBtn"
                    class="w-full py-5 bg-indigo-600 text-white font-bold rounded-2xl text-xl hover:bg-indigo-700 active:scale-[0.98] transition-all shadow-xl shadow-indigo-200 flex items-center justify-center gap-3">
                    <span>Unlock Album</span>
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </div>
        </div>
    </div>

    <div id="loader" class="fixed inset-0 bg-black/95 z-[60] flex flex-col items-center justify-center text-white">
        <div class="spinner mb-6"></div>
        <p class="font-black tracking-[0.3em] uppercase text-xs text-indigo-400 animate-pulse">Loading Your Memories</p>
    </div>

    <div id="viewer-container" class="hidden flex-1 flex flex-col relative w-full h-full">
        
        <div class="w-full px-8 py-4 flex justify-between items-center bg-black/40 backdrop-blur-md border-b border-white/5 z-50">
            <div class="flex items-center gap-4">
                <h1 id="display-studio-name" class="text-white font-bold tracking-widest uppercase text-[10px] opacity-60">STUDIO NAME</h1>
            </div>
            
            <div class="absolute left-1/2 -translate-x-1/2 text-center">
                <h1 id="display-album-name" class="text-white font-black tracking-tighter text-lg uppercase">ALBUM NAME</h1>
            </div>

            <div class="flex items-center gap-5 text-white">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase flex items-center gap-2 transition-all">
                    <i class="fa-solid fa-video"></i> Create Video
                </button>
                <i class="fa-solid fa-share-nodes cursor-pointer opacity-60 hover:opacity-100 transition-opacity"></i>
                <i class="fa-solid fa-circle-info cursor-pointer opacity-60 hover:opacity-100 transition-opacity"></i>
            </div>
        </div>

        <div class="flex-1 flex flex-col items-center justify-center relative">
            <div id="flipbook-wrapper">
                <div id="flipbook"></div>
            </div>
        </div>

        <div class="fixed bottom-10 right-10 z-50">
            <button id="musicToggle" class="bg-white/5 backdrop-blur-xl border border-white/10 text-white w-16 h-16 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all shadow-2xl">
                <i id="musicIcon" class="fa-solid fa-music text-xl fa-bounce"></i>
            </button>
            <audio id="bgMusic" loop></audio>
        </div>

        <div class="fixed bottom-10 left-1/2 -translate-x-1/2 flex items-center gap-12">
            <button onclick="$('#flipbook').turn('previous')" class="group flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center group-hover:bg-white group-hover:text-black transition-all">
                    <i class="fa-solid fa-chevron-left text-white group-hover:text-black"></i>
                </div>
                <span class="text-[9px] text-white/30 uppercase font-bold tracking-widest text-white">Prev</span>
            </button>

            <div class="flex flex-col items-center gap-2">
                <button id="albumAutoPlay" class="w-12 h-12 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-all">
                    <i id="playIcon" class="fa-solid fa-play"></i>
                </button>
                <div class="px-6 py-2 rounded-full bg-white/5 border border-white/5 text-white/50 text-[10px] font-mono tracking-tighter">
                    PAGE <span id="page-number" class="text-indigo-400">1</span>
                </div>
            </div>

            <button onclick="$('#flipbook').turn('next')" class="group flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-full border border-white/10 flex items-center justify-center group-hover:bg-white group-hover:text-black transition-all">
                    <i class="fa-solid fa-chevron-right text-white group-hover:text-black"></i>
                </div>
                <span class="text-[9px] text-white/30 uppercase font-bold tracking-widest text-white">Next</span>
            </button>
        </div>
    </div>

    <script>
        let isAutoPlaying = false;
        let playInterval;

        function unlockAlbum() {
            const code = $('#unique_code').val().trim();
            if (!code) return alert("❌ Please enter your access code.");
            $('#loader').css('display', 'flex');

            $.ajax({
                url: "{{ route('album.fetch') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", access_code: code },
                success: function (res) {
                    if (res.success) {
                        const data = res.data;
                        $('#display-album-name').text(data.album_name);
                        $('#display-studio-name').text(data.studio_name || "OFFICIAL STUDIO");

                        if (data.music) {
                            const audio = document.getElementById('bgMusic');
                            audio.src = data.music;
                            audio.play().catch(e => console.log("Music waiting for interaction"));
                        }

                        const flipbook = $('#flipbook');
                        flipbook.empty();
                        flipbook.append(`<div class="page hard shadow-2xl"><img src="${data.cover}"></div>`);
                        data.images.forEach(img => {
                            flipbook.append(`<div class="page shadow-md"><img src="${img}"></div>`);
                        });
                        flipbook.append(`<div class="page hard shadow-2xl flex items-center justify-center bg-[#1a1a1a]"><p class="text-white/20 uppercase tracking-[1em] font-bold -rotate-90">The End</p></div>`);

                        setTimeout(() => {
                            $('#access-modal').fadeOut(400);
                            $('#loader').fadeOut(600);
                            $('#viewer-container').removeClass('hidden');

                            flipbook.show().turn({
                                width: 1000, height: 600, autoCenter: true, elevation: 50, duration: 1200,
                                when: { turning: function (e, page) { $('#page-number').text(page); } }
                            });
                        }, 1000);
                    } else {
                        alert("⚠️ " + res.message);
                        $('#loader').hide();
                    }
                },
                error: function () {
                    alert("❌ Server Error.");
                    $('#loader').hide();
                }
            });
        }

        $('#albumAutoPlay').click(function() {
            const icon = $('#playIcon');
            if (!isAutoPlaying) {
                isAutoPlaying = true;
                icon.removeClass('fa-play').addClass('fa-pause');
                playInterval = setInterval(() => {
                    if ($('#flipbook').turn('page') == $('#flipbook').turn('pages')) {
                        $('#flipbook').turn('page', 1);
                    } else {
                        $('#flipbook').turn('next');
                    }
                }, 4000);
            } else {
                isAutoPlaying = false;
                icon.removeClass('fa-pause').addClass('fa-play');
                clearInterval(playInterval);
            }
        });

        $('#musicToggle').click(function () {
            const audio = document.getElementById('bgMusic');
            if (audio.paused) {
                audio.play();
                $('#musicIcon').addClass('fa-bounce text-indigo-400');
            } else {
                audio.pause();
                $('#musicIcon').removeClass('fa-bounce text-indigo-400');
            }
        });

        function closeModal() { window.location.href = "{{ route('user.pages.welcome') }}"; }
        $(document).keyup(function (e) { if (e.key === "Escape") closeModal(); });
    </script>
</body>
</html>