/**
 * Lazy Loading Implementation for Better Scroll Performance
 * Loads images only when they come into viewport
 */

(function($) {
    'use strict';

    // Intersection Observer for modern browsers
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    
                    // Load the image
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('lazy-loaded');
                        
                        // Remove observer after loading
                        observer.unobserve(img);
                    }
                }
            });
        }, {
            rootMargin: '50px 0px', // Start loading 50px before entering viewport
            threshold: 0.01
        });

        // Observe all lazy images
        function observeLazyImages() {
            const lazyImages = document.querySelectorAll('img[data-src]');
            lazyImages.forEach(img => {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        }

        // Initialize when DOM is ready
        $(document).ready(function() {
            observeLazyImages();
        });

    } else {
        // Fallback for older browsers
        $(document).ready(function() {
            const lazyImages = $('img[data-src]');
            
            function loadVisibleImages() {
                const windowTop = $(window).scrollTop();
                const windowBottom = windowTop + $(window).height();
                
                lazyImages.each(function() {
                    const $img = $(this);
                    const imgTop = $img.offset().top;
                    
                    if (imgTop < windowBottom + 100) { // Load 100px before visible
                        const src = $img.data('src');
                        if (src) {
                            $img.attr('src', src);
                            $img.removeClass('lazy');
                            $img.addClass('lazy-loaded');
                            $img.removeAttr('data-src');
                        }
                    }
                });
            }
            
            // Throttled scroll handler for fallback
            let scrollTimeout;
            $(window).on('scroll', function() {
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }
                scrollTimeout = setTimeout(loadVisibleImages, 100);
            });
            
            // Load initially visible images
            loadVisibleImages();
        });
    }

    // Add CSS for lazy loading effect
    const lazyStyles = `
        <style>
            img.lazy {
                opacity: 0;
                transition: opacity 0.3s ease-in-out;
            }
            img.lazy-loaded {
                opacity: 1;
            }
            img.lazy::before {
                content: '';
                display: block;
                background: #f0f0f0;
                width: 100%;
                height: 200px;
            }
        </style>
    `;
    
    $('head').append(lazyStyles);

})(jQuery);