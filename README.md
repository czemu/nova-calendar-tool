# Laravel Nova Calendar Tool

> **Status – Updated for Nova 5:** Basic functionality (create, update, delete events & Google Calendar sync) was verified on **Laravel Nova 5.0** as of **May 2025**.

This package for [Laravel Nova](https://nova.laravel.com/) lets you manage calendar events directly from your Nova admin panel, with optional Google Calendar synchronisation.

## Screenshots

![Nova Calendar Tool – screen 1](https://paweldymek.com/projects/nova-calendar-tool/screen_1.png)  
![Nova Calendar Tool – screen 2](https://paweldymek.com/projects/nova-calendar-tool/screen_2.png)  
![Nova Calendar Tool – screen 3](https://paweldymek.com/projects/nova-calendar-tool/screen_3.png)

## Requirements

* PHP >= 8.2  
* Laravel application with **Laravel Nova ^5.0** installed (tested on 5.0.0)  
* This version of the tool supports Vue 3 and uses Nova’s Inertia-powered pages.  
* Key front-end dependencies such as `vue`, `laravel-mix`, and `@fullcalendar/vue3` have been updated.

## Version Compatibility

This release of **`doxhunter/nova-calendar-tool`** targets **Laravel Nova 5.x and newer**.  (based on czemu package)
If you are using Laravel Nova 4.x or earlier (1.x, 2.x, or 3.x), please install a release of this tool prior to the version that introduced Nova 5 support (e.g. v3.0.0).

## Installation

Install the package via Composer:

    composer require doxhunter/nova-calendar-tool

Publish the migration:

    php artisan vendor:publish --provider="DoxHunter\NovaCalendarTool\ToolServiceProvider" --tag="migrations"

Run the migration:

    php artisan migrate

Publish the config (optional):

    php artisan vendor:publish --provider="DoxHunter\NovaCalendarTool\ToolServiceProvider" --tag="config"

Register the tool in the `tools` method of the `NovaServiceProvider`:

    // app/Providers/NovaServiceProvider.php
    // ...
    public function tools()
    {
        return [
            // ...
            new \DoxHunter\NovaCalendarTool\NovaCalendarTool,
        ];
    }

After registration, you can access the calendar at `/nova/nova-calendar-tool` within your Nova panel.

## Google Calendar Integration (Optional)

To synchronise your events with Google Calendar, publish the configuration file from the `spatie/laravel-google-calendar` package:

    php artisan vendor:publish --provider="Spatie\GoogleCalendar\GoogleCalendarServiceProvider"

This creates `config/google-calendar.php` with the following content:

    <?php

    return [
        /*
         * Path to the JSON file containing the credentials.
         */
        'service_account_credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),

        /*
         * The ID of the Google Calendar that will be used by default.
         */
        'calendar_id' => env('GOOGLE_CALENDAR_ID'),
    ];

Next, set `GOOGLE_CALENDAR_ID=your_id` in your `.env` file (you’ll find the ID in your Google Calendar settings) and place your service-account credentials JSON at `storage/app/google-calendar/service-account-credentials.json`. Both steps are explained in the package documentation.

## Artisan Commands

### Export all events to Google Calendar

    php artisan nova-calendar:export

### Import all events from Google Calendar

    php artisan nova-calendar:import

## Credits

* [FullCalendar](https://fullcalendar.io/)
* [Laravel](https://laravel.com/)
* [Laravel Nova](https://nova.laravel.com/)
* [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar)

## License

The MIT License (MIT). See the `LICENSE.md` file for details.

---

*Package originally based on the **czemu** packages; namespaces have been migrated to **doxhunter***.
