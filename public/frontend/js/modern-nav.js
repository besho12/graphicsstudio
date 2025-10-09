// Modern Navigation JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle functionality
    const hamburgerBtn = document.querySelector('.modern-hamburger');
    const mobileOverlay = document.querySelector('.mobile-nav-overlay');
    const mobileCloseBtn = document.querySelector('.mobile-nav-close');
    const body = document.body;

    // Toggle mobile menu
    function toggleMobileMenu() {
        hamburgerBtn.classList.toggle('active');
        mobileOverlay.classList.toggle('active');
        body.classList.toggle('mobile-menu-open');
    }

    // Close mobile menu
    function closeMobileMenu() {
        hamburgerBtn.classList.remove('active');
        mobileOverlay.classList.remove('active');
        body.classList.remove('mobile-menu-open');
    }

    // Event listeners for mobile menu
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', toggleMobileMenu);
    }

    if (mobileCloseBtn) {
        mobileCloseBtn.addEventListener('click', closeMobileMenu);
    }

    // Close mobile menu when clicking overlay
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', function(e) {
            if (e.target === mobileOverlay) {
                closeMobileMenu();
            }
        });
    }

    // Close mobile menu on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileOverlay.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    // Mobile dropdown toggle
    const mobileNavItems = document.querySelectorAll('.mobile-nav-menu .nav-item.has-dropdown');
    
    mobileNavItems.forEach(item => {
        const navLink = item.querySelector('.nav-link');
        
        if (navLink) {
            navLink.addEventListener('click', function(e) {
                e.preventDefault();
                item.classList.toggle('active');
                
                // Close other dropdowns
                mobileNavItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
            });
        }
    });

    // Sticky header functionality
    const header = document.querySelector('.modern-nav');
    const stickyWrapper = document.querySelector('.sticky-wrapper');
    
    if (header && stickyWrapper) {
        let lastScrollTop = 0;
        
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > 100) {
                stickyWrapper.classList.add('header-sticky');
            } else {
                stickyWrapper.classList.remove('header-sticky');
            }
            
            // Hide/show header on scroll (optional)
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }
            
            lastScrollTop = scrollTop;
        });
    }

    // Smooth scrolling for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            const target = document.querySelector(href);
            
            if (target) {
                e.preventDefault();
                
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = target.offsetTop - headerHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (mobileOverlay.classList.contains('active')) {
                    closeMobileMenu();
                }
            }
        });
    });

    // Active menu item highlighting
    function updateActiveMenuItem() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link, .dropdown-link');
        
        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            const navItem = link.closest('.nav-item') || link.closest('.dropdown-item');
            
            if (linkPath === currentPath) {
                navItem.classList.add('active');
                
                // If it's a dropdown item, also activate the parent
                const parentDropdown = link.closest('.dropdown-menu');
                if (parentDropdown) {
                    const parentNavItem = parentDropdown.closest('.nav-item');
                    if (parentNavItem) {
                        parentNavItem.classList.add('active');
                    }
                }
            } else {
                navItem.classList.remove('active');
            }
        });
    }

    // Update active menu item on page load
    updateActiveMenuItem();

    // Dropdown hover effects for desktop
    const desktopDropdowns = document.querySelectorAll('.modern-menu .nav-item.has-dropdown');
    
    desktopDropdowns.forEach(dropdown => {
        let hoverTimeout;
        
        dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            this.classList.add('hover');
        });
        
        dropdown.addEventListener('mouseleave', function() {
            const self = this;
            hoverTimeout = setTimeout(() => {
                self.classList.remove('hover');
            }, 100);
        });
    });

    // Search functionality removed

    // Language selector functionality
    const languageSelectors = document.querySelectorAll('.modern-select, .mobile-language-dropdown');
    
    languageSelectors.forEach(selector => {
        selector.addEventListener('change', function() {
            const selectedLang = this.value;
            
            // You can implement language switching logic here
            console.log('Language changed to:', selectedLang);
            
            // Example: redirect to language-specific URL
            // window.location.href = `/${selectedLang}${window.location.pathname}`;
        });
    });

    // Accessibility improvements
    function handleKeyboardNavigation() {
        const focusableElements = document.querySelectorAll(
            '.nav-link, .dropdown-link, .modern-btn, .modern-select, .modern-hamburger'
        );
        
        focusableElements.forEach((element, index) => {
            element.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    // Tab navigation is handled by browser
                    return;
                }
                
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
                
                if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const direction = e.key === 'ArrowDown' ? 1 : -1;
                    const nextIndex = (index + direction + focusableElements.length) % focusableElements.length;
                    focusableElements[nextIndex].focus();
                }
            });
        });
    }

    handleKeyboardNavigation();

    // Performance optimization: Throttle scroll events
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

    // Apply throttling to scroll events
    const throttledScrollHandler = throttle(function() {
        // Any scroll-based functionality can be added here
    }, 100);

    window.addEventListener('scroll', throttledScrollHandler);

    // Initialize animations
    function initAnimations() {
        const animatedElements = document.querySelectorAll('.nav-item, .modern-btn');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                }
            });
        }, {
            threshold: 0.1
        });

        animatedElements.forEach(el => {
            observer.observe(el);
        });
    }

    initAnimations();

    // Search function removed

    // Add loading states for buttons
    function addLoadingState(button) {
        const originalText = button.textContent;
        button.textContent = 'Loading...';
        button.disabled = true;
        
        // Remove loading state after operation
        setTimeout(() => {
            button.textContent = originalText;
            button.disabled = false;
        }, 2000);
    }

    // Add click handlers for buttons that might need loading states
    const actionButtons = document.querySelectorAll('.modern-btn, .mobile-btn');
    actionButtons.forEach(button => {
        if (button.classList.contains('loading-enabled')) {
            button.addEventListener('click', function() {
                addLoadingState(this);
            });
        }
    });
});

// Export functions for external use
window.ModernNav = {
    closeMobileMenu: function() {
        const hamburgerBtn = document.querySelector('.modern-hamburger');
        const mobileOverlay = document.querySelector('.mobile-nav-overlay');
        const body = document.body;
        
        if (hamburgerBtn) hamburgerBtn.classList.remove('active');
        if (mobileOverlay) mobileOverlay.classList.remove('active');
        body.classList.remove('mobile-menu-open');
    },
    
    updateActiveMenuItem: function() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link, .dropdown-link');
        
        navLinks.forEach(link => {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            const navItem = link.closest('.nav-item') || link.closest('.dropdown-item');
            
            if (linkPath === currentPath) {
                navItem.classList.add('active');
            } else {
                navItem.classList.remove('active');
            }
        });
    }
};