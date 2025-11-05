// ========================================
// ENHANCED APP.JS - Modern JavaScript Features
// ========================================

document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // DARK MODE FUNCTIONALITY
    // ========================================

    const initDarkMode = () => {
        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);

        // Create theme toggle button if it doesn't exist
        if (!document.querySelector('.theme-toggle')) {
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'theme-toggle';
            toggleBtn.setAttribute('aria-label', 'Toggle dark mode');
            toggleBtn.innerHTML = currentTheme === 'dark' ? '☀️' : '🌙';
            document.body.appendChild(toggleBtn);

            toggleBtn.addEventListener('click', () => {
                const theme = document.documentElement.getAttribute('data-theme');
                const newTheme = theme === 'dark' ? 'light' : 'dark';

                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                toggleBtn.innerHTML = newTheme === 'dark' ? '☀️' : '🌙';

                // Add transition effect
                document.documentElement.style.transition = 'background-color 0.3s ease, color 0.3s ease';
                setTimeout(() => {
                    document.documentElement.style.transition = '';
                }, 300);
            });
        }
    };

    // ========================================
    // HEADER SCROLL EFFECT WITH GLASSMORPHISM
    // ========================================

    const header = document.querySelector('.header');

    if (header) {
        let lastScroll = 0;

        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                header.classList.add('scrolled', 'glass');
            } else {
                header.classList.remove('scrolled', 'glass');
            }

            // Hide header on scroll down, show on scroll up
            if (currentScroll > lastScroll && currentScroll > 200) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }

            lastScroll = currentScroll;
        });
    }

    // ========================================
    // INTERSECTION OBSERVER - SCROLL ANIMATIONS
    // ========================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const animateOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Unobserve after animation to improve performance
                animateOnScroll.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    const animatedElements = document.querySelectorAll(
        '.fade-in, .fade-in-up, .fade-in-left, .fade-in-right, .scale-in'
    );

    animatedElements.forEach(element => {
        animateOnScroll.observe(element);
    });

    // ========================================
    // PARALLAX SCROLLING EFFECT
    // ========================================

    const parallaxElements = document.querySelectorAll(
        '.parallax-slow, .parallax-medium, .parallax-fast'
    );

    if (parallaxElements.length > 0 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;

            parallaxElements.forEach(element => {
                const speed = element.classList.contains('parallax-slow') ? 0.5 :
                             element.classList.contains('parallax-medium') ? 0.3 : 0.1;

                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    }

    // ========================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ========================================

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Skip if href is just "#"
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);

            if (target) {
                const headerOffset = header ? header.offsetHeight : 0;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset - 20;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ========================================
    // ENHANCED BUTTON INTERACTIONS
    // ========================================

    const buttons = document.querySelectorAll('.btn, .btn-primary, .btn-modern');

    buttons.forEach(button => {
        // Add ripple effect on click
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s ease-out';
            ripple.style.pointerEvents = 'none';

            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });

        // Enhanced hover effects
        button.addEventListener('mouseenter', function() {
            if (!this.classList.contains('btn-modern')) {
                this.style.transform = 'translateY(-2px)';
            }
        });

        button.addEventListener('mouseleave', function() {
            if (!this.classList.contains('btn-modern')) {
                this.style.transform = 'translateY(0)';
            }
        });
    });

    // Add ripple animation to stylesheet dynamically
    if (!document.getElementById('ripple-animation')) {
        const style = document.createElement('style');
        style.id = 'ripple-animation';
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // ========================================
    // ANIMATED COUNTER FOR STATISTICS
    // ========================================

    const animateCounter = (element, target, duration = 2000) => {
        // Extract numeric value from text
        const text = element.textContent;
        const numericMatch = text.match(/[\d,.]+/);

        if (!numericMatch) return;

        const numericValue = parseFloat(numericMatch[0].replace(/,/g, ''));
        if (isNaN(numericValue)) return;

        const start = 0;
        const increment = numericValue / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;

            if (current >= numericValue) {
                element.textContent = text.replace(/[\d,.]+/, numericValue.toLocaleString());
                clearInterval(timer);
            } else {
                element.textContent = text.replace(/[\d,.]+/, Math.floor(current).toLocaleString());
            }
        }, 16);
    };

    // Observe stat numbers for animation
    const statNumbers = document.querySelectorAll('.stat-number');

    if (statNumbers.length > 0) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const targetValue = entry.target.textContent;
                    animateCounter(entry.target, targetValue);
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(stat => statsObserver.observe(stat));
    }

    // ========================================
    // FORM ENHANCEMENTS
    // ========================================

    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        // Prevent double submission
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');

            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;

                // Add loading spinner
                const originalText = submitBtn.textContent;
                submitBtn.innerHTML = `
                    <span class="spinner" style="
                        width: 16px;
                        height: 16px;
                        border: 2px solid rgba(255,255,255,0.3);
                        border-top-color: white;
                        border-radius: 50%;
                        display: inline-block;
                        animation: spin 0.6s linear infinite;
                        margin-right: 8px;
                    "></span>
                    Chargement...
                `;

                // Re-enable after 5 seconds (safety fallback)
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                }, 5000);
            }
        });

        // Enhanced input validation feedback
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                this.classList.add('error');
            });

            input.addEventListener('input', function() {
                if (this.validity.valid) {
                    this.classList.remove('error');
                    this.classList.add('success');
                } else {
                    this.classList.add('error');
                    this.classList.remove('success');
                }
            });
        });
    });

    // ========================================
    // PASSWORD TOGGLE FUNCTIONALITY
    // ========================================

    const passwordToggles = document.querySelectorAll('.toggle-password');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const input = this.previousElementSibling || this.closest('.input-group')?.querySelector('input');

            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    this.textContent = '🙈';
                    this.setAttribute('aria-label', 'Hide password');
                } else {
                    input.type = 'password';
                    this.textContent = '👁️';
                    this.setAttribute('aria-label', 'Show password');
                }
            }
        });
    });

    // ========================================
    // CARD 3D TILT EFFECT (Mouse Movement)
    // ========================================

    const tiltCards = document.querySelectorAll('.card-3d, .product-card');

    if (tiltCards.length > 0 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        tiltCards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;

                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
            });
        });
    }

    // ========================================
    // LAZY LOADING IMAGES
    // ========================================

    const lazyImages = document.querySelectorAll('img[data-src]');

    if (lazyImages.length > 0) {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // ========================================
    // TOAST NOTIFICATION SYSTEM
    // ========================================

    window.showToast = (message, type = 'info', duration = 3000) => {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            background: var(--${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'});
            color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
            font-weight: 600;
        `;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    };

    // Add toast animations
    if (!document.getElementById('toast-animations')) {
        const style = document.createElement('style');
        style.id = 'toast-animations';
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }

    // ========================================
    // INITIALIZE ALL FEATURES
    // ========================================

    initDarkMode();

    // Add enhanced classes to elements
    document.querySelectorAll('.btn-primary').forEach(btn => {
        if (!btn.classList.contains('btn-modern')) {
            btn.classList.add('btn-gradient-shift', 'lift-hover');
        }
    });

    document.querySelectorAll('.feature-item, .product-card').forEach(card => {
        card.classList.add('card-reveal');
    });

    // Console message for developers
    console.log('%c✨ Enhanced Styles Loaded!', 'color: #4F46E5; font-size: 16px; font-weight: bold;');
    console.log('%cDark mode, animations, and modern effects are active.', 'color: #6B7280; font-size: 12px;');
});

// ========================================
// PERFORMANCE MONITORING (Optional)
// ========================================

if ('PerformanceObserver' in window) {
    const perfObserver = new PerformanceObserver((list) => {
        for (const entry of list.getEntries()) {
            if (entry.loadTime > 2500) {
                console.warn(`Slow element detected: ${entry.name} took ${entry.loadTime}ms to load`);
            }
        }
    });

    // Uncomment to enable performance monitoring
    // perfObserver.observe({ entryTypes: ['element'] });
}
