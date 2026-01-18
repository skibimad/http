// Skibidi Madness - Main JavaScript

// Throttle utility function for scroll performance
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
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize translations
    if (window.translations) {
        window.translations.init();
    }
    
    // Initialize all features
    initThemeSwitcher();
    initLanguageSelector();
    initNavigation();
    initHeroCards();
    initScrollAnimations();
    initVideoAutoplay();
    initSmoothScroll();
    initAnnouncementBanner();
});

// Theme Switcher
function initThemeSwitcher() {
    const themeButtons = document.querySelectorAll('.theme-btn');
    const storedPreference = localStorage.getItem('theme') || 'dark';
    
    // Set initial active state
    updateThemeButtonState(storedPreference);
    
    // Add click handlers
    themeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const theme = this.getAttribute('data-theme');
            setTheme(theme);
        });
    });
    
    // Listen for system preference changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'system' || !storedTheme) {
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });
}

function setTheme(theme) {
    localStorage.setItem('theme', theme);
    updateThemeButtonState(theme);
    
    if (theme === 'system') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        applyTheme(prefersDark ? 'dark' : 'light');
    } else {
        applyTheme(theme);
    }
}

function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
}

function updateThemeButtonState(activeTheme) {
    const themeButtons = document.querySelectorAll('.theme-btn');
    themeButtons.forEach(button => {
        const buttonTheme = button.getAttribute('data-theme');
        if (buttonTheme === activeTheme) {
            button.classList.add('active');
        } else {
            button.classList.remove('active');
        }
    });
}

// Language Selector
function initLanguageSelector() {
    const langButtons = document.querySelectorAll('.lang-btn');
    
    langButtons.forEach(button => {
        button.addEventListener('click', function() {
            const lang = this.getAttribute('data-lang');
            if (window.translations) {
                window.translations.change(lang);
            }
        });
    });
}

// Navigation - Hamburger Menu
function initNavigation() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    const navLinks = document.querySelectorAll('.nav-menu a');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Close menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (hamburger) {
                hamburger.classList.remove('active');
            }
            if (navMenu) {
                navMenu.classList.remove('active');
            }
        });
    });
    
    // Navbar background on scroll (throttled for performance)
    const navbar = document.querySelector('.navbar');
    let lastScroll = 0;
    
    const handleNavbarScroll = throttle(function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.8)';
        } else {
            navbar.style.boxShadow = '0 4px 30px rgba(0, 0, 0, 0.5)';
        }
        
        lastScroll = currentScroll;
    }, 16); // ~60fps throttle
    
    window.addEventListener('scroll', handleNavbarScroll, { passive: true });
}

/* Hero Cards - Video Preview on Hover */
function initHeroCards() {
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        const video = card.querySelector('.hero-video-preview');
        
        if (video) {
            card.addEventListener('mouseenter', function() {
                // Add scale effect
                this.style.transform = 'translateY(-10px) scale(1.02)';
                
                video.play().catch(err => {
                    // Autoplay might be blocked, ignore the error
                    console.log('Video autoplay prevented:', err);
                });
            });
            
            card.addEventListener('mouseleave', function() {
                // Reset transform
                this.style.transform = '';
                
                video.pause();
                video.currentTime = 0;
            });
        }
    });
}

// Scroll Animations
function initScrollAnimations() {
    // Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe sections
    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(section);
    });
    
    // Observe cards
    const cards = document.querySelectorAll('.hero-card, .video-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
}

// Video Autoplay for Channel Section
function initVideoAutoplay() {
    const videos = document.querySelectorAll('video[autoplay]');
    
    // Ensure videos play when visible
    const videoObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.play().catch(err => {
                    console.log('Video autoplay prevented:', err);
                });
            } else {
                entry.target.pause();
            }
        });
    }, { threshold: 0.5 });
    
    videos.forEach(video => {
        videoObserver.observe(video);
    });
}

// Smooth Scroll for Navigation Links
function initSmoothScroll() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            // Skip if it's just '#'
            if (targetId === '#') {
                return;
            }
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Auto-hide announcement banner after 5 seconds
function initAnnouncementBanner() {
    const banner = document.querySelector('.version-announcement');
    if (banner) {
        setTimeout(function() {
            banner.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            banner.style.opacity = '0';
            banner.style.transform = 'translateY(-20px)';
            
            // Remove from DOM after animation completes
            setTimeout(function() {
                banner.remove();
            }, 800);
        }, 5000);
    }
}

// Parallax effect for hero section (throttled for performance)
const heroVideo = document.querySelector('.hero-video');
if (heroVideo) {
    const handleParallax = throttle(function() {
        const scrolled = window.pageYOffset;
        // Only apply parallax when in view (hero section)
        if (scrolled < window.innerHeight) {
            heroVideo.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    }, 16); // ~60fps throttle
    
    window.addEventListener('scroll', handleParallax, { passive: true });
}

// Loading screen (optional - can be added if needed)
window.addEventListener('load', function() {
    const loading = document.querySelector('.loading');
    if (loading) {
        loading.classList.add('hidden');
    }
});

// Add glitch effect to title on hover
const glitchText = document.querySelector('.glitch-text');
if (glitchText) {
    glitchText.addEventListener('mouseenter', function() {
        this.style.animationDuration = '0.3s';
    });
    
    glitchText.addEventListener('mouseleave', function() {
        this.style.animationDuration = '2s';
    });
}

// Prevent right-click on videos (optional protection)
const allVideos = document.querySelectorAll('video');
allVideos.forEach(video => {
    video.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        return false;
    });
});

// Console easter egg - using design system colors
const styles = {
    title: 'color: var(--color-primary, #ff3366); font-size: 24px; font-weight: bold; text-shadow: 2px 2px 0px var(--color-secondary, #00ffcc);',
    subtitle: 'color: var(--color-secondary, #00ffcc); font-size: 16px;',
    link: 'color: var(--color-accent, #ffcc00); font-size: 14px;'
};

console.log('%c🎬 Skibidi Madness 🎬', styles.title);
console.log('%cWelcome to the Multiverse!', styles.subtitle);
console.log('%cSubscribe to FireStormX Studios: https://www.youtube.com/@FireStorm-Tri', styles.link);

// Helper function to check if element is a form input
function isFormElement(element) {
    const formTags = ['INPUT', 'TEXTAREA', 'SELECT'];
    return formTags.includes(element.tagName);
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Press 'H' to go to home
    if (e.key === 'h' || e.key === 'H') {
        if (!e.ctrlKey && !e.metaKey && !isFormElement(document.activeElement)) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
    
    // Press 'L' to change language
    if (e.key === 'l' || e.key === 'L') {
        if (!e.ctrlKey && !e.metaKey && !isFormElement(document.activeElement)) {
            const langButtons = document.querySelectorAll('.lang-btn');
            const activeLang = document.querySelector('.lang-btn.active');
            const currentIndex = Array.from(langButtons).indexOf(activeLang);
            const nextIndex = (currentIndex + 1) % langButtons.length;
            langButtons[nextIndex].click();
        }
    }
    
    // Press 'T' to cycle through themes
    if (e.key === 't' || e.key === 'T') {
        if (!e.ctrlKey && !e.metaKey && !isFormElement(document.activeElement)) {
            const themeButtons = document.querySelectorAll('.theme-btn');
            const activeTheme = document.querySelector('.theme-btn.active');
            const currentIndex = Array.from(themeButtons).indexOf(activeTheme);
            const nextIndex = (currentIndex + 1) % themeButtons.length;
            themeButtons[nextIndex].click();
        }
    }
});

// Add dynamic copyright year
const footerBottom = document.querySelector('.footer-bottom p');
if (footerBottom) {
    const currentYear = new Date().getFullYear();
    // Only replace the year in the copyright notice
    footerBottom.innerHTML = footerBottom.innerHTML.replace(/©\s*\d{4}/, `© ${currentYear}`);
}

// Performance optimization: Lazy load images
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

// Add touch support for hero cards on mobile
if ('ontouchstart' in window) {
    const heroCards = document.querySelectorAll('.hero-card');
    
    heroCards.forEach(card => {
        let touchStartTime;
        
        card.addEventListener('touchstart', function() {
            touchStartTime = Date.now();
        });
        
        card.addEventListener('touchend', function(e) {
            const touchDuration = Date.now() - touchStartTime;
            
            // If it's a quick tap (less than 200ms), toggle video
            if (touchDuration < 200) {
                const video = this.querySelector('.hero-video-preview');
                const image = this.querySelector('.hero-image');
                
                if (video && image) {
                    if (video.style.opacity === '1') {
                        video.style.opacity = '0';
                        video.pause();
                        video.currentTime = 0;
                        image.style.opacity = '1';
                    } else {
                        video.style.opacity = '1';
                        image.style.opacity = '0';
                        video.play().catch(err => {
                            console.log('Video play prevented:', err);
                        });
                    }
                }
            }
        });
    });
}
