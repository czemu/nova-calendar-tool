<?php

namespace DoxHunter\NovaCalendarTool\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ToolController
{
    public function __invoke(Request $request)
    {
        return Inertia::render('nova-calendar-tool');
    }
}
