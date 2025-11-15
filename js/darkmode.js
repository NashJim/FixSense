// Universal Dark Mode System for FixSense
// This script should be included on all pages to maintain consistent dark mode

class DarkModeManager {
    constructor() {
        this.body = document.body;
        this.darkModeKey = 'darkMode'; // Using same key as existing system
        this.init();
    }

    init() {
        // Apply saved dark mode preference on page load
        this.applySavedTheme();
        
        // Find and setup dark mode toggle button
        this.setupToggleButton();
        
        // Listen for storage changes (for cross-tab synchronization)
        window.addEventListener('storage', (e) => {
            if (e.key === this.darkModeKey) {
                this.applySavedTheme();
                this.updateToggleButton();
            }
        });
    }

    applySavedTheme() {
        const isDarkMode = localStorage.getItem(this.darkModeKey) === 'true';
        if (isDarkMode) {
            this.body.classList.add('dark-mode');
        } else {
            this.body.classList.remove('dark-mode');
        }
    }

    setupToggleButton() {
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                this.toggleDarkMode();
            });
            this.updateToggleButton();
        }
    }

    toggleDarkMode() {
        const isCurrentlyDark = this.body.classList.contains('dark-mode');
        
        if (isCurrentlyDark) {
            this.body.classList.remove('dark-mode');
            localStorage.setItem(this.darkModeKey, 'false');
        } else {
            this.body.classList.add('dark-mode');
            localStorage.setItem(this.darkModeKey, 'true');
        }
        
        this.updateToggleButton();
    }

    updateToggleButton() {
        const toggleButton = document.getElementById('darkModeToggle');
        if (toggleButton) {
            const isDarkMode = this.body.classList.contains('dark-mode');
            toggleButton.innerHTML = isDarkMode ? 
                '<i class="fas fa-sun"></i>' : 
                '<i class="fas fa-moon"></i>';
        }
    }

    isDarkMode() {
        return this.body.classList.contains('dark-mode');
    }
}

// Initialize dark mode manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.darkModeManager = new DarkModeManager();
});

// Also initialize immediately if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.darkModeManager = new DarkModeManager();
    });
} else {
    window.darkModeManager = new DarkModeManager();
}