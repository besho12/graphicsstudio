/**
 * Performance Optimizer for Scroll Smoothness
 * Disables heavy libraries and provides lightweight alternatives
 */

(function($) {
    'use strict';

    // Disable WOW.js on mobile and reduce frequency on desktop
    if (typeof WOW !== 'undefined') {
        // Override WOW configuration for better performance
        const originalWOW = window.WOW;
        window.WOW = function(options) {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                // Disable WOW on mobile completely
                return {
                    init: function() {},
                    sync: function() {},
                    stop: function() {}
                };
            }
            
            // Reduce WOW frequency on desktop
            const optimizedOptions = $.extend({}, options, {
                live: false, // Disable live DOM monitoring
                mobile: false, // Disable on mobile
                offset: 50 // Reduce trigger distance
            });
            
            return new originalWOW(optimizedOptions);
        };
    }

    // Lightweight Intersection Observer alternative to Waypoints
    function createLightweightWaypoint(element, callback, options = {}) {
        const defaults = {
            rootMargin: '0px 0px -10% 0px',
            threshold: 0.1
        };
        
        const config = $.extend({}, defaults, options);
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        callback.call(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, config);
            
            observer.observe(element);
            return observer;
        } else {
            // Fallback for older browsers - throttled scroll
            let ticking = false;
            
            function checkVisibility() {
                const rect = element.getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                if (rect.top <= windowHeight * 0.9 && rect.bottom >= 0) {
                    callback.call(element);
                    $(window).off('scroll.waypoint-' + element.id);
                }
                ticking = false;
            }
            
            function onScroll() {
                if (!ticking) {
                    requestAnimationFrame(checkVisibility);
                    ticking = true;
                }
            }
            
            $(window).on('scroll.waypoint-' + element.id, onScroll);
        }
    }

    // Replace heavy counter animations with lightweight version
    function lightweightCounter(element, options = {}) {
        const $element = $(element);
        const finalValue = parseInt($element.text()) || parseInt($element.attr('data-num')) || 0;
        const duration = options.duration || 1000;
        const steps = 30; // Reduced steps for better performance
        const increment = finalValue / steps;
        const stepDuration = duration / steps;
        
        let currentValue = 0;
        let stepCount = 0;
        
        function updateCounter() {
            if (stepCount < steps) {
                currentValue += increment;
                $element.text(Math.floor(currentValue));
                stepCount++;
                setTimeout(updateCounter, stepDuration);
            } else {
                $element.text(finalValue);
            }
        }
        
        updateCounter();
    }

    // Initialize performance optimizations when DOM is ready
    $(document).ready(function() {
        // Replace Waypoints with lightweight alternatives
        $('.progress-bar').each(function() {
            const $this = $(this);
            createLightweightWaypoint(this, function() {
                $this.css({
                    animation: "animate-positive 1.8s",
                    opacity: "1"
                });
            });
        });

        // Replace CounterUp with lightweight version
        $('.counter-number').each(function() {
            const $this = $(this);
            createLightweightWaypoint(this, function() {
                lightweightCounter(this, {
                    duration: 1000
                });
            });
        });

        // Disable heavy libraries if they exist
        if (typeof Waypoint !== 'undefined') {
            // Disable all existing waypoints
            Waypoint.disableAll();
        }

        // Reduce animation frequency for better scroll performance
        const style = document.createElement('style');
        style.textContent = `
            .wow {
                animation-duration: 0.5s !important;
            }
            
            .animated {
                animation-duration: 0.5s !important;
            }
            
            /* Disable heavy animations on scroll */
            @media (max-width: 768px) {
                .wow, .animated {
                    animation: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    });

    // Debounced resize handler
    let resizeTimeout;
    $(window).on('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Handle resize events here if needed
        }, 250);
    });

})(jQuery);