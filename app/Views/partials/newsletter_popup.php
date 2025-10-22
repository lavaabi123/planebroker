<!-- Newsletter Popup -->
<div id="newsletterPopup" class="newsletter-popup">
    <div class="newsletter-popup-content">
        <button class="newsletter-close" onclick="closeNewsletterPopup()">&times;</button>
		
        <div class="newsletter-header mb-4">
		<img src="<?= base_url('assets/img/logo.png') ?>" alt="" class="mb-4" />
            <h2>Subscribe to Our Newsletter</h2>
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
        <!-- Add this new section 
        <div class="newsletter-footer">
            <a href="#" onclick="neverShowNewsletter(); return false;" class="newsletter-never-show">
                Don't show this again
            </a>
        </div>-->
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
        font-size: var(--title-lg);
    }
    .newsletter-header p {
    font-size: 12px;
}
    .newsletter-form .form-row {
        flex-direction: column;
        gap: 15px;
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
.newsletter-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.newsletter-never-show {
    color: #999;
    font-size: 13px;
    text-decoration: none;
    transition: color 0.3s;
}

.newsletter-never-show:hover {
    color: #333;
    text-decoration: underline;
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
        const dontShowAgain = localStorage.getItem('newsletter_dont_show');
        const dismissedUntil = localStorage.getItem('newsletter_dismissed_until');
        
        // Don't show if permanently dismissed
        if (dontShowAgain) {
            return;
        }
        
        // Check if temporarily dismissed
        if (dismissedUntil) {
            const dismissedTime = parseInt(dismissedUntil);
            const now = new Date().getTime();
            
            // If dismissed time hasn't passed, don't show
            if (now < dismissedTime) {
                return;
            } else {
                // Clear expired dismissal
                localStorage.removeItem('newsletter_dismissed_until');
            }
        }
        
        // Check server-side session
        fetch('<?= base_url('newsletter/check-status') ?>')
            .then(response => response.json())
            .then(data => {
                if (!data.subscribed) {
                    // Show popup after 3 seconds
                    setTimeout(() => {
                        showPopup();
                    }, 3000);
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    function showPopup() {
        popup.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    window.closeNewsletterPopup = function() {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Store dismissal for 24 hours
        const dismissedUntil = new Date().getTime() + (24 * 60 * 60 * 1000); // 24 hours
        localStorage.setItem('newsletter_dismissed_until', dismissedUntil);
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
        
        const submitBtn = form.querySelector('.newsletter-submit');
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
                
                // Set localStorage to not show again permanently
                localStorage.setItem('newsletter_dont_show', 'true');
                
                // Remove temporary dismissal
                localStorage.removeItem('newsletter_dismissed_until');
                
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
                submitBtn.textContent = 'Subscribe';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.style.display = 'block';
            messageDiv.className = 'newsletter-message error';
            messageDiv.textContent = 'An error occurred. Please try again.';
            submitBtn.disabled = false;
            submitBtn.textContent = 'Subscribe';
        });
    });
    
    // Initialize
    checkSubscriptionStatus();
})();
function neverShowNewsletter() {
    // Set localStorage to never show again
    localStorage.setItem('newsletter_dont_show', 'true');
    
    // Remove temporary dismissal
    localStorage.removeItem('newsletter_dismissed_until');
    
    // Close popup
    const popup = document.getElementById('newsletterPopup');
    popup.style.display = 'none';
    document.body.style.overflow = 'auto';
    
    // Optional: Show a brief message
    alert('You will not see this popup again.');
}
</script>