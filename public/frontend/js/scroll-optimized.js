/**
 * Optimized Scroll Handler for Better Performance
 * Replaces multiple scroll event listeners with a single throttled handler
 */

(function($) {
    'use strict';

    // Throttle function to limit scroll event frequency
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

    // Single optimized scroll handler
    function optimizedScrollHandler() {
        const scrollTop = $(window).scrollTop();
        
        // Sticky header functionality
        if (scrollTop > 500) {
            $('.sticky-wrapper').addClass('header-sticky');
        } else {
            $('.sticky-wrapper').removeClass('header-sticky');
        }

        // Scroll to top button functionality
        if ($('.scroll-top').length) {
            const scrollTopBtn = $('.scroll-top');
            const progressPath = document.querySelector('.scroll-top path');
            
            if (progressPath) {
                const pathLength = progressPath.getTotalLength();
                const height = $(document).height() - $(window).height();
                const progress = pathLength - (scrollTop * pathLength / height);
                progressPath.style.strokeDashoffset = progress;
            }

            // Show/hide scroll to top button
            if (scrollTop > 50) {
                scrollTopBtn.addClass('show');
            } else {
                scrollTopBtn.removeClass('show');
            }
        }
    }

    // Initialize optimized scroll handling
    $(document).ready(function() {
        // Use requestAnimationFrame for smoother performance
        let ticking = false;
        
        function updateScroll() {
            optimizedScrollHandler();
            ticking = false;
        }

        $(window).on('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateScroll);
                ticking = true;
            }
        });

        // Initialize scroll to top button
        if ($('.scroll-top').length) {
            const progressPath = document.querySelector('.scroll-top path');
            if (progressPath) {
                const pathLength = progressPath.getTotalLength();
                progressPath.style.transition = 'none';
                progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
                progressPath.style.strokeDashoffset = pathLength;
                progressPath.getBoundingClientRect();
                progressPath.style.transition = 'stroke-dashoffset 10ms linear';
            }

            // Scroll to top click handler
            $('.scroll-top').on('click', function(event) {
                event.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, 750);
                return false;
            });
        }
    });

})(jQuery);