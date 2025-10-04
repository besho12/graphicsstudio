/**
 * Modern FAQ Accordion JavaScript
 * Handles interactive functionality for the redesigned FAQ section
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize FAQ accordion
    initFAQAccordion();
});

function initFAQAccordion() {
    const faqHeaders = document.querySelectorAll('.faq-header-modern');
    
    faqHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const card = this.closest('.faq-card-modern');
            const collapse = card.querySelector('.faq-collapse');
            const isActive = card.classList.contains('active');
            
            // Close all other FAQ items
            closeAllFAQItems();
            
            // Toggle current item
            if (!isActive) {
                openFAQItem(card, collapse);
            }
        });
    });
    
    // Open first FAQ item by default
    const firstCard = document.querySelector('.faq-card-modern');
    if (firstCard) {
        const firstCollapse = firstCard.querySelector('.faq-collapse');
        openFAQItem(firstCard, firstCollapse);
    }
}

function openFAQItem(card, collapse) {
    card.classList.add('active');
    
    // Ensure visibility first
    collapse.style.opacity = '1';
    collapse.style.visibility = 'visible';
    collapse.style.maxHeight = collapse.scrollHeight + 'px';
    
    // Add smooth animation
    setTimeout(() => {
        collapse.style.maxHeight = 'none';
    }, 300);
}

function closeFAQItem(card, collapse) {
    card.classList.remove('active');
    collapse.style.maxHeight = collapse.scrollHeight + 'px';
    
    // Force reflow
    collapse.offsetHeight;
    
    collapse.style.maxHeight = '0';
    collapse.style.opacity = '0';
    
    // Hide completely after animation
    setTimeout(() => {
        collapse.style.visibility = 'hidden';
    }, 400);
}

function closeAllFAQItems() {
    const activeCards = document.querySelectorAll('.faq-card-modern.active');
    
    activeCards.forEach(card => {
        const collapse = card.querySelector('.faq-collapse');
        closeFAQItem(card, collapse);
    });
}

// Add CSS for smooth transitions
const faqStyle = document.createElement('style');
faqStyle.textContent = `
    .faq-collapse {
        max-height: 0;
        opacity: 0;
        visibility: hidden;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), 
                    opacity 0.3s ease,
                    visibility 0.3s ease;
    }
    
    .faq-card-modern.active .faq-collapse {
        opacity: 1;
        visibility: visible;
    }
    
    .faq-body-modern {
        padding: 0 28px 28px 88px;
        animation: fadeInUp 0.4s ease-out;
    }
    
    .faq-answer {
        color: #e2e8f0 !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
`;
document.head.appendChild(faqStyle);