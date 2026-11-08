@extends('user.layouts.master')

@section('content')
<style>
    .contact-form-control {
        background-color: #f8fafc;
        border: 1px solid rgba(30, 58, 95, 0.1);
        padding: 15px 20px;
        border-radius: 8px;
        color: #1F2937;
        transition: all 0.3s ease;
    }
    .contact-form-control:focus {
        background-color: #ffffff;
        border-color: #D32F2F;
        box-shadow: 0 0 0 0.25rem rgba(211, 47, 47, 0.1);
        outline: none;
    }
    .contact-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid rgba(30, 58, 95, 0.05);
        box-shadow: 0 15px 35px rgba(30, 58, 95, 0.05);
    }
    .map-container {
        height: 400px;
        width: 100%;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(30, 58, 95, 0.1);
    }
</style>

<div class="container pt-4 my-5">

    <div class="mb-5 text-center gsap-fade-up">
        <h5 class="mb-2 tracking-wider text-danger fw-bold">_GET IN TOUCH_</h5>
        <h1 class="display-4 fw-bold" style="color: #1F2937; letter-spacing: -1px;">We're Here to Help.</h1>
        <p class="mx-auto lead text-muted" style="max-width: 600px;">Have a question about a build? Need technical support? Drop us a message and our experts will get back to you immediately.</p>
    </div>

    <div class="mb-5 row g-5">
        <div class="col-lg-5 gsap-fade-up">
            <div class="p-5 contact-card h-100" style="background: linear-gradient(135deg, #1E3A5F 0%, #112540 100%);">
                <h3 class="mb-4 text-white fw-bold">Contact Information</h3>
                <p class="mb-5 text-white opacity-75">Fill out the form and our team will try to get back to you within 24 hours.</p>

                <div class="mb-4 d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px; background: rgba(212, 163, 115, 0.1);">
                        <i class="fa-solid fa-phone fs-4" style="color: #FFBF00;"></i>
                    </div>
                    <div class="ms-4">
                        <h6 class="mb-1 text-white opacity-75">Call Us</h6>
                        <h5 class="mb-0 text-white fw-bold">+95 9 123 456 789</h5>
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px; background: rgba(211, 47, 47, 0.1);">
                        <i class="fa-solid fa-envelope fs-4" style="color: #D32F2F;"></i>
                    </div>
                    <div class="ms-4">
                        <h6 class="mb-1 text-white opacity-75">Email Us</h6>
                        <h5 class="mb-0 text-white fw-bold">info@khitpc.com</h5>
                    </div>
                </div>

                <div class="mb-5 d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle" style="width: 50px; height: 50px; background: rgba(255, 255, 255, 0.05);">
                        <i class="text-white fa-solid fa-location-dot fs-4"></i>
                    </div>
                    <div class="ms-4">
                        <h6 class="mb-1 text-white opacity-75">Visit Us</h6>
                        <h5 class="mb-0 text-white fw-bold">No. X Main St, Yangon</h5>
                    </div>
                </div>

                <hr class="mb-4 opacity-25 border-light">

                <h6 class="mb-3 text-white fw-bold">Follow our socials</h6>
                <div class="gap-3 d-flex">
                    <a href="https://www.facebook.com/profile.php?id=61590207278065" target="_blank"  class="btn btn-outline-light rounded-circle d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://youtube.com/@khitpc2?si=NjHIdiGS0V1LTsdj" target="_blank"  class="btn btn-outline-light rounded-circle d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-youtube"></i></a>
                    <a href="https://t.me/khitpc" target="_blank" class="btn btn-outline-light rounded-circle d-flex justify-content-center align-items-center" style="width: 45px; height: 45px;"><i class="fa-brands fa-telegram"></i></a>
                </div>
            </div>
        </div>

        <div class="col-lg-7 gsap-fade-up" style="animation-delay: 0.2s;">
            <div class="p-5 contact-card h-100">
                <h3 class="mb-4 fw-bold" style="color: #1F2937;">Send a Message</h3>

               <form id="contactForm" action="https://formspree.io/f/meepaapa" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="uppercase form-label fw-bold text-muted small">FIRST NAME</label>
                            <input type="text" name="first_name" class="form-control contact-form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="uppercase form-label fw-bold text-muted small">LAST NAME</label>
                            <input type="text" name="last_name" class="form-control contact-form-control" placeholder="Last Name" required>
                        </div>
                        <div class="col-12">
                            <label class="uppercase form-label fw-bold text-muted small">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control contact-form-control" placeholder="example@gmail.com" required>
                        </div>
                        <div class="col-12">
                            <label class="uppercase form-label fw-bold text-muted small">SUBJECT</label>
                            <select name="subject" class="form-select contact-form-control">
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Sales & Builds">Sales & Builds</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="uppercase form-label fw-bold text-muted small">MESSAGE</label>
                            <textarea name="message" class="form-control contact-form-control" rows="5" placeholder="How can we help you?" required></textarea>
                        </div>
                        <div class="mt-4 col-12">
                            <button type="submit" id="submitBtn" class="py-3 text-white btn w-100 rounded-pill fw-bold" style="background: linear-gradient(135deg, #D32F2F 0%, #B02323 100%); border: none; box-shadow: 0 6px 15px rgba(211, 47, 47, 0.3);">
                                <span id="btnText">Send Message</span> <i id="btnIcon" class="fa-solid fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row gsap-fade-up">
        <div class="col-12">
            <div class="p-1 bg-white shadow-sm map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d122201.76175984606!2d96.06915152912444!3d16.85239566378419!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1949e223e196b%3A0x56fbd271f8080bb4!2sYangon%2C%20Myanmar%20(Burma)!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus"
                        width="100%" height="100%" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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


    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        var form = this;
        var btn = document.getElementById('submitBtn');
        var btnText = document.getElementById('btnText');
        var btnIcon = document.getElementById('btnIcon');

      
        btn.disabled = true;
        btnText.innerHTML = 'Sending...';
        btnIcon.className = 'fa-solid fa-circle-notch fa-spin ms-2';

      
        fetch(form.action, {
            method: form.method,
            body: new FormData(form),
            headers: {
                'Accept': 'application/json' 
            }
        }).then(response => {
            if (response.ok) {
                
                Swal.fire({
                    title: 'Message Sent!',
                    text: 'Our technical experts will get back to you shortly.',
                    icon: 'success',
                    confirmButtonColor: '#D32F2F', 
                    customClass: {
                        popup: 'rounded-4'
                    }
                });
                form.reset(); 
            } else {
              
                response.json().then(data => {
                    if (Object.hasOwn(data, 'errors')) {
                        Swal.fire('Oops...', data["errors"].map(error => error["message"]).join(", "), 'error');
                    } else {
                        Swal.fire('Oops...', 'There was a problem submitting your form.', 'error');
                    }
                });
            }
        }).catch(error => {
            Swal.fire('Oops...', 'Network error. Please try again.', 'error');
        }).finally(() => {
         
            btn.disabled = false;
            btnText.innerHTML = 'Send Message';
            btnIcon.className = 'fa-solid fa-paper-plane ms-2';
        });
    });
</script>
@endsection
