<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(){

        $posts = Post::where('user_id', auth()->id())->latest()->get();

        $posts = Post::isLikedPosts($posts);

        return PostResource::collection($posts);
    }

    public function feed()
    {
        $ids = auth()->user()->followings()->latest()->get()->pluck('id')->toArray();

        $likedPostIds = LikedPost::where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        $posts = Post::whereIn('user_id', $ids)
            ->whereNotIn('id', $likedPostIds)
            ->get();

        return PostResource::collection($posts);
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $imageId = $data['image_id'];
            unset($data['image_id']);

            $data['user_id'] = auth()->id();

            $post = Post::create($data);

            $this->processImage($post, $imageId);

            PostImage::clearStorage();

            DB::commit();
        } catch (\Exception $exception ) {
            DB::rollBack();

            return response()->json(['error' => $exception->getMessage()]);
        }

        return new PostResource($post);
    }

    private function processImage($post, $imageId)
    {
        if(isset($imageId)) {
            $image = PostImage::find($imageId);
            $image->update([
                'status' => true,
                'post_id' => $post->id,
            ]);
        }
    }
    public function toggleLike(Post $post) {
        $res = auth()->user()->likes()->toggle($post->id);
        $data['is_liked'] = count($res['attached']) > 0;
        $data['liked_users_count'] = $post->fresh()->liked_users_count;
        return $data;
    }
}
