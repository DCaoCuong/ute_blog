<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'thumbnail',
        'images',
        'type',           // news, event, announcement, article
        'category_id',
        'department_id',
        'author_id',
        'status',         // draft, pending, published, archived
        'is_featured',
        'is_pinned',
        'views_count',
        'published_at',
        'event_date',
        'event_location',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'tags' => 'array',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'views_count' => 'integer',
            'published_at' => 'datetime',
            'event_date' => 'datetime',
        ];
    }

    /**
     * Post type constants
     */
    const TYPE_NEWS = 'news';
    const TYPE_EVENT = 'event';
    const TYPE_ANNOUNCEMENT = 'announcement';
    const TYPE_ARTICLE = 'article';

    /**
     * Post status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    /**
     * Get the author of the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category of the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the department of the post.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the comments for the post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * Scope for featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
