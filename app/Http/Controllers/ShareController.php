<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    //

    public function post($id)
    {
        $post = Post::findOrFail($id);

        return response()->view('share.post', [
            'post' => $post
        ]);
    }
}
