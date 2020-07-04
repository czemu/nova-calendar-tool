<?php

namespace Czemu\NovaCalendarTool\Console\Commands;

use Illuminate\Console\Command;
use Czemu\NovaCalendarTool\Models\Event;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class ImportEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-calendar:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import events from Google Calendar';

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
        try
        {
            $googleEvents = GoogleEvent::get();

            if (count($googleEvents))
            {
                foreach ($googleEvents as $googleEvent)
                {
                    $event = Event::where('google_calendar_id', $googleEvent->id)->first();
                    $googleEvent = $googleEvent->googleEvent;

                    if (is_null($event))
                    {
                        Event::create([
                            'google_calendar_id' => $googleEvent->id,
                            'title' => ! empty($googleEvent->summary) ? $googleEvent->summary : 'Unnamed event',
                            'start' => ! empty($googleEvent->start->dateTime) ? $googleEvent->start->dateTime : $googleEvent->start->date,
                            'end' => ! empty($googleEvent->end->dateTime) ? $googleEvent->end->dateTime : $googleEvent->end->date
                        ]);

                        $this->line('Imported event ID: '.$googleEvent->id);
                    }
                    else
                    {
                        $this->line('Event ID: '.$googleEvent->id.' already exists, skipping.');
                    }
                }
            }
        }
        catch (\Google_Service_Exception $e)
        {
            $this->line('An error occurred while fetching events from Google Calendar: '.$e->getMessage());
        }
    }
}
