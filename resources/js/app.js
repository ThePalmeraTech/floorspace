/**
 * Perfect Stays Theme JavaScript
 * 
 * Main JavaScript file for theme functionality including
 * mobile navigation, booking interactions, and other UI enhancements.
 */

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    console.log('Perfect Stays theme loaded successfully');
    
    // Initialize mobile navigation if present
    initMobileNavigation();
    
    // Initialize any other theme features
    initBookingInteractions();
});

/**
 * Mobile Navigation Handler
 */
function initMobileNavigation() {
    const mobileMenuButton = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isOpen = !mobileMenu.classList.contains('hidden');
            
            if (isOpen) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            } else {
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
            }
        });
    }
}

/**
 * Booking Form Interactions
 */
function initBookingInteractions() {
    // Add smooth scrolling to booking sections
    const bookingLinks = document.querySelectorAll('a[href*="#booking"]');
    
    bookingLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const bookingSection = document.querySelector('#booking');
            if (bookingSection) {
                bookingSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
} 