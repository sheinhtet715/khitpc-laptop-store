@extends('user.layouts.master')

@section('content')
<style>
    .about-hero {
        background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%; /* Ratio 16:9 */
        height: 0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(30, 58, 95, 0.15);
        border: 1px solid rgba(212, 163, 115, 0.3);
    }
    .video-wrapper iframe, .video-wrapper video {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover;
    }
    .play-btn-overlay {
        position: absolute; inset: 0;
        background: rgba(15, 23, 42, 0.4);
        display: flex; justify-content: center; align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .play-btn-overlay:hover { 
		background: rgba(15, 23, 42, 0.2); 
	}
    .play-btn-overlay i {
        font-size: 5rem;
        color: #FFBF00;
        filter: drop-shadow(0 4px 10px rgba(0,0,0,0.5));
        transition: transform 0.3s ease;
    }
    .play-btn-overlay:hover i { transform: scale(1.1); }
</style>

<div class="mx-3 mt-4 mb-5 text-center text-white border-2 shadow-sm about-hero rounded-4 border-bottom border-danger">
    <div class="pointer-events-none" style="position: absolute; top: -50%; left: -10%; width: 400px; height: 400px; background: rgba(212, 163, 115, 0.1); filter: blur(80px); border-radius: 50%; z-index: 0;"></div>

    <div class="container position-relative z-1">
        <h5 class="mb-3 tracking-wider text-danger fw-bold gsap-fade-up">_OUR STORY_</h5>
        <h1 class="mb-4 display-3 fw-bold gsap-fade-up" style="letter-spacing: -1px;">Redefining the<br>Tech Experience.</h1>
        <p class="mx-auto opacity-75 lead gsap-fade-up" style="max-width: 700px;">KhitPC is an online retail platform designed to modernize how people shop for computers in Myanmar. The core mission of the project goes beyond simply selling laptops; it aims to build a reliable and accessible ecosystem for students, professionals, and creators who depend on quality technology. By offering a central, streamlined website, the platform successfully replaces disorganized social media marketplaces with a transparent, direct catalog.</p>
    </div>
</div>

<div class="container my-5">
    <div class="pb-5 mb-5 row align-items-center">
         <div class="mb-4 col-md-6 mb-md-0 gsap-fade-up">
            <div class="position-relative">
                <div style="position: absolute; top: -15px; left: -15px; width: 100px; height: 100px; border-top: 4px solid #D32F2F; border-left: 4px solid #D32F2F; z-index: 0;"></div>
                <img src="{{ asset('user/lapimage/camera-photography-design-studio-editing-concept.jpg') }}" alt="Our Mission" class="shadow-sm img-fluid rounded-4 position-relative z-1" style="border: 1px solid rgba(30, 58, 95, 0.1);">
                <div style="position: absolute; bottom: -15px; right: -15px; width: 100px; height: 100px; border-bottom: 4px solid #FFBF00; border-right: 4px solid #FFBF00; z-index: 0;"></div>
            </div>
        </div>
        <div class="col-md-5 offset-md-1 gsap-fade-up">
            <h2 class="mb-4 fw-bold" style="color: #1F2937;">Built by an Enthusiast,<br>For Enthusiasts.</h2>
            <p style="color: #6c757d; font-size: 1.1rem; line-height: 1.8;">The concepts driving KhitPC were born directly out of the practical challenges of finding reliable computer hardware locally. For many buyers, navigating unverified sellers and confusing specifications makes purchasing a computer highly stressful. KhitPC bridges this gap by acting as a curated, quality-focused store. Every laptop featured on the site is carefully categorized with exact details and authentic customer feedback, ensuring complete transparency and peace of mind for the consumer.</p>
            <p style="color: #6c757d; font-size: 1.1rem; line-height: 1.8;">Every machine we curate undergoes rigorous quality checks. We don't just move boxes; we ensure that when you power on your rig, it performs flawlessly.</p>
        </div>
    </div>

    <div class="pb-5 mb-5 row gsap-fade-up">
        <div class="mb-4 text-center col-12">
            <h2 class="fw-bold" style="color: #1F2937;">See Us In Action</h2>
            <p class="text-muted">A glimpse inside the Khit PC standard.</p>
        </div>
        <div class="col-12">
            <div class="shadow-sm video-wrapper bg-dark">
				<iframe width="634" height="634" src="https://www.youtube.com/embed/N_yf15jj6_s" title="KhitPC" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class="pb-5 mb-5 text-center row g-4">
        <div class="col-12 col-md-4 gsap-fade-up">
            <div class="p-5 bg-white border shadow-sm rounded-4 h-100" style="border-color: rgba(30, 58, 95, 0.05) !important;">
                <i class="mb-4 fa-solid fa-microchip" style="font-size: 3rem; color: #D32F2F;"></i>
                <h4 class="mb-3 fw-bold" style="color: #1F2937;">Cutting-Edge Only</h4>
                <p class="mb-0 text-muted">We stock the latest generations of processors and GPUs the moment they drop.</p>
            </div>
        </div>
   <div class="col-12 col-md-4 gsap-fade-up">
            <div class="p-5 shadow-sm rounded-4 h-100 position-relative" style="background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%); border: 1px solid rgba(212, 163, 115, 0.2);">
                <i class="mb-4 fa-solid fa-headset" style="font-size: 3rem; color: #FFBF00;"></i>
                <h4 class="mb-3 text-white fw-bold">Lifetime Support</h4>
                <p class="mb-0 text-white opacity-75">Our relationship doesn't end at checkout. Our tech experts are here for you forever.</p>
            </div>
        </div>
        <div class="col-12 col-md-4 gsap-fade-up">
            <div class="p-5 bg-white border shadow-sm rounded-4 h-100" style="border-color: rgba(30, 58, 95, 0.05) !important;">
                <i class="mb-4 fa-solid fa-handshake" style="font-size: 3rem; color: #D32F2F;"></i>
                <h4 class="mb-3 fw-bold" style="color: #1F2937;">Curated and Trustworthy</h4>
                <p class="mb-0 text-muted">A central, dependable store designed to remove unverified listings and provide a smooth shopping experience for everyone.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        gsap.registerPlugin(ScrollTrigger);
        gsap.from(".gsap-fade-up", {
            scrollTrigger: { trigger: ".gsap-fade-up", start: "top 85%" },
            y: 40, opacity: 0, duration: 0.8, stagger: 0.15, ease: "power2.out", clearProps: "all"
        });
    });
</script>
@endsection
