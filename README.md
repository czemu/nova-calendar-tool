# Laravel Nova Calendar Tool

This is a package for [Laravel Nova](https://nova.laravel.com/) which allows you to create, update and delete events on the calendar. The calendar now features an enhanced month view where event titles are directly visible within each day, providing an at-a-glance overview of daily schedules. It also has a Google Calendar integration.

## Screeenshots

![Nova Calendar Tool - screen 1](https://paweldymek.com/projects/nova-calendar-tool/screen_1.png)
![Nova Calendar Tool - screen 2](https://paweldymek.com/projects/nova-calendar-tool/screen_2.png)
![Nova Calendar Tool - screen 3](https://paweldymek.com/projects/nova-calendar-tool/screen_3.png)

## Requirements

* PHP >= 7.1
* [Laravel](https://laravel.com/) application with [Laravel Nova](https://nova.laravel.com/) installed

## Installation

Install the package via composer:

```
composer require czemu/nova-calendar-tool
```

Publish the migration:
```
php artisan vendor:publish --provider='Czemu\NovaCalendarTool\ToolServiceProvider' --tag="migrations"
```

Run the migration:
```
php artisan migrate
```

Publish the config (optional):
```
php artisan vendor:publish --provider='Czemu\NovaCalendarTool\ToolServiceProvider' --tag="config"
```

Register the tool in the `tools` method of the `NovaServiceProvider`:
```
// app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \Czemu\NovaCalendarTool\NovaCalendarTool,
    ];
}
```

## Google Calendar Integration

This step is optional. If you want to synchronize your events with Google Calendar you have to publish the configuration file from [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar) package:

```
php artisan vendor:publish --provider="Spatie\GoogleCalendar\GoogleCalendarServiceProvider"
```

This will create the `config/google-calendar.php` file with the following content:

```
<?php

return [

    /*
     * Path to the json file containing the credentials.
     */
    'service_account_credentials_json' => storage_path('app/google-calendar/service-account-credentials.json'),

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'),
];
```

So next, you have to insert `GOOGLE_CALENDAR_ID=your_id` into the `.env` file (it's in the Google Calendar settings page) and the account credentials into the `storage/app/google-calendar/service-account-credentials.json` file (you can obtain it from Google API Console). Both of these things are explained [here](https://github.com/spatie/laravel-google-calendar#installation).

### Troubleshooting

**1. Error: `Call to undefined method App\NovaCalendar\EventCalendarProvider::setConfig() in CalendarController.php line 24`**

This error typically occurs when running `php artisan route:list` or when accessing routes that use the specified controller.

*   **Cause**: This error indicates that a class named `EventCalendarProvider` within your main Laravel application (likely located at `app/NovaCalendar/EventCalendarProvider.php` or a similar path within your `app` directory) is being used by a `CalendarController` (also in your application, e.g., `app/Http/Controllers/CalendarController.php`), and this `EventCalendarProvider` does not have the expected `setConfig()` method. This is often due to compatibility issues with newer versions of Laravel Nova (e.g., Nova 5.0+), which may have changed requirements for such provider classes.
*   **Solution**:
    *   Inspect your `app/NovaCalendar/EventCalendarProvider.php` (or similarly named provider class that your `CalendarController` uses).
    *   Ensure this class is compatible with your version of Laravel Nova. You may need to consult the Nova documentation or upgrade guides to see if a `setConfig()` method (or similar configuration handling) is required or has changed.
    *   This `czemu/nova-calendar-tool` package does **not** provide the `App\NovaCalendar\EventCalendarProvider` or the `CalendarController` mentioned in the error. The fix needs to be applied to your application's codebase.

**2. Error: `GET /nova/calendar 404 (Not Found)` when visiting the dashboard**

This error means that your application is trying to access a URL at `/nova/calendar`, but no route is defined for this specific path.

*   **Cause and Solution**:
    *   **Tool Path**: This `czemu/nova-calendar-tool` registers its user interface as a Nova tool. Nova tools are typically accessed via a path like `/nova/tools/your-tool-slug-name`. The specific slug is determined by how you register the tool in your application's `NovaServiceProvider.php` (usually in the `tools()` method). The navigation link provided by this tool (seen in the Nova sidebar) uses a Vue router named route, which should resolve to the correct Nova tool path.
    *   **API Endpoints**: The frontend component of this tool (`Tool.vue`) fetches event data from API endpoints prefixed with `/nova-vendor/nova-calendar-tool/` (e.g., `/nova-vendor/nova-calendar-tool/events`). These are correctly defined in this package.
    *   **Incorrect URL**: The `/nova/calendar` path is not a standard path generated or used by this tool for accessing its main interface or its API. The 404 error could arise from:
        *   A manual bookmark or link in your application (e.g., on a custom dashboard) that incorrectly points to `/nova/calendar`.
        *   A misconfiguration in your `NovaServiceProvider` when registering this tool, causing it or another part of Nova to expect a component at `/nova/calendar`.
        *   Another Nova tool or resource that is supposed to be at `/nova/calendar` but is missing or misconfigured.
    *   **Check**: Review how the `NovaCalendarTool` is registered in your `app/Providers/NovaServiceProvider.php`. Ensure you are accessing the tool via the path Nova generates for it in the sidebar, not by directly typing `/nova/calendar`. If you have custom dashboard items linking to the calendar, ensure they use the correct Nova routing mechanism or path.

Please ensure your main Laravel application and other Nova packages are updated and configured correctly for your version of Nova.

## Artisan Commands

### Export all events to Google Calendar

```php artisan nova-calendar:export```

### Import all events from Google Calendar

```php artisan nova-calendar:import```

## Credits

* [FullCalendar](https://fullcalendar.io/)
* [Laravel](https://laravel.com/)
* [Laravel Nova](https://nova.laravel.com/)
* [spatie/laravel-google-calendar](https://github.com/spatie/laravel-google-calendar)

## License

The MIT License (MIT). Please see the [LICENSE.md](LICENSE.md) file for more information.