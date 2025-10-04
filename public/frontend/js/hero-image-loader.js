/**
 * Hero Image Loader - Optimized Loading for Mobile Performance
 * Handles lazy loading, error handling, and performance optimization
 */

document.addEventListener('DOMContentLoaded', function() {
    const heroImages = document.querySelectorAll('.hero-main-image');
    
    // Check if Intersection Observer is supported
    if ('IntersectionObserver' in window) {
        initLazyLoading();
    } else {
        // Fallback for older browsers
        loadAllImages();
    }
    
    // Initialize lazy loading with Intersection Observer
    function initLazyLoading() {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    loadImage(img);
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });
        
        heroImages.forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Load all images (fallback)
    function loadAllImages() {
        heroImages.forEach(img => {
            loadImage(img);
        });
    }
    
    // Load individual image with error handling
    function loadImage(img) {
        if (!img.src || img.src.includes('null') || img.src.endsWith('/')) {
            handleImageError(img);
            return;
        }
        
        // Add loading class
        img.classList.add('loading');
        
        // Create a new image to preload
        const imageLoader = new Image();
        
        imageLoader.onload = function() {
            img.classList.remove('loading');
            img.classList.add('loaded');
            img.style.opacity = '1';
            
            // Add fade-in animation
            img.style.transition = 'opacity 0.5s ease-in-out';
        };
        
        imageLoader.onerror = function() {
            handleImageError(img);
        };
        
        // Start loading
        imageLoader.src = img.src;
    }
    
    // Handle image loading errors
    function handleImageError(img) {
        img.classList.remove('loading');
        img.classList.add('error');
        img.style.display = 'none';
        
        // Show fallback background
        const heroWrapper = img.closest('.hero-wrapper, .hero-1');
        if (heroWrapper) {
            heroWrapper.classList.add('no-image');
        }
        
        console.log('Hero image failed to load, using fallback background');
    }
    
    // Optimize for mobile devices
    function optimizeForMobile() {
        if (window.innerWidth <= 768) {
            heroImages.forEach(img => {
                // Reduce image quality for mobile
                if (img.src && !img.src.includes('?')) {
                    img.src += '?quality=80&format=webp';
                }
                
                // Add mobile-specific loading attributes
                img.setAttribute('loading', 'lazy');
                img.setAttribute('decoding', 'async');
            });
        }
    }
    
    // Call mobile optimization
    optimizeForMobile();
    
    // Re-optimize on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(optimizeForMobile, 250);
    });
    
    // Preload critical images on faster connections
    if ('connection' in navigator) {
        const connection = navigator.connection;
        if (connection.effectiveType === '4g' && !connection.saveData) {
            // Preload next section images for smooth scrolling
            preloadNextSectionImages();
        }
    }
    
    function preloadNextSectionImages() {
        const nextSectionImages = document.querySelectorAll('section:nth-child(2) img');
        nextSectionImages.forEach(img => {
            if (img.src) {
                const preloadLink = document.createElement('link');
                preloadLink.rel = 'preload';
                preloadLink.as = 'image';
                preloadLink.href = img.src;
                document.head.appendChild(preloadLink);
            }
        });
    }
    
    // Add performance monitoring
    if ('PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                if (entry.name.includes('hero') && entry.name.includes('.jpg' || '.png' || '.webp')) {
                    console.log(`Hero image loaded in ${entry.duration}ms`);
                }
            });
        });
        
        observer.observe({ entryTypes: ['resource'] });
    }
});

// CSS classes for different loading states
const style = document.createElement('style');
style.textContent = `
    .hero-main-image.loading {
        opacity: 0.3;
        filter: blur(2px);
    }
    
    .hero-main-image.loaded {
        opacity: 1;
        filter: none;
    }
    
    .hero-main-image.error {
        display: none !important;
    }
    
    .hero-wrapper.no-image,
    .hero-1.no-image {
        background: linear-gradient(135deg, 
            rgba(59, 130, 246, 0.95) 0%, 
            rgba(37, 99, 235, 0.9) 25%,
            rgba(30, 58, 138, 0.95) 50%,
            rgba(16, 185, 129, 0.9) 75%,
            rgba(6, 182, 212, 0.95) 100%
        ) !important;
        animation: gradientShift 15s ease infinite !important;
    }
`;
document.head.appendChild(style);