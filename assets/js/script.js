// Mobile navigation toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // Close mobile menu when clicking on a link
    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navMenu.classList.contains('active')) {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            }
        });
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Form validation enhancement
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            let valid = true;

            // Simple validation for required fields
            const requiredFields = this.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#ef4444';

                    // Add error message if not present
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error')) {
                        const errorSpan = document.createElement('span');
                        errorSpan.className = 'error';
                        errorSpan.textContent = 'This field is required';
                        field.parentNode.appendChild(errorSpan);
                    }
                } else {
                    field.style.borderColor = '#cbd5e1';

                    // Remove error message if present
                    if (field.nextElementSibling && field.nextElementSibling.classList.contains('error')) {
                        field.nextElementSibling.remove();
                    }
                }
            });

            // Email validation
            const emailField = this.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    valid = false;
                    emailField.style.borderColor = '#ef4444';

                    if (!emailField.nextElementSibling || !emailField.nextElementSibling.classList.contains('error')) {
                        const errorSpan = document.createElement('span');
                        errorSpan.className = 'error';
                        errorSpan.textContent = 'Please enter a valid email address';
                        emailField.parentNode.appendChild(errorSpan);
                    }
                }
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    }

    // Animate skill bars on scroll
    const skillBars = document.querySelectorAll('.skill-level');

    if (skillBars.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const skillBar = entry.target;
                    skillBar.style.transition = 'width 1.5s ease-in-out';
                    skillBar.style.width = skillBar.style.width; // Trigger animation

                    // Stop observing after animation
                    observer.unobserve(skillBar);
                }
            });
        }, { threshold: 0.5 });

        skillBars.forEach(bar => {
            observer.observe(bar);
        });
    }
});