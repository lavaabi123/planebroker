<!-- Newsletter Popup -->
<div id="newsletterPopup" class="newsletter-popup">
    <div class="newsletter-popup-content">
        <button class="newsletter-close" onclick="closeNewsletterPopup()">&times;</button>
		
        <div class="newsletter-header mb-4">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="" class="mb-4" />
            <h2>Subscribe to our Newsletter!</h2>
            <p>Stay up to date with our latest news, updates and listings.</p>
        </div>
        <form id="newsletterForm" class="newsletter-form">
            <div class="form-group">
                <input type="email" name="email" id="newsletter-email" placeholder="Email Address *" required>
            </div>
            <div class="form-group">
                <input type="text" name="first_name" id="newsletter-first-name" placeholder="First Name">
            </div>
            <div class="form-group">
                <input type="text" name="last_name" id="newsletter-last-name" placeholder="Last Name">
            </div>
            <button type="submit" class="btn blue-btn w-100">Subscribe</button>
            <div class="newsletter-message"></div>
        </form>
    </div>
</div>

<style>
.newsletter-popup {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    animation: fadeIn 0.3s ease;
    align-items: center;
}

.newsletter-popup-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 40px;
    width: 90%;
    max-width: 500px;
    border-radius: 20px;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.4s ease;
}

.newsletter-close {
    position: absolute;
    right: 10px;
    top: 10px;
    font-size: 32px;
    font-weight: bold;
    color: var(--d-blue);
    background: none;
    border: none;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 32px;
    height: 32px;
}

.newsletter-close:hover {
    color: var(--b-blue);
}

.newsletter-header {
    text-align: center;
}

.newsletter-header img {
    max-width: 270px;
    width: 75%;
    margin: 0 auto;
    display: block;
}

.newsletter-header h2 {
    margin: 0;
    font-size: 27px;
    font-weight: 900;
    letter-spacing: 1px;
}

.newsletter-header p {
    margin: 0;
    color: #515151;
    font-size: 14px;
    font-weight: 500;
}

.newsletter-form input {
    width: 100%;
    padding: 10px 20px !important;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 15px;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

.newsletter-form input:focus {
    outline: none;
    border-color: #4CAF50;
}

.newsletter-message {
    margin-top: 15px;
    padding: 12px;
    border-radius: 6px;
    text-align: center;
    display: none;
}

.newsletter-message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.newsletter-message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .newsletter-popup-content {
        margin: 10% auto;
        padding: 30px 20px;
        width: 95%;
    }
    
    .newsletter-header h2 {
        font-size: var(--title-md);
    }
    
    .newsletter-header p {
        font-size: 11px;
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.btn.disabled, .btn:disabled, fieldset:disabled .btn{
    background: #1b2e5b;
}
</style>

<script>
// Newsletter Popup Logic
(function() {
    const popup = document.getElementById('newsletterPopup');
    const form = document.getElementById('newsletterForm');
    const messageDiv = document.querySelector('.newsletter-message');
    const closeBtn = document.querySelector('.newsletter-close');
    
    // Check if user has already subscribed or dismissed
    function checkSubscriptionStatus() {
        // Check server-side session for login status and subscription
        fetch('<?= base_url('newsletter/check-status') ?>')
            .then(response => response.json())
            .then(data => {
                // Don't show popup if user is logged in
                if (data.logged_in) {
                    console.log('User is logged in - popup will not be shown');
                    return;
                }
                
                // Don't show if already subscribed
                if (data.subscribed) {
                    console.log('User already subscribed - popup will not be shown');
                    return;
                }
                
                // Check localStorage for dismissal (once per day for non-logged-in users)
                const lastShown = localStorage.getItem('newsletter_last_shown');
                
                if (lastShown) {
                    const lastShownTime = parseInt(lastShown);
                    const now = new Date().getTime();
                    const oneDayInMs = 24 * 60 * 60 * 1000; // 24 hours
                    
                    // If less than 24 hours have passed, don't show
                    if (now - lastShownTime < oneDayInMs) {
                        const hoursLeft = Math.ceil((oneDayInMs - (now - lastShownTime)) / (60 * 60 * 1000));
                        console.log('Popup was shown recently. Will show again in ' + hoursLeft + ' hours');
                        return;
                    }
                }
                
                // All checks passed - show popup after 3 seconds
                setTimeout(() => {
                    showPopup();
                }, 3000);
            })
            .catch(error => {
                console.error('Error checking newsletter status:', error);
            });
    }
    
    function showPopup() {
        popup.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        // Store the current timestamp when popup is shown
        localStorage.setItem('newsletter_last_shown', new Date().getTime().toString());
    }
    
    window.closeNewsletterPopup = function() {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Close popup when clicking outside
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
            closeNewsletterPopup();
        }
    });
    
    // Close button handler
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeNewsletterPopup();
        });
    }
    
    // ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && popup.style.display === 'block') {
            closeNewsletterPopup();
        }
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Subscribing...';
        
        const formData = new FormData(form);
        
        fetch('<?= base_url('newsletter/subscribe') ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            messageDiv.style.display = 'block';
            
            if (data.success) {
                messageDiv.className = 'newsletter-message success';
                messageDiv.textContent = data.message;
                form.reset();
                
                // Clear the "last shown" timestamp since user subscribed
                localStorage.removeItem('newsletter_last_shown');
                
                // Close popup after 2 seconds
                setTimeout(() => {
                    popup.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 2000);
            } else {
                messageDiv.className = 'newsletter-message error';
                if (data.errors) {
                    messageDiv.textContent = Object.values(data.errors).join(', ');
                } else {
                    messageDiv.textContent = data.message || 'An error occurred. Please try again.';
                }
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.style.display = 'block';
            messageDiv.className = 'newsletter-message error';
            messageDiv.textContent = 'An error occurred. Please try again.';
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });
    
    // Initialize - check if we should show the popup
    checkSubscriptionStatus();
})();
</script>