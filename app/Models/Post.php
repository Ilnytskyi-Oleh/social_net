<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = false;

    protected $with = ['image', 'likedUsers', 'repostedPost', 'user'];

    protected $withCount = [
        'likedUsers', 'comments'
    ];

    /**
     * @return HasOne
     */
    public function image(): HasOne
    {
        return $this->hasOne(PostImage::class, 'post_id', 'id')
            ->whereNotNull('post_id');
    }

    public function likedUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }


    /**
     * @param $posts
     * @return Post
     */
    public static function isLikedPosts($posts): mixed
    {

        $likeIds = LikedPost::where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        foreach ($posts as $post) {
            if (in_array($post->id, $likeIds)) {
                $post->is_liked = true;
            }
        }

        return $posts;
    }

    /**
     * @return BelongsTo
     */
    public function repostedPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id', 'id');
    }

    public function repostedPosts(): HasMany
    {
        return $this->hasMany(Post::class);
    }


    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }


    /**
     .

     * @return Attribute
     */
    protected function date(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->diffForHumans(),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
