<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Page extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'pages';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',       // default, about, contact, organization
        'meta_title',
        'meta_description',
        'is_published',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Template constants
     */
    const TEMPLATE_DEFAULT = 'default';
    const TEMPLATE_ABOUT = 'about';
    const TEMPLATE_CONTACT = 'contact';
    const TEMPLATE_ORGANIZATION = 'organization';

    /**
     * Scope for published pages
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
