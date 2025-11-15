// Universal Dark Mode System for FixSense
// Simple and reliable dark mode implementation

(function() {
    'use strict';

    const DARK_MODE_KEY = 'darkMode';

    function initDarkMode() {
        const body = document.body;
        const toggleButton = document.getElementById('darkModeToggle');

        // Check saved preference (default to light mode)
        const isDarkMode = localStorage.getItem(DARK_MODE_KEY) === 'true';

        // Apply initial theme
        if (isDarkMode) {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }

        // Update button icon
        function updateButtonIcon() {
            if (toggleButton) {
                const currentlyDark = body.classList.contains('dark-mode');
                toggleButton.innerHTML = currentlyDark ? 
                    '<i class="fas fa-sun"></i>' : 
                    '<i class="fas fa-moon"></i>';
            }
        }

        // Initial button update
        updateButtonIcon();

        // Add click event listener
        if (toggleButton) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle dark mode class
                body.classList.toggle('dark-mode');
                
                // Save preference
                const isNowDark = body.classList.contains('dark-mode');
                localStorage.setItem(DARK_MODE_KEY, isNowDark.toString());
                
                // Update button icon
                updateButtonIcon();
            });
        }

        // Listen for storage changes (cross-tab sync)
        window.addEventListener('storage', function(e) {
            if (e.key === DARK_MODE_KEY) {
                const shouldBeDark = e.newValue === 'true';
                if (shouldBeDark) {
                    body.classList.add('dark-mode');
                } else {
                    body.classList.remove('dark-mode');
                }
                updateButtonIcon();
            }
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDarkMode);
    } else {
        initDarkMode();
    }

    // Fallback initialization
    setTimeout(initDarkMode, 100);
})();