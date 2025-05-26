<?php

namespace DoxHunter\NovaCalendarTool;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Laravel\Nova\Menu\MenuItem;
use Illuminate\Http\Request;

class NovaCalendarTool extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-calendar-tool', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-calendar-tool', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-calendar-tool::navigation');
    }

    /**
     * Authorize a user to access this tool.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorize(\Illuminate\Http\Request $request)
    {
        return true;
    }

    /**
     * Get the menu representation for the tool.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Nova\Menu\MenuItem|array
     */
    public function menu(Request $request)
    {
        return MenuItem::make('Calendar')

            ->path('/nova-calendar-tool');

    }
}
