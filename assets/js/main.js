/* =====================================================
   PR FICT Main JS - Interactions & Validation
   ===================================================== */
document.addEventListener('DOMContentLoaded', function() {

    // Navbar Scroll & Hamburger
    const navbar = document.querySelector('.navbar');
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.navbar-nav');

    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu on link click
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const item = this.parentElement;
            const answer = item.querySelector('.faq-answer');
            const isActive = item.classList.contains('active');

            // Close all items
            document.querySelectorAll('.faq-item').forEach(i => {
                i.classList.remove('active');
                const a = i.querySelector('.faq-answer');
                if (a) a.style.maxHeight = null;
            });

            // Open clicked item if it wasn't active
            if (!isActive && answer) {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    // Multi-Step Registration Form Logic
    const regForm = document.getElementById('registrationForm');
    if (regForm) {
        const steps = regForm.querySelectorAll('.form-step');
        const progressSteps = document.querySelectorAll('.progress-step');
        const nextBtns = regForm.querySelectorAll('.btn-next');
        const prevBtns = regForm.querySelectorAll('.btn-prev');
        const submitBtn = document.getElementById('submitRegBtn');
        const confirmModal = document.getElementById('confirmModal');
        const modalConfirmSubmit = document.getElementById('modalConfirmSubmit');
        const modalCancelSubmit = document.getElementById('modalCancelSubmit');

        let currentStep = 0;

        function showStep(stepIndex) {
            steps.forEach((step, idx) => {
                step.classList.toggle('active', idx === stepIndex);
            });

            progressSteps.forEach((pStep, idx) => {
                pStep.classList.remove('active', 'completed');
                if (idx < stepIndex) {
                    pStep.classList.add('completed');
                } else if (idx === stepIndex) {
                    pStep.classList.add('active');
                }
            });
        }

        nextBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    currentStep++;
                    showStep(currentStep);
                }
            });
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                currentStep--;
                showStep(currentStep);
            });
        });

        if (submitBtn) {
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (validateStep(currentStep)) {
                    if (confirmModal) {
                        confirmModal.classList.add('active');
                    } else {
                        regForm.submit();
                    }
                }
            });
        }

        if (modalConfirmSubmit) {
            modalConfirmSubmit.addEventListener('click', function() {
                regForm.submit();
            });
        }

        if (modalCancelSubmit) {
            modalCancelSubmit.addEventListener('click', function() {
                confirmModal.classList.remove('active');
            });
        }

        function validateStep(stepIndex) {
            const currentStepEl = steps[stepIndex];
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                const errorEl = input.parentElement.querySelector('.form-error');
                if (errorEl) errorEl.textContent = '';

                if (!input.value.trim()) {
                    isValid = false;
                    showError(input, 'Field ini wajib diisi.');
                } else if (input.type === 'email' && !validateEmail(input.value)) {
                    isValid = false;
                    showError(input, 'Format email tidak valid.');
                } else if (input.name === 'email' && !input.value.endsWith('@horizon.ac.id') && !input.value.endsWith('@student.horizon.ac.id')) {
                    isValid = false;
                    showError(input, 'Gunakan email kampus Horizon (@horizon.ac.id).');
                } else if (input.name === 'whatsapp' && (input.value.length < 10 || input.value.length > 15)) {
                    isValid = false;
                    showError(input, 'Nomor WhatsApp tidak valid (10-15 digit).');
                } else if (input.type === 'checkbox' && !input.checked) {
                    isValid = false;
                    showError(input, 'Anda harus menyetujui pernyataan ini.');
                }
            });

            return isValid;
        }

        function showError(input, message) {
            let errorEl = input.parentElement.querySelector('.form-error');
            if (!errorEl) {
                errorEl = document.createElement('div');
                errorEl.className = 'form-error';
                input.parentElement.appendChild(errorEl);
            }
            errorEl.textContent = message;
        }

        function validateEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        }
    }

    // File Input Name Display
    const fileInputs = document.querySelectorAll('.file-upload input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileNameDisplay = this.parentElement.querySelector('.file-name');
            if (fileNameDisplay) {
                fileNameDisplay.textContent = this.files[0] ? this.files[0].name : '';
            }
        });
    });

    // Intersection Observer for scroll animations
    const animatedElements = document.querySelectorAll('.org-animate');
    if ('IntersectionObserver' in window && animatedElements.length > 0) {
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    
                    const animateType = entry.target.getAttribute('data-animate');
                    if (animateType === 'fade-up') {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    } else if (animateType === 'fade-in') {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'scale(1)';
                    }
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(el => {
            // Apply inline transition and initial states if needed
            el.style.opacity = '0';
            const animateType = el.getAttribute('data-animate');
            if (animateType === 'fade-up') {
                el.style.transform = 'translateY(30px)';
            } else if (animateType === 'fade-in') {
                el.style.transform = 'scale(0.95)';
            }
            observer.observe(el);
        });
    } else {
        animatedElements.forEach(el => {
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
    }
});

// Organization Member Detail Modal (Global Functions)
window.openOrgModal = function(cardEl) {
    const dataEl = cardEl.querySelector('.org-card-data');
    if (!dataEl) return;

    const name = dataEl.getAttribute('data-name');
    const position = dataEl.getAttribute('data-position');
    const division = dataEl.getAttribute('data-division');
    const motto = dataEl.getAttribute('data-motto');
    const description = dataEl.getAttribute('data-description');
    const instagram = dataEl.getAttribute('data-instagram');
    const linkedin = dataEl.getAttribute('data-linkedin');
    const photo = dataEl.getAttribute('data-photo');
    const initials = dataEl.getAttribute('data-initials');

    const overlay = document.getElementById('orgModalOverlay');
    const nameEl = document.getElementById('orgModalName');
    const posEl = document.getElementById('orgModalPosition');
    const photoEl = document.getElementById('orgModalPhoto');
    const mottoEl = document.getElementById('orgModalMotto');
    const mottoTextEl = document.getElementById('orgModalMottoText');
    const descEl = document.getElementById('orgModalDescription');
    const socialsEl = document.getElementById('orgModalSocials');

    if (nameEl) nameEl.textContent = name;
    if (posEl) posEl.textContent = position + " • " + division;
    if (descEl) descEl.textContent = description || "Tidak ada deskripsi profil untuk anggota ini.";

    if (photoEl) {
        if (photo) {
            photoEl.innerHTML = `<img src="${photo}" alt="Foto ${name} ${position} Program Representative FICT">`;
        } else {
            photoEl.innerHTML = `<div class="org-avatar">${initials}</div>`;
        }
    }

    if (mottoEl && mottoTextEl) {
        if (motto) {
            mottoTextEl.textContent = motto;
            mottoEl.style.display = 'block';
        } else {
            mottoEl.style.display = 'none';
        }
    }

    if (socialsEl) {
        socialsEl.innerHTML = '';
        if (instagram) {
            socialsEl.innerHTML += `<a href="https://instagram.com/${instagram.replace('@', '')}" target="_blank" rel="noopener noreferrer" title="Instagram @${instagram.replace('@', '')}"><i class="fab fa-instagram"></i></a>`;
        }
        if (linkedin) {
            const linkedinUrl = linkedin.startsWith('http') ? linkedin : `https://linkedin.com/in/${linkedin}`;
            socialsEl.innerHTML += `<a href="${linkedinUrl}" target="_blank" rel="noopener noreferrer" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>`;
        }
    }

    if (overlay) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
};

window.closeOrgModal = function() {
    const overlay = document.getElementById('orgModalOverlay');
    if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
};

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.closeOrgModal();
    }
});

