<?php

namespace App\Http\Controllers;

use App\Category;
use App\CommentCategory;
use App\Forms\CategoryForm;
use App\Forms\CommentCategoryForm;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kris\LaravelFormBuilder\FormBuilder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = Category::paginate(15);

        return view('categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CategoryForm::class, [
            'method' => 'POST',
            'url' => route('categories.store')
        ]);
        return view('categories.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        } else{
            $category = new Category();
            $category->fill($request->all());
            $category->save();
            return redirect()->route('categories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category,FormBuilder $formBuilder)
    {

        $comments = CommentCategory::all()->where('category_id',$category->id)->sortBy('created_at');
        $form = $formBuilder->create(CommentCategoryForm::class,[
            'id'=>'commentform',
            'method'=>'POST',
        ]);
        $form->add('category_id','hidden',[
            'value'=>$category->id,
            'attr'=>['id'=>'category_id']
        ]);
        $posts = $this->PostsOfCategory($category);
        return view('categories.show', ['category'=>$category,'form'=>$form,'comments'=>$comments,'posts'=>$posts]);
    }
    public function PostsOfCategory(Category $category)
    {
        $posts=Post::all()->where('category_id',$category->id);
        return $posts;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CategoryForm::class, [
            'method' => 'PUT',
            'url' => route('categories.update',$category),
            'model'=>$category,
        ]);
        return view('categories.edit',['category'=>$category], compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Category $category
     * @param FormBuilder $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(CategoryForm::class);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        } else{

            $category->fill($request->all());
            $category->save();
            return redirect()->route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $category=Category::all()->find($request->category_id);
        $category->delete();

        return $data=$request->category_id;
    }
}
