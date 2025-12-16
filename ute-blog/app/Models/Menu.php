<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Menu extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'menus';

    protected $fillable = [
        'name',
        'location',       // header, footer, sidebar
        'items',          // JSON array of menu items
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
        ];
    }

    /**
     * Menu location constants
     */
    const LOCATION_HEADER = 'header';
    const LOCATION_FOOTER = 'footer';
    const LOCATION_SIDEBAR = 'sidebar';

    /**
     * Get menu by location
     */
    public static function getByLocation(string $location)
    {
        return static::where('location', $location)->first();
    }
}
