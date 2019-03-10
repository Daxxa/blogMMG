<?php

namespace App\Http\Controllers;

use App\CommentPost;
use App\Rules\CountWords;
use Illuminate\Http\Request;

class CommentPostController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'author' => new CountWords,
            'contentt' => 'required'
        ]);
        $commentpost = new CommentPost();
        $commentpost->fill(['author' => mb_convert_case($request->author, MB_CASE_TITLE, "UTF-8"), 'content' => $request->contentt, 'post_id' => $request->post_id]);

        $commentpost->save();
        return response()->json([
            'message' => "TRUE",
            'data' => $commentpost
        ]);
    }
}

