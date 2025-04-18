document.addEventListener('DOMContentLoaded', () => {
    // Handle signup form
    const signupForm = document.getElementById('signup-form');
    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(signupForm);
            const authMessages = document.getElementById('auth-messages');

            try {
                const response = await fetch('../php/signup.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                authMessages.innerHTML = `<div class="${data.success ? 'success' : 'error'}-message">${data.message}</div>`;
                
                if (data.success && data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1500); // Increased delay to show welcome message
                }
            } catch (error) {
                console.error('Error:', error);
                authMessages.innerHTML = '<div class="error-message">Error processing request. Please try again.</div>';
            }
        });
    }

    // Handle login form
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(loginForm);
            const authMessages = document.getElementById('auth-messages');

            try {
                const response = await fetch('../php/login.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();

                authMessages.innerHTML = `<div class="${data.success ? 'success' : 'error'}-message">${data.message}</div>`;
                
                if (data.success && data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 1000);
                }
            } catch (error) {
                console.error('Error:', error);
                authMessages.innerHTML = '<div class="error-message">Error processing request. Please try again.</div>';
            }
        });
    }

    // Password toggle
    document.querySelectorAll('.password-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.dataset.target;
            const input = document.getElementById(targetId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            toggle.classList.toggle('fa-eye', isPassword);
            toggle.classList.toggle('fa-eye-slash', !isPassword);
        });
    });

    // Password strength indicator
    const passwordInput = document.getElementById('password');
    const strengthBar = document.querySelector('.bar-level');
    const strengthText = document.querySelector('.strength-text');

    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;
            let strength = 0;

            if (value.length >= 8) strength += 25;
            if (/[A-Z]/.test(value)) strength += 25;
            if (/[0-9]/.test(value)) strength += 25;
            if (/[^A-Za-z0-9]/.test(value)) strength += 25;

            strengthBar.style.width = `${strength}%`;
            strengthBar.style.background = strength < 50 ? '#dc3545' : strength < 75 ? '#ffc107' : '#28a745';
            strengthText.textContent = strength < 50 ? 'Weak' : strength < 75 ? 'Moderate' : 'Strong';
        });
    }
});
