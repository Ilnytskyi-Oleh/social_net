<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $guarded = false;

    protected $with = ['user', 'parent'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function date(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->diffForHumans(),
        );
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }
}
