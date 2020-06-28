<?php

namespace Czemu\NovaCalendarTool\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Event extends Model
{
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime'
    ];

    protected $guarded = ['id'];

    public function validate($data, $scenario)
    {
        switch ($scenario)
        {
            case 'create':
            case 'update':
                $rules = [
                    'title' => 'required',
                    'start' => 'required|date',
                    'end' => 'required|date|after_or_equal:start'
                ];

                break;
        }

        return Validator::make($data, $rules);
    }

    public function scopeFilter($query, $data)
    {
        if ( ! empty($data['start']))
        {
            $query->where('start', '>=', $data['start']);
        }

        if ( ! empty($data['end']))
        {
            $query->where('end', '<=', $data['end']);
        }

        return $query;
    }
}