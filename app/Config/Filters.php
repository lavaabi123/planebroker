<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'isLoggedIn'     => \App\Filters\Authentication::class,
        'isGranted'     => \App\Filters\Authorization::class,
        'check-admin' => \App\Filters\CheckAdmin::class,
        'isMaintenance' => \App\Filters\Maintenance::class,
        'secure-api'     => \App\Filters\SecureAPI::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            // 'honeypot',
            'csrf' => ['except' => ['vr-run-internal-cron','Providerauth/*','Providersearch/*','submit-contact','contact/*', 'api/*', 'emails/*','common/*','cron/*','check-email']],
            // 'invalidchars',
            'isLoggedIn'    => ['except' => ['/', 'Auth/*','Providerauth/*','Providersearch/*','provider/*','provider_gallery/*','providers','providers/*','listings/*', 'api/*', 'blocked', 'maintenance','about-us','faq','update_call_count/*','update_direction_count/*','pricing','blog','blog_detail/*','testimonials','contact','submit-contact','terms','privacy','how-it-works','find-a-provider','common/send_message_to_provider','cron/*','welcome_mail','confirm_mail','reminder_mail','common/getProfileViews','user-signup','user-signup-post','check-email']],
            'isGranted'     => ['except' => ['/', 'Auth/*', 'Providerauth/*','Providersearch/*','provider/*','provider_gallery/*','providers','providers/*','listings/*','api/*', 'blocked', 'maintenance','about-us','faq','update_call_count/*','update_direction_count/*','pricing','blog','blog_detail/*','testimonials','contact','submit-contact','terms','privacy','how-it-works','find-a-provider','common/send_message_to_provider','cron/*','welcome_mail','confirm_mail','reminder_mail','common/getProfileViews']],
            'isMaintenance' => ['except' => ['Auth/*', 'api/*','Providerauth/*','Providersearch/*','provider/*','provider_gallery/*','providers','providers/*','listings/*', 'blocked', 'admin/*', 'maintenance','about-us','faq','update_call_count/*','update_direction_count/*','pricing','blog','blog_detail/*','testimonials','contact','submit-contact','terms','privacy','how-it-works','find-a-provider','common/send_message_to_provider','cron/*','welcome_mail','confirm_mail','reminder_mail','common/getProfileViews']],
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
