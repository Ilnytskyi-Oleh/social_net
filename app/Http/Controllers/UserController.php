<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StatRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();

        $followingsIds = SubscriberFollowing::where('subscriber_id', auth()->id())
            ->get('following_id')->pluck('following_id')->toArray();

        foreach ($users as $user) {
            if (in_array($user->id, $followingsIds)) {
                $user->is_followed = true;
            }
        }
        return UserResource::collection($users);
    }

    public function post(User $user)
    {
        $posts = $user->posts()->latest()->get();

        $posts = Post::isLikedPosts($posts);

        return PostResource::collection($posts);
    }

    public function toggleFollowing(User $user) {
        $res = auth()->user()->followings()->toggle($user->id);

        $data['is_followed'] = count($res['attached']) > 0;
        return $data;
    }

    public function getStats(StatRequest $request)
    {
        $data = $request->validated();

        $userId = $data['id'] ?? $data['id'] = auth()->id();

        $result['subscribers_count'] = SubscriberFollowing::where('following_id', $userId)->count();
        $result['followings_count'] = SubscriberFollowing::where('subscriber_id', $userId)->count();
//        $result['likes_count'] = LikedPost::where('user_id', $userId)->count();

        $postIds = Post::where('user_id', $userId)->get('id')->pluck('id')->toArray();
        $result['likes_count'] = LikedPost::whereIn('post_id', $postIds)->count();
        $result['posts_count'] = count($postIds);
        return response()->json(['data' => $result]);
    }
}
