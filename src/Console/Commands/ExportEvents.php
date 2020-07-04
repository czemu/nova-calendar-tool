<?php

namespace Czemu\NovaCalendarTool\Console\Commands;

use Illuminate\Console\Command;
use Czemu\NovaCalendarTool\Models\Event;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ExportEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-calendar:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export events from Google Calendar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = Event::where('google_calendar_id', NULL)->get();

        if (count($events))
        {
            foreach ($events as $event)
            {
                try
                {
                    $googleEvent = GoogleEvent::create([
                        'name' => $event->title,
                        'startDateTime' => $event->start,
                        'endDateTime' => $event->end
                    ]);

                    $event->update([
                        'google_calendar_id' => $googleEvent->googleEvent->id
                    ]);

                    $this->line('Exported event ID: '.$googleEvent->googleEvent->id);
                }
                catch (\Google_Service_Exception $e)
                {
                    $this->line('An error occurred while creating Google Calendar event (ID '.$event->id.'): '.$e->getMessage());
                }
            }
        }
        else
        {
            $this->line('There are no events with empty Google Calendar ID to export.');
        }
    }
}
