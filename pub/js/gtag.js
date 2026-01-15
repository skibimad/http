// Google Analytics Event Tracking
// Skibidi Madness - GA4 Event Tracking Implementation
// Using unified g-tag class handler with data-gtag attribute for event names

// Google Analytics Event Tracking Helper
function trackEvent(eventName, eventParams = {}) {
    if (typeof gtag === 'function') {
        gtag('event', eventName, eventParams);
        // Debug logging (disabled in production)
        if (window.location.hostname === 'localhost' || window.location.hostname.includes('127.0.0.1')) {
            console.log('GA Event:', eventName, eventParams);
        }
    }
}

// Initialize Google Analytics Event Tracking
function initAnalyticsTracking() {
    // Attach click handlers directly to elements with g-tag class
    // Event name is specified via data-gtag attribute
    // Additional data can be passed via data-gtag-* attributes
    const gtagElements = document.querySelectorAll('.g-tag');
    gtagElements.forEach(function(element) {
        element.addEventListener('click', function() {
            const eventName = this.dataset.gtag;
            if (!eventName) return;

            // Collect all data-gtag-* attributes as event parameters
            const eventParams = {};
            for (const key in this.dataset) {
                if (key.startsWith('gtag') && key !== 'gtag') {
                    // Convert camelCase to snake_case (e.g., gtagLinkText -> link_text)
                    const paramName = key.replace('gtag', '').replace(/([A-Z])/g, '_$1').toLowerCase().replace(/^_/, '');
                    eventParams[paramName] = this.dataset[key];
                }
            }

            // Add common attributes if not already specified
            if (!eventParams.link_text && this.textContent) {
                eventParams.link_text = this.textContent.trim();
            }
            if (!eventParams.link_url && this.getAttribute('href')) {
                eventParams.link_url = this.getAttribute('href');
            }

            trackEvent(eventName, eventParams);
        });
    });
}

// Initialize analytics tracking when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initAnalyticsTracking();
});
