<?php

namespace App\Forms;

use App\Category;
use Kris\LaravelFormBuilder\Form;

class PostForm extends Form
{
    public function buildForm()
    {
        $categories=Category::pluck('name','id')->toArray();
        $this
            ->add('name', 'text',[
                'attr' => ['placeholder' => 'Name'],
                'rules'=>'required|min:3'
            ])
            ->add('content', 'textarea',[
                'attr' => ['placeholder' => 'Content'],
                'rules'=>'required|min:3'

            ])
            ->add('category_id', 'select',[
                'choices' => $categories,
                'empty_value' => '=== Select category ===',
                'label'=>'Category',
                'rules'=>'required'

            ])
            ->add('file', 'file',[
                'rules'=>'file|max:2048'


            ])
            ->add('ok','submit',[
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }
}
