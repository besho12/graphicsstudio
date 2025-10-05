/**
 * FADA.A Navigation JavaScript
 * Handles mobile menu, dropdowns, and language selector
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile Menu Toggle
    const mobileToggle = document.querySelector('.fada-mobile-toggle');
    const mobileNav = document.querySelector('.fada-mobile-nav');
    
    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            mobileNav.classList.toggle('active');
            
            // Prevent body scroll when mobile menu is open
            if (mobileNav.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileNav && mobileToggle) {
            if (!mobileNav.contains(e.target) && !mobileToggle.contains(e.target)) {
                mobileToggle.classList.remove('active');
                mobileNav.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
    
    // Handle dropdown menus on mobile
    const mobileDropdownItems = document.querySelectorAll('.fada-mobile-nav .has-dropdown > .fada-nav-link');
    
    mobileDropdownItems.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const dropdownMenu = this.nextElementSibling;
            const parentItem = this.parentElement;
            
            if (dropdownMenu && dropdownMenu.classList.contains('fada-dropdown-menu')) {
                // Toggle current dropdown
                dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
                
                // Close other dropdowns
                mobileDropdownItems.forEach(function(otherItem) {
                    if (otherItem !== item) {
                        const otherDropdown = otherItem.nextElementSibling;
                        if (otherDropdown && otherDropdown.classList.contains('fada-dropdown-menu')) {
                            otherDropdown.style.display = 'none';
                        }
                    }
                });
            }
        });
    });
    
    // Language Selector Change Handler
    const languageSelectors = document.querySelectorAll('.fada-language-select');
    
    languageSelectors.forEach(function(selector) {
        selector.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
    
    // Smooth scroll for anchor links
    const navLinks = document.querySelectorAll('.fada-nav-link[href^="#"]');
    
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href !== 'javascript:;') {
                e.preventDefault();
                
                const target = document.querySelector(href);
                if (target) {
                    const headerHeight = document.querySelector('.fada-header').offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    if (mobileNav && mobileToggle) {
                        mobileToggle.classList.remove('active');
                        mobileNav.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Reset mobile menu on desktop
            if (mobileToggle && mobileNav) {
                mobileToggle.classList.remove('active');
                mobileNav.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Reset mobile dropdowns
            const mobileDropdowns = document.querySelectorAll('.fada-mobile-nav .fada-dropdown-menu');
            mobileDropdowns.forEach(function(dropdown) {
                dropdown.style.display = '';
            });
        }
    });
    
    // Add scroll effect to header with enhanced blur
    let lastScrollTop = 0;
    const header = document.querySelector('.fada-header') || document.querySelector('.nav-header');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Only apply scroll effects if header exists
        if (header) {
            // Add scrolled class for enhanced blur effect
            if (scrollTop > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scrolling down
                header.style.transform = 'translateY(-100%)';
            } else {
                // Scrolling up
                header.style.transform = 'translateY(0)';
            }
        }
        
        lastScrollTop = scrollTop;
    });
    
    // Add active class to current page nav item
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.fada-nav-item');
    
    navItems.forEach(function(item) {
        const link = item.querySelector('.fada-nav-link');
        if (link) {
            const href = link.getAttribute('href');
            
            // Remove domain and get path
            let linkPath = href;
            if (href.startsWith('http')) {
                try {
                    linkPath = new URL(href).pathname;
                } catch (e) {
                    linkPath = href;
                }
            }
            
            if (linkPath === currentPath || (currentPath === '/' && linkPath === '/')) {
                item.classList.add('active');
            }
        }
    });
    
    // Keyboard navigation support
    document.addEventListener('keydown', function(e) {
        // ESC key closes mobile menu
        if (e.key === 'Escape') {
            if (mobileNav && mobileToggle && mobileNav.classList.contains('active')) {
                mobileToggle.classList.remove('active');
                mobileNav.classList.remove('active');
                document.body.style.overflow = '';
            }
        }
    });
    
    // Preload hover effects
    const style = document.createElement('style');
    style.textContent = `
        .fada-nav-link:hover .fada-nav-text {
            color: #60a5fa;
        }
        .fada-dropdown-link:hover {
            background: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
        }
    `;
    document.head.appendChild(style);
    
});

// Utility function to debounce scroll events
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