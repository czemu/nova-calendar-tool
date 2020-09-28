# Laravel Nova Calendar Tool

This is a package for [Laravel Nova](https://nova.laravel.com/) which allows you to create, update and delete events on the calendar. It also has a Google Calendar integration.

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