// ========================================
// ADVANCED ANIMATIONS JS - Le fichier ultime !
// ========================================

document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // PAGE LOADER ANIMATION
    // ========================================
    const pageLoader = document.getElementById('pageLoader');

    window.addEventListener('load', () => {
        setTimeout(() => {
            if (pageLoader) {
                pageLoader.style.opacity = '0';
                setTimeout(() => {
                    pageLoader.style.display = 'none';
                }, 500);
            }
        }, 800);
    });

    // ========================================
    // TYPING EFFECT ANIMATION
    // ========================================
    const typingElements = document.querySelectorAll('.typing-text');

    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.textContent = '';

        function type() {
            if (i < text.length) {
                element.textContent += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }

        type();
    }

    const typingObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.typed) {
                const text = entry.target.textContent.trim();
                entry.target.dataset.typed = 'true';
                typeWriter(entry.target, text, 50);
                typingObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    typingElements.forEach(el => typingObserver.observe(el));

    // ========================================
    // ANIMATED COUNTERS
    // ========================================
    const counterElements = document.querySelectorAll('[data-target]');

    function animateCounter(element) {
        const target = parseFloat(element.dataset.target);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                element.textContent = target % 1 === 0 ? target : target.toFixed(1);
                clearInterval(timer);
            } else {
                element.textContent = current % 1 === 0 ? Math.floor(current) : current.toFixed(1);
            }
        }, 16);
    }

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                entry.target.dataset.animated = 'true';
                animateCounter(entry.target);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counterElements.forEach(el => counterObserver.observe(el));

    // ========================================
    // FAQ ACCORDION ANIMATION
    // ========================================
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');
        const icon = item.querySelector('.faq-icon');

        question.addEventListener('click', () => {
            const isOpen = item.classList.contains('active');

            // Fermer tous les autres items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    const otherAnswer = otherItem.querySelector('.faq-answer');
                    const otherIcon = otherItem.querySelector('.faq-icon');
                    otherAnswer.style.maxHeight = null;
                    otherIcon.textContent = '+';
                }
            });

            // Toggle l'item courant
            if (isOpen) {
                item.classList.remove('active');
                answer.style.maxHeight = null;
                icon.textContent = '+';
            } else {
                item.classList.add('active');
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.textContent = '−';
            }
        });
    });

    // ========================================
    // SCROLL PROGRESS BAR
    // ========================================
    const createScrollProgress = () => {
        const progressBar = document.createElement('div');
        progressBar.className = 'scroll-progress';
        progressBar.innerHTML = '<div class="scroll-progress-bar"></div>';
        document.body.appendChild(progressBar);

        const progressBarInner = progressBar.querySelector('.scroll-progress-bar');

        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBarInner.style.width = scrolled + '%';
        });
    };

    createScrollProgress();

    // ========================================
    // ANIMATED WAVES
    // ========================================
    const waves = document.querySelectorAll('.wave path');

    waves.forEach((wave, index) => {
        wave.style.animation = `wave-animation ${3 + index}s ease-in-out infinite`;
    });

    // ========================================
    // MOUSE PARALLAX EFFECT
    // ========================================
    const parallaxElements = document.querySelectorAll('.hero-content, .pricing-card');

    document.addEventListener('mousemove', (e) => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;

        parallaxElements.forEach((el, index) => {
            const speed = (index + 1) * 0.5;
            const x = (mouseX - 0.5) * speed;
            const y = (mouseY - 0.5) * speed;

            if (!el.style.transition) {
                el.style.transition = 'transform 0.3s ease-out';
            }
        });
    });

    // ========================================
    // ANIMATED GRADIENT BACKGROUNDS
    // ========================================
    const gradientSections = document.querySelectorAll('.gradient-animated');

    gradientSections.forEach(section => {
        let angle = 0;

        setInterval(() => {
            angle = (angle + 1) % 360;
            section.style.backgroundImage = `linear-gradient(${angle}deg, #4F46E5, #7C3AED, #EC4899, #F59E0B)`;
        }, 50);
    });

    // ========================================
    // PRICING CARDS HOVER EFFECT
    // ========================================
    const pricingCards = document.querySelectorAll('.pricing-card');

    pricingCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-20px) scale(1.05)';
            this.style.boxShadow = '0 30px 60px rgba(79, 70, 229, 0.3)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });

    // ========================================
    // TESTIMONIAL CARDS ROTATION
    // ========================================
    const testimonialCards = document.querySelectorAll('.testimonial-card');

    testimonialCards.forEach(card => {
        card.addEventListener('mousemove', function(e) {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) / 20;
            const rotateY = (centerX - x) / 20;

            this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
        });
    });

    // ========================================
    // INTERACTIVE PARTICLES EFFECT
    // ========================================
    const createParticles = () => {
        const particlesContainers = document.querySelectorAll('.particles-bg');

        particlesContainers.forEach(container => {
            const canvas = document.createElement('canvas');
            canvas.className = 'particles-canvas';
            canvas.style.position = 'absolute';
            canvas.style.top = '0';
            canvas.style.left = '0';
            canvas.style.width = '100%';
            canvas.style.height = '100%';
            canvas.style.pointerEvents = 'none';
            canvas.style.zIndex = '0';

            container.style.position = 'relative';
            container.insertBefore(canvas, container.firstChild);

            const ctx = canvas.getContext('2d');
            const particles = [];
            const particleCount = 50;

            canvas.width = container.offsetWidth;
            canvas.height = container.offsetHeight;

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 0.5;
                    this.vy = (Math.random() - 0.5) * 0.5;
                    this.radius = Math.random() * 2 + 1;
                    this.opacity = Math.random() * 0.5 + 0.2;
                }

                update() {
                    this.x += this.vx;
                    this.y += this.vy;

                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = `rgba(79, 70, 229, ${this.opacity})`;
                    ctx.fill();
                }
            }

            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                particles.forEach(particle => {
                    particle.update();
                    particle.draw();
                });

                // Draw connections
                particles.forEach((p1, i) => {
                    particles.slice(i + 1).forEach(p2 => {
                        const dx = p1.x - p2.x;
                        const dy = p1.y - p2.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < 150) {
                            ctx.beginPath();
                            ctx.moveTo(p1.x, p1.y);
                            ctx.lineTo(p2.x, p2.y);
                            ctx.strokeStyle = `rgba(79, 70, 229, ${0.2 * (1 - distance / 150)})`;
                            ctx.lineWidth = 1;
                            ctx.stroke();
                        }
                    });
                });

                requestAnimationFrame(animate);
            }

            animate();

            // Resize handler
            window.addEventListener('resize', () => {
                canvas.width = container.offsetWidth;
                canvas.height = container.offsetHeight;
            });
        });
    };

    createParticles();

    // ========================================
    // SMOOTH SCROLL TO TOP BUTTON
    // ========================================
    const createScrollTopButton = () => {
        const button = document.createElement('button');
        button.className = 'scroll-to-top';
        button.innerHTML = '↑';
        button.setAttribute('aria-label', 'Scroll to top');
        document.body.appendChild(button);

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                button.classList.add('visible');
            } else {
                button.classList.remove('visible');
            }
        });

        button.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    };

    createScrollTopButton();

    // ========================================
    // TEXT REVEAL ANIMATION ON SCROLL
    // ========================================
    const revealTexts = document.querySelectorAll('.section-title, .section-subtitle, .feature-title');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    revealTexts.forEach(text => {
        text.style.opacity = '0';
        text.style.transform = 'translateY(30px)';
        text.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        revealObserver.observe(text);
    });

    // ========================================
    // BUTTON RIPPLE EFFECT ENHANCED
    // ========================================
    const enhancedButtons = document.querySelectorAll('.pricing-btn, .cta-btn');

    enhancedButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple-effect');

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });

    // ========================================
    // IMAGE LAZY LOADING WITH BLUR EFFECT
    // ========================================
    const lazyImages = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));

    // ========================================
    // BACKGROUND MUSIC TOGGLE (OPTIONNEL)
    // ========================================
    const createMusicToggle = () => {
        const musicButton = document.createElement('button');
        musicButton.className = 'music-toggle';
        musicButton.innerHTML = '🎵';
        musicButton.setAttribute('aria-label', 'Toggle background music');
        musicButton.style.display = 'none'; // Désactivé par défaut
        document.body.appendChild(musicButton);

        // Pour activer la musique, décommentez et ajoutez votre fichier audio
        // const audio = new Audio('../assets/background-music.mp3');
        // audio.loop = true;
        // audio.volume = 0.3;

        // let isPlaying = false;

        // musicButton.addEventListener('click', () => {
        //     if (isPlaying) {
        //         audio.pause();
        //         musicButton.innerHTML = '🔇';
        //     } else {
        //         audio.play();
        //         musicButton.innerHTML = '🎵';
        //     }
        //     isPlaying = !isPlaying;
        // });
    };

    // createMusicToggle(); // Décommentez pour activer

    // ========================================
    // CONFETTI ANIMATION (POUR LES SUCCESS)
    // ========================================
    window.triggerConfetti = () => {
        const confettiCount = 150;
        const colors = ['#4F46E5', '#7C3AED', '#EC4899', '#F59E0B', '#10B981'];

        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.animationDelay = Math.random() * 3 + 's';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            document.body.appendChild(confetti);

            setTimeout(() => confetti.remove(), 3000);
        }
    };

    // ========================================
    // CONSOLE ART (Pour les développeurs curieux !)
    // ========================================
    console.log('%c🚀 CHEAP - Site de comptes premium', 'color: #4F46E5; font-size: 24px; font-weight: bold;');
    console.log('%c✨ Animations chargées avec succès !', 'color: #10B981; font-size: 14px;');
    console.log('%c👨‍💻 Développé avec ❤️', 'color: #EC4899; font-size: 12px;');
    console.log('%c📧 Contact: support@cheap.com', 'color: #6B7280; font-size: 10px;');

    // ========================================
    // EASTER EGG - KONAMI CODE
    // ========================================
    const konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'];
    let konamiIndex = 0;

    document.addEventListener('keydown', (e) => {
        if (e.key === konamiCode[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konamiCode.length) {
                triggerConfetti();
                showToast('🎉 Easter egg découvert ! Félicitations !', 'success', 5000);
                konamiIndex = 0;
            }
        } else {
            konamiIndex = 0;
        }
    });

    // ========================================
    // PERFORMANCE MONITORING
    // ========================================
    if (window.performance) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = window.performance.timing;
                const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;

                if (pageLoadTime > 3000) {
                    console.warn('⚠️ Page load time:', pageLoadTime + 'ms (consider optimization)');
                } else {
                    console.log('✅ Page load time:', pageLoadTime + 'ms (excellent!)');
                }
            }, 0);
        });
    }

    console.log('%c🎨 Advanced Animations loaded successfully!', 'color: #4F46E5; font-weight: bold;');
});

// ========================================
// UTILITY: DEBOUNCE FUNCTION
// ========================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ========================================
// UTILITY: THROTTLE FUNCTION
// ========================================
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}
