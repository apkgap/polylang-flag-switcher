/**
 * Frontend JavaScript for Polylang Flag Switcher
 * Pure ES6 - No jQuery
 */

class PolylangFlagSwitcher {
    constructor() {
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.onReady());
        } else {
            this.onReady();
        }
    }

    onReady() {
        this.initLanguageDropdown();
        this.initFlagAnimations();
        this.initAccessibility();
        this.initResponsiveBehavior();
        this.initLanguageTracking();
        this.initModalLanguageSwitcher();
        this.initLanguageSearch();
        this.initTooltips();
        this.initLazyLoading();
    }

    /**
     * Initialize language dropdown functionality
     */
    initLanguageDropdown() {
        const dropdowns = document.querySelectorAll('.pfs-language-dropdown');

        dropdowns.forEach((dropdown, index) => {
            const currentDisplay = dropdown.querySelector('.pfs-current-display');
            const options = dropdown.querySelector('.pfs-dropdown-options');

            if (!currentDisplay) return;

            // Remove any existing click handlers by cloning
            const newCurrentDisplay = currentDisplay.cloneNode(true);
            currentDisplay.parentNode.replaceChild(newCurrentDisplay, currentDisplay);

            // Toggle dropdown on click
            newCurrentDisplay.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                // Close other dropdowns
                document.querySelectorAll('.pfs-language-dropdown.active')
                    .forEach(other => {
                        if (other !== dropdown) {
                            other.classList.remove('active');
                        }
                    });

                // Toggle current dropdown
                dropdown.classList.toggle('active');

                // Update ARIA
                const isExpanded = dropdown.classList.contains('active');
                newCurrentDisplay.setAttribute('aria-expanded', isExpanded);
            });

            // Handle keyboard navigation
            newCurrentDisplay.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    dropdown.classList.toggle('active');
                } else if (e.key === 'Escape') {
                    dropdown.classList.remove('active');
                }
            });

            // Handle option clicks
            if (options) {
                options.querySelectorAll('.pfs-dropdown-option').forEach(option => {
                    option.addEventListener('click', (e) => {
                        // If in Elementor Editor, update current display instead of navigating
                        if (typeof elementor !== 'undefined') {
                            e.preventDefault();
                            this.updateCurrentLanguageDisplay(dropdown, option);
                        }
                        dropdown.classList.remove('active');
                    });

                    option.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            e.preventDefault();
                            dropdown.classList.remove('active');
                            newCurrentDisplay.focus();
                        }
                    });
                });
            }

            // Set initial ARIA attributes
            newCurrentDisplay.setAttribute('role', 'button');
            newCurrentDisplay.setAttribute('tabindex', '0');
            newCurrentDisplay.setAttribute('aria-expanded', 'false');
            newCurrentDisplay.setAttribute('aria-haspopup', 'true');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.pfs-language-dropdown')) {
                const activeDropdowns = document.querySelectorAll('.pfs-language-dropdown.active');
                if (activeDropdowns.length > 0) {
                    activeDropdowns.forEach(dropdown => dropdown.classList.remove('active'));
                }
            }
        }, { capture: true });
    }

    /**
     * Update current language display (for Elementor Editor preview)
     */
    updateCurrentLanguageDisplay(dropdown, clickedOption) {
        const currentDisplay = dropdown.querySelector('.pfs-current-display');
        if (!currentDisplay) return;

        // Clone the clicked option's content (excluding the checkmark)
        const optionContent = clickedOption.cloneNode(true);
        const checkmark = optionContent.querySelector('::after');
        if (checkmark) checkmark.remove();

        // Update current display content (keep arrow)
        const arrow = currentDisplay.querySelector('.pfs-dropdown-arrow');
        currentDisplay.innerHTML = optionContent.innerHTML;
        if (arrow) {
            currentDisplay.appendChild(arrow);
        } else {
            const newArrow = document.createElement('span');
            newArrow.className = 'pfs-dropdown-arrow';
            currentDisplay.appendChild(newArrow);
        }

        // Update current option styling
        dropdown.querySelectorAll('.pfs-dropdown-option').forEach(opt => {
            opt.classList.remove('pfs-current-option');
        });
        clickedOption.classList.add('pfs-current-option');
    }

    /**
     * Initialize flag animations
     */
    initFlagAnimations() {
        // Add hover effects to language items
        const items = document.querySelectorAll('.pfs-language-item, .pfs-single-flag');

        items.forEach(item => {
            const flag = item.querySelector('.pfs-flag');
            if (!flag) return;

            item.addEventListener('mouseenter', () => {
                flag.classList.add('pfs-flag-hover');
            });

            item.addEventListener('mouseleave', () => {
                flag.classList.remove('pfs-flag-hover');
            });
        });

        // Add pulse animation to current language flag
        const currentItems = document.querySelectorAll('.pfs-current-language');

        currentItems.forEach(currentItem => {
            const flag = currentItem.querySelector('.pfs-flag');
            if (!flag) return;

            // Add pulse effect on page load
            setTimeout(() => {
                flag.classList.add('pfs-flag-pulse');
                setTimeout(() => {
                    flag.classList.remove('pfs-flag-pulse');
                }, 1000);
            }, 500);
        });
    }

    /**
     * Initialize accessibility features
     */
    initAccessibility() {
        // Add ARIA attributes to dropdowns
        const dropdowns = document.querySelectorAll('.pfs-language-dropdown');

        dropdowns.forEach(dropdown => {
            const currentDisplay = dropdown.querySelector('.pfs-current-display');
            const options = dropdown.querySelector('.pfs-dropdown-options');

            if (!currentDisplay) return;

            // Set ARIA attributes
            currentDisplay.setAttribute('aria-expanded', 'false');
            currentDisplay.setAttribute('aria-haspopup', 'true');
            currentDisplay.setAttribute('role', 'button');
            currentDisplay.setAttribute('tabindex', '0');

            if (options) {
                options.setAttribute('role', 'menu');

                options.querySelectorAll('.pfs-dropdown-option').forEach(option => {
                    option.setAttribute('role', 'menuitem');
                });
            }
        });

        // Add focus management
        const links = document.querySelectorAll('.pfs-language-link, .pfs-flag-link');

        links.forEach(link => {
            link.addEventListener('focus', () => {
                const parent = link.closest('.pfs-language-item, .pfs-single-flag');
                if (parent) parent.classList.add('pfs-focused');
            });

            link.addEventListener('blur', () => {
                const parent = link.closest('.pfs-language-item, .pfs-single-flag');
                if (parent) parent.classList.remove('pfs-focused');
            });
        });
    }

    /**
     * Initialize responsive behavior
     */
    initResponsiveBehavior() {
        let resizeTimer;

        const handleResponsive = () => {
            const windowWidth = window.innerWidth;
            const switchers = document.querySelectorAll('.pfs-flag-switcher');

            switchers.forEach(switcher => {
                const isHorizontal = switcher.classList.contains('pfs-layout-horizontal');

                if (windowWidth <= 768 && isHorizontal) {
                    switcher.classList.add('pfs-mobile-vertical');
                } else {
                    switcher.classList.remove('pfs-mobile-vertical');
                }
            });
        };

        // Initial check
        handleResponsive();

        // Check on window resize
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleResponsive, 250);
        });
    }

    /**
     * Track language switching events
     */
    trackLanguageSwitch(langCode, fromUrl, toUrl) {
        // Send analytics data if analytics is available
        if (typeof gtag !== 'undefined') {
            gtag('event', 'language_switch', {
                language_code: langCode,
                from_url: fromUrl,
                to_url: toUrl
            });
        }

        // Custom event for other tracking systems
        const event = new CustomEvent('pfs:language_switch', {
            detail: { langCode, fromUrl, toUrl }
        });
        document.dispatchEvent(event);
    }

    /**
     * Initialize language switching tracking
     */
    initLanguageTracking() {
        const links = document.querySelectorAll('.pfs-language-link, .pfs-dropdown-option, .pfs-flag-link');

        links.forEach(link => {
            link.addEventListener('click', () => {
                const href = link.getAttribute('href');
                const langCode = link.dataset.lang || '';

                // Only track if it's not the current language
                if (!link.closest('.pfs-current-language') && href) {
                    this.trackLanguageSwitch(langCode, window.location.href, href);
                }
            });
        });
    }

    /**
     * Initialize modal language switcher
     */
    initModalLanguageSwitcher() {
        const triggers = document.querySelectorAll('.pfs-modal-trigger');

        triggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();

                const modalId = trigger.dataset.modal;
                const modal = document.getElementById(modalId);

                if (modal) {
                    modal.classList.add('pfs-modal-active');
                    document.body.classList.add('pfs-modal-open');

                    // Focus management
                    const closeBtn = modal.querySelector('.pfs-modal-close');
                    if (closeBtn) closeBtn.focus();
                }
            });
        });

        // Close modal
        const closeElements = document.querySelectorAll('.pfs-modal-close, .pfs-modal-overlay');

        closeElements.forEach(element => {
            element.addEventListener('click', () => {
                document.querySelectorAll('.pfs-modal-active').forEach(modal => {
                    modal.classList.remove('pfs-modal-active');
                });
                document.body.classList.remove('pfs-modal-open');
            });
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.pfs-modal-active').forEach(modal => {
                    modal.classList.remove('pfs-modal-active');
                });
                document.body.classList.remove('pfs-modal-open');
            }
        });
    }

    /**
     * Initialize search functionality for language lists
     */
    initLanguageSearch() {
        const searches = document.querySelectorAll('.pfs-language-search');

        searches.forEach(search => {
            const list = search.nextElementSibling;
            if (!list || !list.classList.contains('pfs-language-list')) return;

            search.addEventListener('input', () => {
                const searchTerm = search.value.toLowerCase();
                const items = list.querySelectorAll('.pfs-language-item');

                items.forEach(item => {
                    const nameElement = item.querySelector('.pfs-language-name');
                    const languageName = nameElement ? nameElement.textContent.toLowerCase() : '';
                    const languageCode = item.dataset.lang || '';

                    if (languageName.includes(searchTerm) || languageCode.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    /**
     * Initialize tooltips for language information
     */
    initTooltips() {
        const triggers = document.querySelectorAll('.pfs-tooltip-trigger');

        triggers.forEach(trigger => {
            const tooltipId = trigger.dataset.tooltip;
            const tooltip = document.getElementById(tooltipId);

            if (!tooltip) return;

            trigger.addEventListener('mouseenter', () => {
                tooltip.classList.add('pfs-tooltip-visible');
            });

            trigger.addEventListener('mouseleave', () => {
                tooltip.classList.remove('pfs-tooltip-visible');
            });

            // Keyboard support
            trigger.addEventListener('focus', () => {
                tooltip.classList.add('pfs-tooltip-visible');
            });

            trigger.addEventListener('blur', () => {
                tooltip.classList.remove('pfs-tooltip-visible');
            });
        });
    }

    /**
     * Initialize lazy loading for flags
     */
    initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const flagObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const flag = entry.target;
                        const flagSrc = flag.dataset.src;

                        if (flagSrc) {
                            flag.setAttribute('src', flagSrc);
                            flag.removeAttribute('data-src');
                            flagObserver.unobserve(flag);
                        }
                    }
                });
            });

            document.querySelectorAll('.pfs-flag[data-src]').forEach(flag => {
                flagObserver.observe(flag);
            });
        } else {
            // Fallback for older browsers
            document.querySelectorAll('.pfs-flag[data-src]').forEach(flag => {
                const flagSrc = flag.dataset.src;

                if (flagSrc) {
                    flag.setAttribute('src', flagSrc);
                    flag.removeAttribute('data-src');
                }
            });
        }
    }

    /**
     * AJAX function to get language data
     */
    async getLanguageData() {
        try {
            const response = await fetch(window.pfs_vars?.ajax_url || '/wp-admin/admin-ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'pfs_get_language_data',
                    nonce: window.pfs_vars?.nonce || ''
                })
            });

            const data = await response.json();

            if (data.success) {
                return data.data;
            } else {
                throw new Error('Failed to fetch language data');
            }
        } catch (error) {
            console.error('Error fetching language data:', error);
            return null;
        }
    }

    /**
     * Refresh all dropdowns
     */
    refreshDropdowns() {
        this.initLanguageDropdown();
    }
}

// Initialize the plugin
const pfsInstance = new PolylangFlagSwitcher();

// Expose to global scope for advanced usage
window.PFS = {
    instance: pfsInstance,
    getLanguageData: () => pfsInstance.getLanguageData(),
    trackLanguageSwitch: (langCode, fromUrl, toUrl) => pfsInstance.trackLanguageSwitch(langCode, fromUrl, toUrl),
    refreshDropdowns: () => pfsInstance.refreshDropdowns()
};