// Initialize Google Translate
function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,es,fr,hi',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: false,
    }, 'google_translate_element');
}

// Load Google Translate Script
const script = document.createElement('script');
script.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
document.head.appendChild(script);

// Function to change language
function changeLanguage(langCode) {
    // Get the Google Translate dropdown
    const googleCombo = document.querySelector('.goog-te-combo');
    
    if (googleCombo) {
        // Set the selected language
        googleCombo.value = langCode;
        // Trigger the change event
        googleCombo.dispatchEvent(new Event('change'));
        
        // Update the displayed language text
        const currentLang = document.getElementById('current-language');
        const languageMap = {
            'en': 'English',
            'es': 'Español',
            'fr': 'Français',
            'hi': 'हिंदी'
        };
        if (currentLang) {
            currentLang.textContent = languageMap[langCode];
        }
        
        // Hide Google Translate elements
        hideTranslateBar();
    }
}

// Function to hide Google Translate bar
function hideTranslateBar() {
    const elements = document.querySelectorAll('.skiptranslate, .goog-te-banner-frame');
    elements.forEach(elem => {
        if (elem) {
            elem.remove();
        }
    });
    document.body.style.top = '0px';
    document.body.classList.remove('skiptranslate');
}

// Add CSS styles
const style = document.createElement('style');
style.textContent = `
    .language-selector {
        position: relative;
        display: inline-block;
    }

    .lang-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: transparent;
        border: none;
        cursor: pointer;
        font-size: 14px;
        color: #333;
    }

    .lang-btn i {
        color: #4CAF50;
    }

    .language-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: none;
        min-width: 150px;
        z-index: 1000;
    }

    .language-selector:hover .language-dropdown {
        display: block;
    }

    .lang-option {
        display: block;
        padding: 8px 16px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.2s;
    }

    .lang-option:hover {
        background-color: #f5f5f5;
        color: #4CAF50;
    }

    /* Hide Google Translate elements */
    #google_translate_element,
    .goog-te-banner-frame,
    .skiptranslate {
        display: none !important;
    }

    body {
        top: 0 !important;
    }

    .goog-te-gadget {
        font-family: inherit !important;
        color: transparent !important;
    }

    .goog-te-gadget span {
        display: none !important;
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initial hide of translate elements
    hideTranslateBar();

    // Set up observer to keep hiding translate bar
    const observer = new MutationObserver(function() {
        hideTranslateBar();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
}); 