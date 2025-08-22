<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use App\Services\NotificationService;
use Config\Services;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function () {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static function ($buffer) {
            return $buffer;
        });
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});

Events::on('form:captain_submitted', static function (array $payload) {
    Services::notificationService()->create(
        type: 'form.captain',
        title: 'Captain form request',
        message: "{$payload['name']} submitted a captain form.",
        link: base_url('admin/captains'), // or your route
        data: $payload,
        recipients: 'admins',
        level: 'info'
    );
});

Events::on('form:contact_submitted', static function (array $payload) {
    Services::notificationService()->create(
        type: 'form.contact',
        title: 'Contact form request',
        message: "{$payload['name']} submitted a message.",
        link: base_url('admin/contacts'), // or your route
        data: $payload,
        recipients: 'admins',
        level: 'info'
    );
});

Events::on('user:registered', static function (array $payload) {
    Services::notificationService()->create(
        type: 'user.registered',
        title:'New user registered',
        message: "User: {$payload['email']}",
        link: base_url('admin/users'),
        data: $payload,
        recipients: 'admins',
        level: 'success'
    );
});

Events::on('listing:created', static function (array $payload) {
    Services::notificationService()->create(
        type:'listing.created',
        title:'New listing added',
        message:"{$payload['title']} was added.",
        link: base_url('admin/listings/all'),
        data: $payload,
        recipients: 'admins',
        level: 'info'
    );
});

Events::on('subscription:created', static function (array $payload) {
    Services::notificationService()->create(
        type:'subscription.created',
        title:'New subscription',
        message:"Plan: {$payload['plan']} by {$payload['email']}",
        link: base_url('admin/listings/sales'),
        data: $payload,
        recipients: 'admins',
        level: 'success'
    );
});