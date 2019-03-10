<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CommentCategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('author', 'text',[
                'attr' => ['placeholder' => 'Name and Surname','id'=>'author'],
                'rules'=>'required|min:3',
                'label_show'=>false
            ])
            ->add('contentt', 'textarea',[
                'attr' => ['placeholder' => 'Your comment','id'=>'contentt'],
                'rules'=>'required|min:3',
                'label_show'=>false

            ])
            ->add('ok','button',[
                'attr' => ['class' => 'btn btn-primary','id'=>'save'],
            ]);
    }
}
