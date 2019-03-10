<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text',[
                'attr' => ['placeholder' => 'Name'],
                'rules'=>'required|min:3'
            ])
            ->add('description', 'textarea',[
                'attr' => ['placeholder' => 'Description'],
                'rules'=>'required|min:3'

            ])
            ->add('ok','submit',[
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }
}
