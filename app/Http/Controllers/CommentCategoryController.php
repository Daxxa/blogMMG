<?php

namespace App\Http\Controllers;

use App\CommentCategory;
use App\Forms\CommentCategoryForm;
use App\Rules\CountWords;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class CommentCategoryController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'author' => new CountWords,
            'contentt'=>'required'
        ]);
        $commentcategory = new CommentCategory();
        $commentcategory->fill(['author'=>mb_convert_case($request->author, MB_CASE_TITLE, "UTF-8"),'content'=>$request->contentt, 'category_id'=>$request->category_id]);

        $commentcategory->save();
        return response()->json([
            'message' => "TRUE",
            'data'=>$commentcategory
        ]);


    }


}
