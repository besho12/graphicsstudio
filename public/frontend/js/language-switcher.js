/**
 * Modern Language Switcher JavaScript
 * Handles dropdown interactions and mobile menu functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize language switchers
    initLanguageSwitchers();
    
    // Handle mobile menu language switcher
    initMobileLanguageSwitcher();
});

function initLanguageSwitchers() {
    const languageSwitchers = document.querySelectorAll('.language-switcher');
    
    languageSwitchers.forEach(switcher => {
        const toggle = switcher.querySelector('.language-toggle');
        const menu = switcher.querySelector('.language-menu');
        
        if (!toggle || !menu) return;
        
        // Handle desktop dropdown
        if (switcher.classList.contains('desktop')) {
            initDesktopDropdown(toggle, menu);
        }
        
        // Handle mobile dropdown
        if (switcher.classList.contains('mobile')) {
            initMobileDropdown(toggle, menu);
        }
    });
}

function initDesktopDropdown(toggle, menu) {
    // Bootstrap dropdown functionality
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isOpen = menu.classList.contains('show');
        
        // Close all other dropdowns
        closeAllDropdowns();
        
        if (!isOpen) {
            menu.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
            
            // Add click outside listener
            setTimeout(() => {
                document.addEventListener('click', handleOutsideClick);
            }, 0);
        }
    });
    
    // Handle keyboard navigation
    toggle.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggle.click();
        }
        
        if (e.key === 'Escape') {
            closeDropdown(toggle, menu);
        }
    });
    
    // Handle menu item clicks
    const menuItems = menu.querySelectorAll('.language-link');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't prevent default for active language
            if (!this.closest('.language-item').classList.contains('active')) {
                // Allow navigation to proceed
                closeDropdown(toggle, menu);
            } else {
                e.preventDefault();
            }
        });
        
        item.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                this.click();
            }
            
            if (e.key === 'Escape') {
                closeDropdown(toggle, menu);
                toggle.focus();
            }
        });
    });
}

function initMobileDropdown(toggle, menu) {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isOpen = menu.classList.contains('show');
        
        if (isOpen) {
            menu.classList.remove('show');
            toggle.setAttribute('aria-expanded', 'false');
        } else {
            menu.classList.add('show');
            toggle.setAttribute('aria-expanded', 'true');
        }
    });
    
    // Handle menu item clicks
    const menuItems = menu.querySelectorAll('.language-link');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Don't prevent default for active language
            if (!this.closest('.language-item').classList.contains('active')) {
                // Allow navigation to proceed
                menu.classList.remove('show');
                toggle.setAttribute('aria-expanded', 'false');
            } else {
                e.preventDefault();
            }
        });
    });
}

function initMobileLanguageSwitcher() {
    // Handle mobile menu integration
    const mobileMenuToggle = document.querySelector('.menu-toggle');
    const mobileMenu = document.querySelector('.tgmobile__menu');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            // Close language dropdowns when mobile menu is toggled
            setTimeout(() => {
                closeAllDropdowns();
            }, 100);
        });
    }
}

function closeAllDropdowns() {
    const allMenus = document.querySelectorAll('.language-menu.show');
    const allToggles = document.querySelectorAll('.language-toggle[aria-expanded="true"]');
    
    allMenus.forEach(menu => menu.classList.remove('show'));
    allToggles.forEach(toggle => toggle.setAttribute('aria-expanded', 'false'));
    
    document.removeEventListener('click', handleOutsideClick);
}

function closeDropdown(toggle, menu) {
    menu.classList.remove('show');
    toggle.setAttribute('aria-expanded', 'false');
    document.removeEventListener('click', handleOutsideClick);
}

function handleOutsideClick(e) {
    const languageSwitchers = document.querySelectorAll('.language-switcher');
    let clickedInside = false;
    
    languageSwitchers.forEach(switcher => {
        if (switcher.contains(e.target)) {
            clickedInside = true;
        }
    });
    
    if (!clickedInside) {
        closeAllDropdowns();
    }
}

// Handle window resize
window.addEventListener('resize', function() {
    // Close dropdowns on resize to prevent positioning issues
    closeAllDropdowns();
});

// Handle escape key globally
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeAllDropdowns();
    }
});

// Accessibility improvements
function enhanceAccessibility() {
    const languageToggles = document.querySelectorAll('.language-toggle');
    
    languageToggles.forEach(toggle => {
        // Ensure proper ARIA attributes
        if (!toggle.hasAttribute('aria-haspopup')) {
            toggle.setAttribute('aria-haspopup', 'true');
        }
        
        if (!toggle.hasAttribute('aria-expanded')) {
            toggle.setAttribute('aria-expanded', 'false');
        }
        
        // Add role if not present
        const menu = toggle.closest('.language-switcher').querySelector('.language-menu');
        if (menu && !menu.hasAttribute('role')) {
            menu.setAttribute('role', 'menu');
        }
    });
    
    // Enhance menu items
    const languageLinks = document.querySelectorAll('.language-link');
    languageLinks.forEach(link => {
        if (!link.hasAttribute('role')) {
            link.setAttribute('role', 'menuitem');
        }
    });
}

// Initialize accessibility enhancements
document.addEventListener('DOMContentLoaded', enhanceAccessibility);

// Export functions for external use
window.LanguageSwitcher = {
    closeAllDropdowns,
    initLanguageSwitchers,
    enhanceAccessibility
};