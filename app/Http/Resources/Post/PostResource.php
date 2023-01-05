<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image_url' => $this->image?->url,
            'user' => new UserResource($this->user),
            'date' => $this->date,
            'is_liked' => $this->is_liked ?? false,
            'liked_users_count' => $this->liked_users_count,
            'reposted_posts_count' => $this->repostedPost()->count(),
            'comments_count' => $this->comments_count,
            'reposted_post' => new RepostedPostResource($this->repostedPost)
        ];
    }
}
