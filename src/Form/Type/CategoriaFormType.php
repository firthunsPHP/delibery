<?php

namespace App\Form\Type;

use App\Entity\Categoria;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriaFormType extends AbstractType
{
    // buidForm-> se Encara de comprobar que este to.do Ok
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('categoria', TextType::class);

    }

    // definir a que objeto hace referencia
    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class'=> Categoria::class
       ]);
    }


    public function  getBlockPrefix()
    {
        return '';
    }


    public function  getName(){
        return '';
    }
}