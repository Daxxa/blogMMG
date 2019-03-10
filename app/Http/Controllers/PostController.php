<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommentPost;
use App\Forms\CommentCategoryForm;
use App\Forms\PostForm;
use App\Post;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category,FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'POST',
            'url' => route('posts.store',[$category])
        ]);
        return view('posts.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder, Category $category)
    {
        $form = $formBuilder->create(PostForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        } else{
            $post = new Post();
            $post->fill($request->all());
            if($request->file('file') != null) {
                $path = $request->file('file')->store('uploads', 'public');
                $post->file = $path;
            }
            $post->save();
            return redirect()->route('posts.show',[$category,$post->id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Post $post,FormBuilder $formBuilder)
    {
        $comments = CommentPost::all()->where('post_id',$post->id)->sortBy('created_at');
        $form = $formBuilder->create(CommentCategoryForm::class,[
            'id'=>'commentform',
            'method'=>'POST',
        ]);
        $form->add('post_id','hidden',[
            'value'=>$post->id,
            'attr'=>['id'=>'post_id']
        ]);

        return view('posts.show',['category'=>$category,'post'=>$post,'comments'=>$comments,'form'=>$form]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Post $post, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PostForm::class, [
            'method' => 'PUT',
            'url' => route('posts.update',['category'=>$category,'post'=>$post]),
            'model'=> $post
        ]);
        return view('posts.edit',['category'=>$category,'post'=>$post], compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Category $category, Post $post, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(PostForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        } else {

            $post->fill($request->all());
            if ($request->file('file') != null) {
                $path = $request->file('file')->store('uploads', 'public');
                $post->file = $path;
            }
            $post->save();
            return redirect()->route('posts.show', ['category' => $category, 'post' => $post]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Post $post)
    {
        $post->delete();
        return redirect()->route('categories.show',['category'=>$category]);
    }
}
