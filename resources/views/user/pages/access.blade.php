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
        body {
            background-color: #050505;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            color: white;
        }

        #flipbook-wrapper {
            perspective: 2000px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 82vh;
            width: 100%;
            position: relative;
            /* Required for absolute centering of cover */
        }

        /* 🟢 Default Sizing (Double Width for 2 pages) */
        #flipbook {
            width: 1200px;
            height: 420px;
            display: none;
            box-shadow: 0 0 100px rgba(0, 0, 0, 0.8);
            margin: 0 auto;
            transition: all 0.5s ease-in-out;
        }

        /* 🟢 Single Page Sizing */
        #flipbook .page {
            width: 600px !important;
            height: 420px !important;
        }

        /* 🟢 Image Fitting Logic (object-fit: contain) */
        #flipbook img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* 👈 Correction: contain se image kategi nahi, poori dikhegi */
            object-position: center;
            pointer-events: none;
            background-color: #000;
        }

        /* 🟢 Logic to center Cover Photo (px py center) */
        #flipbook.cover-centered {
            position: absolute !important;
            width: 600px !important;

            left: 50% !important;
            top: 46% !important;

            transform: translate(-50%, -50%) !important;

            box-shadow: 0 0 150px rgba(99, 102, 241, 0.3) !important;
        }

        #thumbnail-strip {
            display: none;
            position: fixed;
            bottom: 85px;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.9);
            padding: 15px;
            overflow-x: auto;
            white-space: nowrap;
            z-index: 100;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .thumb-img {
            width: 100px;
            height: 65px;
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
            opacity: 0.5;
            transition: 0.3s;
            object-fit: cover;
            border-radius: 4px;
        }

        .thumb-img:hover,
        .thumb-img.active {
            opacity: 1;
            border: 2px solid #6366f1;
            transform: scale(1.05);
        }

        #loader {
            display: none;
            backdrop-blur: 10px;
        }

        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.1);
            border-top: 4px solid #6366f1;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #unique_code {
            color: #000000 !important;
            font-weight: 700;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <div id="access-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50 backdrop-blur-sm">
        <div
            class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 text-center border-t-8 border-indigo-600 relative">
            <button onclick="closeModal()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500"><i
                    class="fa-solid fa-circle-xmark text-2xl"></i></button>
            <div class="flex justify-center mb-8">
                <div class="p-5 bg-indigo-50 rounded-3xl"><i class="fa-solid fa-lock-open text-4xl text-indigo-600"></i>
                </div>
            </div>
            <h2 class="text-3xl font-black text-gray-800 mb-2 tracking-tight">eAlbum Access</h2>
            <p class="text-gray-500 mb-10 font-medium">Please enter your unique access code</p>
            <div class="space-y-5">
                <input id="unique_code" type="text" placeholder="Enter Your Access Code here"
                    class="w-full px-8 py-5 bg-gray-50 border-2 border-gray-100 rounded-2xl text-center text-xl tracking-widest outline-none focus:border-indigo-400 uppercase">
                <button onclick="unlockAlbum()" id="unlockBtn"
                    class="w-full py-5 bg-indigo-600 text-white font-bold rounded-2xl text-xl hover:bg-indigo-700 shadow-xl flex items-center justify-center gap-3 transition-all">
                    <span>Unlock Album</span><i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="loader" class="fixed inset-0 bg-black/95 z-[60] flex flex-col items-center justify-center text-white">
        <div class="spinner mb-6"></div>
        <p class="font-black tracking-[0.3em] uppercase text-xs text-indigo-400 animate-pulse">Loading Your Memories</p>
    </div>

    <div id="viewer-container" class="hidden flex-1 flex flex-col relative w-full h-full">
        <div
            class="w-full px-8 py-4 flex justify-between items-center bg-black/40 backdrop-blur-md border-b border-white/5 z-50">
            <h1 id="display-studio-name" class="text-white font-bold tracking-widest uppercase text-[10px] opacity-60">
                STUDIO NAME</h1>
            <div class="absolute left-1/2 -translate-x-1/2 text-center">
                <h1 id="display-album-name" class="text-white font-black tracking-tighter text-lg uppercase">ALBUM NAME
                </h1>
            </div>
            <div class="flex items-center gap-5 text-white">
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase flex items-center gap-2 transition-all shadow-lg shadow-indigo-500/20"><i
                        class="fa-solid fa-video"></i> Create Video</button>
                <i onclick="shareAlbum()"
                    class="fa-solid fa-share-nodes cursor-pointer opacity-60 hover:opacity-100 transition-all text-lg"></i>
                <i
                    class="fa-solid fa-circle-info cursor-pointer opacity-60 hover:opacity-100 transition-all text-lg"></i>
            </div>
        </div>

        <div class="flex-1 flex flex-col items-center justify-center relative">
            <div id="flipbook-wrapper">
                <div id="flipbook"></div>
            </div>
        </div>

        <div id="thumbnail-strip" class="custom-scrollbar shadow-2xl"></div>
        <div class="fixed bottom-10 right-10 z-50 flex items-center gap-4">
            <button id="musicToggle"
                class="bg-white/5 border border-white/10 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-indigo-600 shadow-2xl transition-all"><i
                    id="musicIcon" class="fa-solid fa-music text-lg fa-bounce"></i></button>
            <button onclick="toggleFullScreen()"
                class="bg-white/5 border border-white/10 text-white w-12 h-12 rounded-full flex items-center justify-center hover:bg-indigo-600 transition-all shadow-2xl"><i
                    class="fa-solid fa-expand"></i></button>
            <audio id="bgMusic" loop></audio>
        </div>
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-3">
            <div class="flex items-center gap-12">
                <button onclick="$('#flipbook').turn('previous')"
                    class="text-white opacity-40 hover:opacity-100 transition-all scale-125"><i
                        class="fa-solid fa-chevron-left text-2xl"></i></button>
                <div class="flex flex-col items-center gap-2">
                    <div class="flex gap-4 items-center">
                        <i onclick="toggleThumbnails()"
                            class="fa-solid fa-table-cells-large text-xl opacity-40 hover:opacity-100 cursor-pointer transition-all"></i>
                        <button id="albumAutoPlay"
                            class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/40"><i
                                id="playIcon" class="fa-solid fa-play text-sm"></i></button>
                    </div>
                    <span class="text-white/50 text-[10px] font-mono tracking-tighter uppercase">Page <span
                            id="page-number" class="text-indigo-400">1</span></span>
                </div>
                <button onclick="$('#flipbook').turn('next')"
                    class="text-white opacity-40 hover:opacity-100 transition-all scale-125"><i
                        class="fa-solid fa-chevron-right text-2xl"></i></button>
            </div>
        </div>
    </div>

    <script>
        // Core functions unchanged...
        let isAutoPlaying = false;
        let playInterval;

        $(document).ready(function () {
            // 🟢 URL DETECTION LOGIC (Correction)
            const pathSegments = window.location.pathname.split('/');
            const urlCode = pathSegments[pathSegments.length - 1];

            // Check if code exists in URL and is not the word 'access'
            if (urlCode && urlCode.length >= 5 && urlCode !== 'access') {
                $('#unique_code').val(urlCode);
                unlockAlbum(); // URL wali ID se auto unlock
            } else {
                $('#access-modal').show(); // Normal case me modal dikhao
            }
        });

        async function shareAlbum() {
            const shareData = {
                title: document.title,
                text: 'Experience these memories in our eAlbum: ' + $('#display-album-name').text(),
                url: window.location.href
            };
            try {
                if (navigator.share) {
                    await navigator.share(shareData);
                } else {
                    navigator.clipboard.writeText(shareData.url);
                    alert("🔗 Link copied to clipboard!");
                }
            } catch (err) { console.log('Error sharing:', err); }
        }

        function unlockAlbum() {
            const code = $('#unique_code').val().trim();
            if (!code) return alert("❌ Code required");
            $('#loader').css('display', 'flex');

            $.ajax({
                url: "{{ route('album.fetch') }}",
                method: "POST",
                data: { _token: "{{ csrf_token() }}", access_code: code },
                success: function (res) {
                    if (res.success) {
                        const data = res.data;
                        const newUrl = window.location.origin + '/' + code;
                        window.history.pushState({ path: newUrl }, '', newUrl);
                        document.title = data.album_name + " | eAlbum";

                        $('#display-album-name').text(data.album_name);
                        $('#display-studio-name').text(data.studio_name);

                        if (data.music) { $('#bgMusic').attr('src', data.music); document.getElementById('bgMusic').play().catch(e => { }); }

                        const flipbook = $('#flipbook');
                        const thumbStrip = $('#thumbnail-strip');
                        flipbook.empty(); thumbStrip.empty();

                        /* 🟢 Apply centering class initially for the cover */
                        flipbook.addClass('cover-centered');

                        /* Cover Page centered fit */
                        flipbook.append(`<div class="page hard shadow-2xl"><img src="${data.cover}"></div>`);
                        thumbStrip.append(`<img src="${data.cover}" onclick="$('#flipbook').turn('page', 1)" class="thumb-img active">`);

                        /* Fetched images big view, will be handled by object-fit: cover */
                        data.images.forEach((img, index) => {
                            flipbook.append(`<div class="page shadow-md"><img src="${img}"></div>`);
                            thumbStrip.append(`<img src="${img}" onclick="$('#flipbook').turn('page', ${index + 2})" class="thumb-img">`);
                        });

                        flipbook.append(`<div class="page hard shadow-2xl flex items-center justify-center bg-[#111]"><p class="text-white/20 uppercase tracking-[1em] font-bold -rotate-90">The End</p></div>`);

                        setTimeout(() => {
                            $('#access-modal').fadeOut(400);
                            $('#loader').fadeOut(600);
                            $('#viewer-container').removeClass('hidden');

                            /* 🟢 Correction: Added autoCenter and proper duration */
                            flipbook.show().turn({
                                width: 1200, 
                                height: 420,
                                autoCenter: true, 
                                elevation: 200,
                                duration: 1500,
                                gradients: true,
                                acceleration: true,
                                when: {
                                    turning: function (e, page) {
                                        $('#page-number').text(page);
                                        $('.thumb-img').removeClass('active').eq(page - 1).addClass('active');

                                        // 🟢 Centering logic: Page 1 is centered, others are spread
                                        if (page === 1) {
                                            $('#flipbook').addClass('cover-centered');
                                        } else {
                                            $('#flipbook').removeClass('cover-centered');
                                        }
                                    }
                                }
                            });
                        }, 1000);
                    } else { alert(res.message); $('#loader').hide(); }
                }
            });
        }

        function toggleThumbnails() { $('#thumbnail-strip').fadeToggle(); }
        function toggleFullScreen() {
            if (!document.fullscreenElement) { document.documentElement.requestFullscreen(); }
            else { if (document.exitFullscreen) { document.exitFullscreen(); } }
        }

        $('#albumAutoPlay').click(function () {
            const icon = $('#playIcon');
            if (!isAutoPlaying) {
                isAutoPlaying = true;
                icon.removeClass('fa-play').addClass('fa-pause');
                playInterval = setInterval(() => {
                    if ($('#flipbook').turn('page') == $('#flipbook').turn('pages')) { $('#flipbook').turn('page', 1); }
                    else { $('#flipbook').turn('next'); }
                }, 4500);
            } else { isAutoPlaying = false; icon.removeClass('fa-pause').addClass('fa-play'); clearInterval(playInterval); }
        });

        $('#musicToggle').click(function () {
            const audio = document.getElementById('bgMusic');
            if (audio.paused) { audio.play(); $('#musicIcon').addClass('fa-bounce text-indigo-400'); }
            else { audio.pause(); $('#musicIcon').removeClass('fa-bounce text-indigo-400'); }
        });

        function closeModal() { window.location.href = "{{ route('user.pages.welcome') }}"; }
    </script>
</body>

</html>