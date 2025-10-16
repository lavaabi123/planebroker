<!-- Newsletter Popup -->
<div id="newsletterPopup" class="newsletter-popup">
    <div class="newsletter-popup-content">
        <button class="newsletter-close" onclick="closeNewsletterPopup()">&times;</button>
        <div class="newsletter-header">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Stay updated with our latest news and updates</p>
        </div>
        <form id="newsletterForm" class="newsletter-form">
            <div class="form-group">
                <input type="email" name="email" id="newsletter-email" placeholder="Email Address *" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="first_name" id="newsletter-first-name" placeholder="First Name">
                </div>
                <div class="form-group">
                    <input type="text" name="last_name" id="newsletter-last-name" placeholder="Last Name">
                </div>
            </div>
            <button type="submit" class="newsletter-submit">Subscribe</button>
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
}

.newsletter-popup-content {
    position: relative;
    background-color: #fff;
    margin: 5% auto;
    padding: 40px;
    width: 90%;
    max-width: 500px;
    border-radius: 12px;
    box-shadow: 0 5px 30px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.4s ease;
}

.newsletter-close {
    position: absolute;
    right: 15px;
    top: 15px;
    font-size: 32px;
    font-weight: bold;
    color: #aaa;
    background: none;
    border: none;
    cursor: pointer;
    line-height: 1;
    padding: 0;
    width: 32px;
    height: 32px;
}

.newsletter-close:hover {
    color: #000;
}

.newsletter-header {
    text-align: center;
    margin-bottom: 30px;
}

.newsletter-header h2 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 28px;
}

.newsletter-header p {
    margin: 0;
    color: #666;
    font-size: 16px;
}

.newsletter-form .form-group {
    margin-bottom: 15px;
}

.newsletter-form .form-row {
    display: flex;
    gap: 15px;
}

.newsletter-form input {
    width: 100%;
    padding: 14px;
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

.newsletter-submit {
    width: 100%;
    padding: 15px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.newsletter-submit:hover {
    background-color: #45a049;
}

.newsletter-submit:disabled {
    background-color: #ccc;
    cursor: not-allowed;
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
        font-size: 24px;
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
</style>
<script>
// Newsletter Popup Logic
(function() {
    const popup = document.getElementById('newsletterPopup');
    const form = document.getElementById('newsletterForm');
    const messageDiv = document.querySelector('.newsletter-message');
    
    // Check if user has already subscribed
    function checkSubscriptionStatus() {
        const dontShowAgain = localStorage.getItem('newsletter_dont_show');
        if (dontShowAgain) {
            return;
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
    }
    
    // Close popup when clicking outside
    popup.addEventListener('click', function(e) {
        if (e.target === popup) {
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
                
                // Set localStorage to not show again
                localStorage.setItem('newsletter_dont_show', 'true');
                
                // Close popup after 2 seconds
                setTimeout(() => {
                    closeNewsletterPopup();
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
</script>