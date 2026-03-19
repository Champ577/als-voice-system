/* =========================================================
   TOASTER SYSTEM
   ========================================================= */
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    const icon =
        type === 'success'
            ? '<i class="fas fa-check-circle"></i>'
            : '<i class="fas fa-exclamation-circle"></i>';

    toast.className = `toast ${type}`;
    toast.innerHTML = `${icon} <span>${message}</span>`;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        toast.addEventListener('animationend', () => toast.remove());
    }, 3000);
}

/* =========================================================
   VALIDATION HELPERS
   ========================================================= */
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorText = document.getElementById('error_' + fieldId);

    if (!field || !errorText) return false;

    field.classList.add('error');
    errorText.textContent = message;
    errorText.classList.add('show');

    if (document.activeElement !== field) {
        field.focus();
    }
    return false;
}

function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorText = document.getElementById('error_' + fieldId);

    field?.classList.remove('error');
    errorText?.classList.remove('show');
    return true;
}

function clearAllErrors(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.querySelectorAll('.form-group input, .form-group textarea')
        .forEach(el => el.classList.remove('error'));

    document.querySelectorAll('.error-msg')
        .forEach(el => el.classList.remove('show'));
}

/* =========================================================
   FORM TOGGLE & RESET
   ========================================================= */
function resetForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.reset();
    form.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    form.querySelectorAll('.error-msg').forEach(el => {
        el.textContent = '';
        el.classList.remove('show');
    });

    const diseaseArea = document.getElementById('disease-area');
    const diseaseDesc = document.getElementById('disease_desc');
    const wordCount = document.getElementById('word-count');

    if (diseaseArea) diseaseArea.style.display = 'none';
    if (diseaseDesc) diseaseDesc.value = '';
    if (wordCount) wordCount.textContent = '0';
}

function toggleForm(target) {
    const loginForm = document.getElementById('login-form');
    const regForm = document.getElementById('register-form');
    if (!loginForm || !regForm) return;

    if (target === 'register') {
        resetForm('login-form');
        loginForm.style.display = 'none';
        regForm.style.display = 'block';
    } else {
        resetForm('register-form');
        regForm.style.display = 'none';
        loginForm.style.display = 'block';
    }
}

/* =========================================================
   DISEASE LOGIC
   ========================================================= */
function toggleDisease(radio) {
    const diseaseArea = document.getElementById('disease-area');
    const desc = document.getElementById('disease_desc');
    const counter = document.getElementById('word-count');

    if (!diseaseArea) return;

    if (radio.value === 'yes') {
        diseaseArea.style.display = 'block';
    } else {
        diseaseArea.style.display = 'none';

        // Reset fields
        if (desc) desc.value = '';
        if (counter) counter.textContent = '0';

        // Clear errors
        clearError('disease_desc');
        clearError('dia_status');
    }
}

function countCharacters() {
    const desc = document.getElementById('disease_desc');
    const counter = document.getElementById('word-count');
    if (!desc || !counter) return;

    const text = desc.value.replace(/\s/g, '');
    counter.textContent = text.length;
}

function countWords() {
    const desc = document.getElementById('disease_desc');
    const counter = document.getElementById('word-count');
    if (!desc || !counter) return;

    const words = desc.value.trim()
        ? desc.value.trim().split(/\s+/).length
        : 0;

    counter.textContent = words;
}


/* =========================================================
   LOGIN FORM
   ========================================================= */
document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const userid = document.getElementById('log_userid')?.value.trim();
            const pass = document.getElementById('log_pass')?.value.trim();

            if (!userid) return showError('log_userid', 'Email ID is required.');
            if (!pass) return showError('log_pass', 'Password is required.');

            clearAllErrors('login-form');

            const formData = new FormData();
            formData.append('userid', userid);
            formData.append('password', pass);

            fetchAjax(formData, 'login.php', 'login');
        });
    }

    /* =====================================================
       REGISTER FORM
       ===================================================== */
       const registerForm = document.getElementById('register-form');

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearAllErrors('register-form');

                const name = document.getElementById('reg_name')?.value.trim();
                // const hospita_doctor_name = document.getElementById('reg_hospita_doctor_name')?.value.trim();
                // const diagnosis_status = document.getElementById('reg_diagnosis_status')?.value.trim();
                const age = document.getElementById('reg_age')?.value.trim();
                // const year_of_diagnosed = document.getElementById('reg_year_of_diagnosed')?.value.trim();
                // const type_of_mnd = document.getElementById('reg_type_of_mnd')?.value.trim();
                const email = document.getElementById('reg_email')?.value.trim();
                const phone = document.getElementById('reg_phone')?.value.trim();
                const pass = document.getElementById('reg_pass')?.value;
                const confirm = document.getElementById('reg_confirm')?.value;
                const consent = document.getElementById('reg_consent')?.checked;
                const diseaseRadio = document.querySelector('input[name="disease"]:checked');
                const diseaseYes = diseaseRadio && diseaseRadio.value === 'yes';

                /* ===== BASIC VALIDATION ===== */

                if (!name) return showError('reg_name', 'Name is required.');
                // if (!hospita_doctor_name) return showError('reg_hospita_doctor_name', 'Hospital / Doctor name is required.');
                // if (!diagnosis_status) return showError('reg_diagnosis_status', 'Diagnosis status is required.');
                // if (!type_of_mnd) return showError('reg_type_of_mnd', 'Type of MND is required.');
                if (!age) return showError('reg_age', 'Age is required.');
                // if (!year_of_diagnosed) return showError('reg_year_of_diagnosed', 'Year of diagnosed is required.');

                if (!phone) return showError('reg_phone', 'Phone No is required.');
                if (!/^\d{10}$/.test(phone))
                    return showError('reg_phone', 'Phone No must be 10 digits.');

                if (!email) return showError('reg_email', 'Email ID is required.');
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
                    return showError('reg_email', 'Email ID is not valid.');

                if (!pass) return showError('reg_pass', 'Password is required.');
                if (pass.length < 6)
                    return showError('reg_pass', 'Password must be at least 6 characters.');

                if (!confirm)
                    return showError('reg_confirm', 'Confirm Password is required.');
                if (pass !== confirm)
                    return showError('reg_confirm', 'Passwords do not match.');


                if (diseaseYes) {
                    const diagnosisStatus =
                        document.getElementById('diagnosis_status')?.value;
                    const desc =
                        document.getElementById('disease_desc')?.value.trim();

                    const words = desc ? desc.split(/\s+/).length : 0;

                    if (!diagnosisStatus || diagnosisStatus === 'Select') {
                        return showError(
                            'diagnosis_status',
                            'Diagnosis Status is required.'
                        );
                    }

                    if (!desc) {
                        return showError(
                            'disease_desc',
                            'Disease description is required.'
                        );
                    }

                    if (words > 100) {
                        return showError(
                            'disease_desc',
                            'Description cannot exceed 100 words.'
                        );
                    }
                }

                /* ===== CONSENT VALIDATION (MANDATORY) ===== */

                if (!consent) {
                    return showError(
                        'reg_consent',
                        'You must provide consent to proceed.'
                    );
                }

                /* ===== SUBMIT ===== */

                fetchAjax(new FormData(this), 'register.php', 'register');
            });
        }

        /* =====================================================
       Contact FORM
       ===================================================== */
       const contactForm = document.getElementById('contact-form');
        if (contactForm) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();
                clearAllErrors('contact-form');
                const name = document.getElementById('name')?.value.trim();                 
                const email = document.getElementById('email')?.value.trim();
                const mobile = document.getElementById('mobile')?.value.trim();
                const message = document.getElementById('message')?.value.trim();
                /* ===== BASIC VALIDATION ===== */
                if (!name) return showError('name', 'Name is required.');  
                if (!email) return showError('email', 'Email ID is required.');
                if (!mobile) return showError('mobile', 'Phone No is required.');
                if (!/^\d{10}$/.test(mobile))
                    return showError('mobile', 'Phone No must be 10 digits.');
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
                    return showError('email', 'Email ID is not valid.');                
                const words = message ? message.split(/\s+/).length : 0; 
                if (!message) {
                    return showError(
                        'message',
                        'Message is required.'
                    );
                }
                if (words > 100) {
                    return showError(
                        'message',
                        'Message cannot exceed 100 words.'
                    );
                } 
                const formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('mobile', mobile);
                formData.append('message', message);
                /* ===== SUBMIT ===== */
                fetchAjax(formData, 'contact.php', 'contact');
            });
        }


    /* =====================================================
       AUTO CLEAR ERRORS
       ===================================================== */
    document.querySelectorAll('input, textarea').forEach(field => {
        field.addEventListener('input', () => {
            const errorEl = document.getElementById('error_' + field.id);
            if (errorEl?.classList.contains('show')) {
                field.classList.remove('error');
                errorEl.textContent = '';
                errorEl.classList.remove('show');
            }
        });
    });
});

/* =========================================================
   AJAX
   ========================================================= */
function showLoader() { const loader = document.getElementById('ajaxLoader'); if (loader) { loader.style.display = 'flex'; } } 
function hideLoader() { const loader = document.getElementById('ajaxLoader'); if (loader) { loader.style.display = 'none'; } }

function fetchAjax(formData, phpUrl, type) {
    showLoader();
    fetch(phpUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
    })
        .then(res => res.json())
        .then(response => {
            if (!response.status) {
                showToast(response.message || 'Something went wrong', 'error');
                return;
            }
            if (response.redirect == 0) {
                showToast(response.message || 'Success', 'success');
                window.location.href = 'record.php';
                return;
            }
           if (type === 'contact') {
                showToast(response.message || 'Success', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500); // 1.5 seconds delay
                return;
            }

            if (type === 'login') handleLoginSuccess();
            else toggleForm('login');
        })
        .catch(() => {
            showToast('Server error. Please try again later.', 'error');
        })
        .finally(hideLoader);
}

/* =========================================================
   NAV / USER MENU
   ========================================================= */
function handleLoginSuccess() {
    setTimeout(() => (window.location.href = 'record.php'), 1000);
}

function handleLogout() {
    window.location.href = 'candidate_logout.php';
}

function toggleUserMenu(e) {
    e.stopPropagation();
    document.getElementById('userDropdown')?.classList.toggle('show');
}

document.addEventListener('click', () => {
    document.getElementById('userDropdown')?.classList.remove('show');
});

function toggleMenu() {
    document.querySelector('.mainNav')?.classList.toggle('show');
}

/* =========================================================
   RESPONSIVE RESET
   ========================================================= */
const BREAKPOINT = 1150;

function resetOnResize() {
    const mainNav = document.querySelector('.mainNav');
    const userDropdown = document.getElementById('userDropdown');

    if (window.innerWidth > BREAKPOINT) {
        mainNav?.classList.remove('show');
        userDropdown?.classList.remove('show');
    } else {
        userDropdown?.classList.remove('show');
    }
}

window.addEventListener('resize', resetOnResize);
window.addEventListener('load', resetOnResize);


function openAuthModal(type = 'login') {
    document.getElementById('authModal').classList.add('show');
    toggleForm(type);
    document.body.style.overflow = 'hidden';
}

function closeAuthModal() {
    document.getElementById('authModal').classList.remove('show');
    document.body.style.overflow = '';
}
function closeVoiceModal() {
    document.getElementById('voiceModal').classList.remove('show');
    document.body.style.overflow = '';
}
document.addEventListener('scroll', () => {
    const header = document.querySelector('.main-header');
    const scrollY = window.scrollY;
    const scrollCount = window.innerWidth <= 768 ? 5 : 30;
    if (scrollY > scrollCount) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
});


let isProgrammaticScroll = false;
document.addEventListener('DOMContentLoaded', () => {
    if (!document.body.classList.contains('mainPage')) return;

    const loginBtn = document.getElementById('headerLoginBtn');
    const navLinks = document.querySelectorAll('.main-nav a[href^="#"]');

    if (!navLinks.length) return;

    const sectionMap = new Map();

    navLinks.forEach(link => {
        const id = link.getAttribute('href').replace('#', '');
        const section = document.getElementById(id);
        if (section) {
            sectionMap.set(section, link);
        }
    });

    const setActiveLink = (activeSection) => {
        navLinks.forEach(link => link.classList.remove('active'));
        const activeLink = sectionMap.get(activeSection);
        if (activeLink) activeLink.classList.add('active');
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;

                const section = entry.target;
                setActiveLink(section);

                if (section.id === 'home') {
                    loginBtn?.classList.remove('show');
                } else {
                    loginBtn?.classList.add('show');
                }
            });
        },
        {
            root: null,
            rootMargin: '0px 0px -60% 0px',
            threshold: 0.15
        }
    );

    sectionMap.forEach((_, section) => observer.observe(section));
});


window.addEventListener('load', () => {
    if (!document.body.classList.contains('mainPage')) return;

    const navEntry = performance.getEntriesByType('navigation')[0];
    const isReload = navEntry && navEntry.type === 'reload';

    if (isReload) {
        window.scrollTo({
            top: 0,
            left: 0,
            behavior: 'auto'
        });

        if (window.location.hash) {
            history.replaceState(
                null,
                '',
                window.location.pathname + window.location.search
            );
        }

        document.querySelectorAll('.main-nav a')
            .forEach(a => a.classList.remove('active'));

        document
            .querySelector('.main-nav a[href$="#home"]')
            ?.classList.add('active');
    }
});



document.addEventListener('DOMContentLoaded', () => {
    if (!document.body.classList.contains('mainPage')) return;

    const hash = window.location.hash;
    if (!hash) return;

    const targetEl = document.querySelector(hash);
    if (!targetEl) return;

    setTimeout(() => {
        const headerHeight =
            document.querySelector('.main-header')?.offsetHeight || 0;

        const offsetPosition =
            targetEl.getBoundingClientRect().top +
            window.scrollY -
            headerHeight;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }, 300);
});


document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId.length <= 1) return;

        const targetEl = document.querySelector(targetId);
        if (!targetEl) return;

        e.preventDefault();

        const headerHeight =
            document.querySelector('.main-header')?.offsetHeight || 0;

        const targetY =
            targetEl.getBoundingClientRect().top +
            window.pageYOffset -
            headerHeight;

        isProgrammaticScroll = true;

        smoothScrollTo(targetY, 600);

        document.querySelector('.mainNav')?.classList.remove('show');
    });
});


function smoothScrollTo(targetY, duration = 600) {
    const startY = window.pageYOffset;
    const diff = targetY - startY;
    let startTime = null;

    function step(timestamp) {
        if (!startTime) startTime = timestamp;
        const time = timestamp - startTime;
        const percent = Math.min(time / duration, 1);

        // easeInOutCubic
        const easing =
            percent < 0.5
                ? 4 * percent * percent * percent
                : 1 - Math.pow(-2 * percent + 2, 3) / 2;

        window.scrollTo(0, startY + diff * easing);

        if (time < duration) {
            requestAnimationFrame(step);
        } else {
            isProgrammaticScroll = false;
        }
    }

    requestAnimationFrame(step);
}

(() => {
    const btn = document.getElementById('scrollToTopBtn');
    if (!btn) return;

    let isScrolling = false;

    // Show / hide button
    window.addEventListener(
        'scroll',
        () => {
            if (window.scrollY > 200) {
                btn.classList.add('show');
            } else {
                btn.classList.remove('show');
            }
        },
        { passive: true }
    );

    // Smooth scroll to top (NO header offset)
    btn.addEventListener('click', () => {
        if (isScrolling) return;

        isScrolling = true;
        smoothScrollToTop(600);
    });

    function smoothScrollToTop(duration = 600) {
        const startY = window.pageYOffset;
        let startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / duration, 1);

            // easeInOutCubic
            const ease =
                progress < 0.5
                    ? 4 * progress * progress * progress
                    : 1 - Math.pow(-2 * progress + 2, 3) / 2;

            window.scrollTo(0, startY * (1 - ease));

            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                isScrolling = false;
            }
        }

        requestAnimationFrame(step);
    }
})();
