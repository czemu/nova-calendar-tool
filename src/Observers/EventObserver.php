<?php

namespace Czemu\NovaCalendarTool\Observers;

use Czemu\NovaCalendarTool\Models\Event;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class EventObserver
{
    /**
     * Handle the event "created" event.
     *
     * @param  \Czemu\NovaCalendarTool\Models\Event $event
     * @return void
     */
    public function created(Event $event)
    {
        $googleEvent = GoogleEvent::create([
            'name' => $event->title,
            'startDateTime' => $event->start,
            'endDateTime' => $event->end
        ]);

        if ( ! empty($googleEvent->googleEvent->id))
        {
            $event->update([
                'google_calendar_id' => $googleEvent->googleEvent->id
            ]);
        }
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \Czemu\NovaCalendarTool\Models\Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        if ( ! empty($event->google_calendar_id))
        {
            $googleEvent = GoogleEvent::find($event->google_calendar_id);

            if ( ! empty($googleEvent))
            {
                $googleEvent->update([
                    'name' => $event->title,
                    'startDateTime' => $event->start,
                    'endDateTime' => $event->end
                ]);
            }
        }
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \Czemu\NovaCalendarTool\Models\Event $event
     * @return void
     */
    public function deleted(Event $event)
    {
        if ( ! empty($event->google_calendar_id))
        {
            $googleEvent = GoogleEvent::find($event->google_calendar_id);

            if ( ! empty($googleEvent))
            {
                $googleEvent->delete();
            }
        }
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \Czemu\NovaCalendarTool\Models\Event $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \Czemu\NovaCalendarTool\Models\Event $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
