<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/maintenance', 'Home::maintenance');
$routes->get('/about-us', 'Home::aboutus');
$routes->get('/faq', 'Home::faq');
$routes->get('/testimonials', 'Home::testimonials');
$routes->get('/blog', 'Home::blog');
$routes->get('/videos', 'Home::videos');
$routes->get('/news', 'Home::news');
$routes->get('/blog_detail/(:any)', 'Home::blog_detail/$1');
$routes->get('/terms', 'Home::terms');
$routes->get('/privacy', 'Home::privacy');
$routes->get('/pricing', 'Home::pricing');
$routes->get('/how-it-works', 'Home::howitworks');
$routes->get('/provider/(:any)(/(:num))?', 'Providers::view_profile/$1/$3');
$routes->get('/provider_gallery/(:num)','Providers::view_gallery/$1');
$routes->get('/providers/set_session', 'Providers::set_session');
$routes->get('/providers', 'Providers::providers_list');
$routes->get('/listings/(:any)/(:num)/(:any)', 'Providers::view_profile/$1/$2');
$routes->get('/listings/(:any)', 'Providers::providers_list/$1');
$routes->get('/update_call_count/(:num)/(:any)', 'Home::update_call_count/$1/$2');
$routes->get('/update_share_count/(:num)/(:any)', 'Home::update_share_count/$1/$2');
$routes->get('/update_direction_count/(:num)', 'Home::update_direction_count/$1');
$routes->get('/providers/(:any)(/(:num))?', 'Providers::providers_list/$1/$3');
$routes->get('/contact', 'Home::contact');
$routes->get('/captains-club-request', 'Home::captains_club_request');
$routes->post('/submit-contact', 'Home::submit_contact');
$routes->post('/submit-captain', 'Home::submit_captain');
$routes->get('/confirm_mail', 'Providers::confirm_mail');
$routes->get('/welcome_mail', 'Providers::welcome_mail');
$routes->get('/reminder_mail', 'Providers::reminder_mail');
$routes->get('user-signup', 'Providerauth\ProviderRegister::index');
$routes->post('user-signup-post', 'Providerauth\ProviderRegister::provider_register_post');
$routes->post('check-email', 'Providerauth\ProviderRegister::check_email');	
$routes->get('plan', 'Providerauth\ProviderRegister::plan');
$routes->get('add-listing', 'Providerauth\ProviderDashboard::add_listing');	
$routes->get('my-listing', 'Providerauth\ProviderDashboard::my_listing');	
$routes->get('favorites', 'Providerauth\ProviderDashboard::favorites');	
$routes->get('analytics', 'Providerauth\ProviderDashboard::analytics');	
$routes->get('help', 'Providerauth\ProviderDashboard::help');	
$routes->post('product_delete', 'Providerauth\ProviderDashboard::product_delete');
$routes->post('change_plan_status', 'Providerauth\ProviderDashboard::change_plan_status');
$routes->post('product_status_change', 'Providerauth\ProviderDashboard::product_status_change');	
$routes->post('add-listing-post', 'Providerauth\ProviderRegister::product_add_post');
$routes->get('billing', 'Providerauth\ProviderDashboard::billing'); 
$routes->get('subscriptions', 'Providerauth\ProviderDashboard::subscriptions'); 
$routes->get("messages", 'Providerauth\ProviderDashboard::messages');
$routes->get('dashboard', 'Providerauth\ProviderDashboard::index');
$routes->get('account-settings', 'Providerauth\ProviderDashboard::account_settings');
$routes->get('login', 'Providerauth\ProviderLogin::index');
$routes->get('logout', 'Providerauth\ProviderLogin::Logout');
$routes->get('select-plan', 'Providerauth\ProviderRegister::select_plan');
$routes->get('listing-type', 'Providerauth\ProviderRegister::add_listing');	
$routes->get('checkout', 'Providerauth\ProviderDashboard::checkout');
$routes->post('checkout-post', 'Providerauth\ProviderDashboard::checkout_post');
$routes->get('thankyou', 'Providerauth\ProviderDashboard::thankyou'); 
$routes->post('favorites_add', 'Providerauth\ProviderDashboard::favorites_add'); 
$routes->post('remove_favorite', 'Providerauth\ProviderDashboard::remove_favorite');
$routes->get('renew_plan', 'Providerauth\ProviderDashboard::renew_plan');	 


$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {
    $routes->group("user", function ($routes) {
        $routes->get("/", "User::index", ["filter" => 'secure-api']);
        $routes->get("(:num)", "User::show/$1", ["filter" => 'secure-api']);
        $routes->post("create", "User::create", ["filter" => 'secure-api']);
        $routes->put("update/(:num)", "User::update/$1", ["filter" => 'secure-api']);
        $routes->delete("delete/(:num)", "User::delete/$1", ["filter" => 'secure-api']);
    });
});

$routes->get('cron/index(:any)', 'CronController::index/$1');
$routes->get('cron/send_confirmation_reminder_mail(:any)', 'CronController::send_confirmation_reminder_mail/$1');
$routes->get('cron/send_weekly_report_mail', 'CronController::send_weekly_report_mail');
$routes->get('cron/send_optimization_reminder_mail', 'CronController::send_optimization_reminder_mail');
$routes->get('cron/sendCCReminderEmail', 'CronController::sendCCReminderEmail');
$routes->get('cron/sendRecoveryEmail', 'CronController::sendRecoveryEmail');

$routes->group("auth", ["namespace" => "App\Controllers\Auth"], function ($routes) {
    $routes->get('login', 'Login::index');
    $routes->post('login-post', 'Login::admin_login_post');
    $routes->get('register', 'Register::index');
    $routes->post('register-post', 'Register::admin_register_post');
    $routes->get('forgot-password', 'ForgotPassword::index');
    $routes->post('forgot-password-post', 'ForgotPassword::forgot_password_post');
    $routes->get('reset-password', 'ResetPassword::index');
    $routes->post('reset-password-post', 'ResetPassword::reset_password_post');
    $routes->get('logout', 'Login::Logout');
    $routes->get("confirm", 'Register::confirm_email');
    $routes->get("connect-with-google", 'Login::connect_with_google');
    $routes->get("connect-with-github", 'Login::connect_with_github');
});

$routes->group("providerauth", ["namespace" => "App\Controllers\Providerauth"], function ($routes) {
    $routes->post('login-post', 'ProviderLogin::provider_login_post');
    $routes->post('get-states', 'ProviderRegister::get_states');	
    $routes->get("confirm", 'ProviderRegister::confirm_email');
    $routes->get('forgot-password', 'ProviderForgotPassword::index');
    $routes->post('forgot-password-post', 'ProviderForgotPassword::forgot_password_post');
    $routes->get('reset-password', 'ProviderResetPassword::index');
    $routes->post('reset-password-post', 'ProviderResetPassword::reset_password_post');
	$routes->get('get-locations', 'ProviderRegister::get_location');
    $routes->get('dashboard1', 'ProviderDashboard::index1');
	$routes->get('groomer_dashboard', 'ProviderDashboard::groomer_dashboard');
    $routes->get('view-profile', 'ProviderDashboard::view_profile');
    $routes->get('edit-profile', 'ProviderDashboard::edit_profile');
    $routes->post('edit-profile-post', 'ProviderDashboard::edit_profile_post');
    $routes->post('save_report', 'ProviderDashboard::save_report');
    $routes->get('photos', 'ProviderDashboard::photos');
    $routes->post('photos_post', 'ProviderDashboard::photos_post');
    $routes->post('upload_profile_photo', 'ProviderDashboard::upload_profile_photo');
    $routes->post('photosedit_post', 'ProviderDashboard::photosedit_post');
    $routes->post('photos_delete', 'ProviderDashboard::photos_delete');
    $routes->get('upgrade', 'ProviderDashboard::upgrade');
    $routes->post('get-categories-skills', 'ProviderDashboard::get_categories_skills');
    $routes->post('get-category-offering', 'ProviderDashboard::get_category_offering');
    $routes->post('edit-account-post', 'ProviderDashboard::edit_account_post');
    $routes->post('edit-password-post', 'ProviderDashboard::edit_password_post');
    $routes->get('crop', 'ProviderDashboard::crop'); 
    $routes->get('billing-cancel/(:any)', 'ProviderDashboard::billing_cancel/$1');
    $routes->get('billing-cancel-refund/(:any)', 'ProviderDashboard::billing_cancel_refund/$1');
    $routes->get('update-card', 'ProviderDashboard::update_card');
    $routes->post('update-card-post', 'ProviderDashboard::update_card_post');
    $routes->post('set-location', 'ProviderRegister::set_location');
	$routes->post('get-location-id', 'ProviderRegister::get_location_id');
    $routes->get('payment_history', 'ProviderDashboard::payment_history');
    $routes->post('get-payment-history', 'ProviderDashboard::payment_history_admin');
    $routes->post('paypal-success', 'ProviderDashboard::paypal_success');
    $routes->post('stripe_set_default', 'ProviderDashboard::stripe_set_default');
    $routes->post('stripe_delete_card', 'ProviderDashboard::stripe_delete_card');
    $routes->post('check-email-verified', 'ProviderDashboard::check_email_verified');
	$routes->post('update_hiring_status', 'ProviderDashboard::update_hiring_status');
});

$routes->group("admin", ["namespace" => "App\Controllers\Admin"], function ($routes) {
    $routes->get('blocked', 'Dashboard::Blocked');
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('report-profiles', 'UserManagement::report_profiles');
    $routes->post('report-profiles/bulk-delete-post', 'UserManagement::bulk_delete_report_post');
	$routes->get('groups/index/(:any)', 'FieldGroup::index/$1'); 
	$routes->post('fields_group/saved_fields_group_post', 'FieldGroup::saved_fields_group_post');
	$routes->post('fields_group/delete_fields_group_post', 'FieldGroup::delete_fields_group_post');
	$routes->post('fields_group/update_order_post', 'FieldGroup::update_order_post');
	$routes->post('fields/update_order_post', 'Fields::update_order_post');
	$routes->post('fields/update_filter_order_post', 'Fields::update_filter_order_post');
    $routes->get('users', 'UserManagement::users');
    $routes->get('add-user', 'UserManagement::add_user');
    $routes->post('add_user_post', 'UserManagement::add_user_post');
    $routes->get('edit-user/(:num)/(:num)', 'UserManagement::edit_user/$1/$2');
    $routes->post('edit_user_post', 'UserManagement::edit_user_post');
    $routes->post('delete_user_post', 'UserManagement::delete_user_post');
	
	$routes->group('listings',  function ($routes) {
        $routes->get('/', 'UserManagement::listings');
        $routes->get('all', 'UserManagement::listings');
        $routes->get('add', 'UserManagement::add_listing');
        $routes->get('messages', 'UserManagement::provider_messages');
        $routes->get('sales', 'UserManagement::sales');
        $routes->get('dynamic-fields', 'Fields::index');
        $routes->get('filter-fields', 'Fields::filter_fields');
        $routes->get('change_plan', 'UserManagement::change_plan');
        $routes->post('change_plan_post', 'UserManagement::change_plan_post');
	});	
	
    $routes->group('providers',  function ($routes) {
        $routes->get('administrators', 'UserManagement::administrators', ["filter" => 'check-admin']);
        $routes->get('listings', 'UserManagement::listings');
        $routes->get('add-provider', 'UserManagement::add_user');
        $routes->get('edit-provider/(:num)/(:num)', 'UserManagement::edit_user/$1/$2');
        $routes->post('add_user_post', 'UserManagement::add_user_post');
        $routes->post('edit_user_post', 'UserManagement::edit_user_post');
        $routes->post('delete_user_post', 'UserManagement::delete_user_post');
        $routes->post('ban_user_post', 'UserManagement::ban_user_post');
        $routes->post('change_user_role_post', 'UserManagement::change_user_role_post');
        $routes->post('confirm_user_email', 'UserManagement::confirm_user_email');
        $routes->get('photos', 'UserManagement::photos');
        $routes->post('photos_post', 'UserManagement::photos_post');
        $routes->post('photos_delete', 'UserManagement::photos_delete');
    });

    $routes->group("role-management", function ($routes) {
        $routes->get('', 'RoleManagement::index');
        $routes->get('permission', 'RoleManagement::Permissions');
        $routes->post('add-role-post', 'RoleManagement::add_role_post');
        $routes->post('edit-role-post', 'RoleManagement::edit_role_post');
        $routes->post('delete-role-post', 'RoleManagement::delete_role_post');
        $routes->post('change-menu-category-permission', 'RoleManagement::changeMenuCategoryPermission');
        $routes->post('change-menu-permission', 'RoleManagement::changeMenuPermission');
        $routes->post('change-submenu-permission', 'RoleManagement::changeSubMenuPermission');
    });
    $routes->group("menu-management", function ($routes) {
        $routes->get('', 'MenuManagement::index');

        $routes->post('add-menu-category-post', 'MenuManagement::add_menu_category_post');
        $routes->post('edit-menu-category-post', 'MenuManagement::edit_menu_category_post');
        $routes->post('delete-menu-category-post', 'MenuManagement::delete_menu_category_post');

        $routes->post('add-menu-post', 'MenuManagement::add_menu_post');
        $routes->post('edit-menu-post', 'MenuManagement::edit_menu_post');
        $routes->post('delete-menu-post', 'MenuManagement::delete_menu_post');

        $routes->post('add-submenu-post', 'MenuManagement::add_submenu_post');
        $routes->post('edit-submenu-post', 'MenuManagement::edit_submenu_post');
        $routes->post('delete-submenu-post', 'MenuManagement::delete_submenu_post');
    });

    $routes->group('language-settings', function ($routes) {
        $routes->get('', 'Languages::index');
        $routes->get('edit-language/(:num)', 'Languages::edit_language/$1');
        $routes->get('translations/(:num)', 'Languages::translations/$1');
        $routes->get('search-phrases/(:num)', 'Languages::search_phrases/$1');

        $routes->post('add-language-post', 'Languages::add_language_post');
        $routes->post('delete-language-post', 'Languages::delete_language_post');
        $routes->post('language-edit-post', 'Languages::language_edit_post');
        $routes->post('set-language-post', 'Languages::set_language_post');
        $routes->post('update-translation-post', 'Languages::update_translation_post');
        $routes->post('add-translation-post', 'Languages::add_translations_post');
    });

    $routes->group('settings', function ($routes) {
        $routes->get('', 'GeneralSettings::index');
        $routes->get('general', 'GeneralSettings::index');
        $routes->get('email', 'GeneralSettings::email_settings', ["filter" => 'check-admin']);
        $routes->get('social', 'GeneralSettings::social_settings', ["filter" => 'check-admin']);
        $routes->get('visual', 'GeneralSettings::visual_settings', ["filter" => 'check-admin']);
        $routes->get('cache-system', 'GeneralSettings::cache_system_settings', ["filter" => 'check-admin']);

        $routes->post('settings-post', 'GeneralSettings::settings_post');
        $routes->post('maintenance-mode-post', 'GeneralSettings::maintenance_mode_post');
        $routes->post('recaptcha-settings-post', 'GeneralSettings::recaptcha_settings_post');
    });

     $routes->group('generalsettings', function ($routes) {
       $routes->post('email_settings_post', 'GeneralSettings::email_settings_post');
    });

    $routes->group('profile', function ($routes) {
        $routes->get('', 'Profile::index');
        $routes->get('address-information', 'Profile::address_information');
        $routes->get('change-password', 'Profile::change_password');
        $routes->get('delete-account', 'Profile::delete_account');
    });

    $routes->group('locations', ["namespace" => "App\Controllers\Admin\Locations"], ["filter" => 'check-admin'], function ($routes) {
        $routes->get('county', 'County::index');
        $routes->post('county/saved-county-post', 'County::saved_county_post');
        $routes->post('county/delete-county-post', 'County::delete_county_post');
        $routes->post('county/bulk-delete-county-post', 'County::bulk_delete_county_post');
        $routes->post('county/activate-inactivate-countries', 'County::activate_inactivate_countries');
        $routes->get('state', 'State::index');
        $routes->post('state/saved-state-post', 'County::saved_state_post');
        $routes->post('state/delete-state-post', 'County::delete_state_post');
        $routes->get('city', 'City::index');
        $routes->post('city/saved-city-post', 'County::saved_city_post');
        $routes->post('city/delete-city-post', 'County::delete_city_post');
    });

    $routes->group('categories', function ($routes) {
        $routes->get('categories', 'Categories::index');
        $routes->post('categories/saved_categories_post', 'Categories::saved_categories_post');
        $routes->post('categories/delete_categories_post', 'Categories::delete_categories_post');  
        $routes->get('skills/(:any)', 'Skills::index/$1');      
        $routes->post('skills/saved_skills_post', 'Skills::saved_skills_post');
        $routes->post('skills/delete_skills_post', 'Skills::delete_skills_post'); 
    });
	
	$routes->group('sub-categories', function ($routes) {		 
        $routes->get('', 'Categories::sub_categories'); 
        $routes->post('saved_sub_categories_post', 'Categories::saved_sub_categories_post'); 
        $routes->post('delete_categories_post', 'Categories::delete_sub_categories_post'); 
	});
		
    $routes->group('blog', function ($routes) {
        $routes->get('blog', 'Blog::index');
        $routes->get('add-blog', 'Blog::add_blog');
        $routes->get('edit-blog/(:num)', 'Blog::edit_blog/$1');
        $routes->post('add_blog_post', 'Blog::add_blog_post');
        $routes->post('edit_blog_post', 'Blog::edit_blog_post');
        $routes->post('delete_blog_post', 'Blog::delete_blog_post');
    });
	
    $routes->group('support', function ($routes) {
        $routes->get('support', 'Support::index');
        $routes->get('add-support', 'Support::add_support');
        $routes->get('edit-support/(:num)', 'Support::edit_support/$1');
        $routes->post('add_support_post', 'Support::add_support_post');
        $routes->post('edit_support_post', 'Support::edit_support_post');
        $routes->post('delete_support_post', 'Support::delete_support_post');
    });
    
    $routes->group('testimonial', function ($routes) {
        $routes->get('testimonial', 'Testimonial::index');
        $routes->get('add-testimonial', 'Testimonial::add_testimonial');
        $routes->get('edit-testimonial/(:num)', 'Testimonial::edit_testimonial/$1');
        $routes->post('add_testimonial_post', 'Testimonial::add_testimonial_post');
        $routes->post('edit_testimonial_post', 'Testimonial::edit_testimonial_post');
        $routes->post('delete_testimonial_post', 'Testimonial::delete_testimonial_post');
    });
	
    $routes->group('video', function ($routes) {
        $routes->get('video', 'Video::index');
        $routes->get('add-video', 'Video::add_video');
        $routes->get('edit-video/(:num)', 'Video::edit_video/$1');
        $routes->post('add_video_post', 'Video::add_video_post');
        $routes->post('edit_video_post', 'Video::edit_video_post');
        $routes->post('delete_video_post', 'Video::delete_video_post');
    });
	
    $routes->group('seo', function ($routes) {
        $routes->get('seo', 'Seo::index');
        $routes->get('add-seo', 'Seo::add_seo');
        $routes->get('edit-seo/(:num)', 'Seo::edit_seo/$1');
        $routes->post('add_seo_post', 'Seo::add_seo_post');
        $routes->post('edit_seo_post', 'Seo::edit_seo_post');
        $routes->post('delete_seo_post', 'Seo::delete_seo_post');
    });
	
    $routes->group('emailtemplates',  function ($routes) {
        $routes->get('list-emailtemplates', 'EmailTemplates::emailtemplates');
        $routes->get('add-emailtemplate', 'EmailTemplates::add_emailtemplate');
        $routes->get('edit-emailtemplate/(:num)', 'EmailTemplates::edit_emailtemplate/$1');
        $routes->post('add_emailtemplate_post', 'EmailTemplates::add_emailtemplate_post');
        $routes->post('edit_emailtemplate_post', 'EmailTemplates::edit_emailtemplate_post');
        $routes->post('delete_emailtemplate_post', 'EmailTemplates::delete_emailtemplate_post');
    });

     $routes->group('emails',  function ($routes) {
        $routes->get('list-emails', 'Emails::emails');
        $routes->get('send-email', 'Emails::send_email');
        $routes->post('send_email_post', 'Emails::send_email_post');
    });
	
	$routes->group('contacts', function ($routes) {
        $routes->get('contacts', 'Contacts::index');      
    });
    
    $routes->group('captains', function ($routes) {    
        $routes->get('captains', 'Contacts::index');    
    });
	
	$routes->group('subscription', function ($routes) {
        $routes->get('', 'Subscription::index');
        $routes->get('add-subscription', 'Subscription::add_subscription');
        $routes->get('edit-subscription/(:num)', 'Subscription::edit_subscription/$1');
        $routes->post('add_subscription_post', 'Subscription::add_subscription_post');
        $routes->post('edit_subscription_post', 'Subscription::edit_subscription_post');
        $routes->post('delete_subscription_post', 'Subscription::delete_subscription_post');
    });

});

$routes->post('vr-run-internal-cron', 'Common::run_internal_cron');
$routes->post("vr-switch-mode", 'Common::switch_visual_mode');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
