<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostImage\StoreRequest;
use App\Http\Resources\PostImage\PostImageResource;
use App\Models\PostImage;

class PostImageController extends Controller
{
    public function store(StoreRequest $request)
    {
        $path = \Storage::disk('public')->put('/images', $request['image']);

        $postImage = PostImage::create([
                        'path' => $path,
                        'user_id' => auth()->id(),
                    ]);

        return new PostImageResource($postImage);
    }
}
