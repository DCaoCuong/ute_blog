<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'departments';

    protected $fillable = [
        'name',
        'slug',
        'type',           // faculty, office, center
        'parent_id',
        'description',
        'content',        // Rich content for department page
        'logo',
        'banner',
        'contact_email',
        'contact_phone',
        'address',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    /**
     * Department type constants
     */
    const TYPE_FACULTY = 'faculty';     // Khoa
    const TYPE_OFFICE = 'office';       // Phòng ban
    const TYPE_CENTER = 'center';       // Trung tâm

    /**
     * Get the parent department.
     */
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    /**
     * Get the child departments.
     */
    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    /**
     * Get the users (members) of this department.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the posts from this department.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
