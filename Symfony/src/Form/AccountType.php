<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class)
        ->add('descr', TextType::class)
        ->add('languages', null, array(
           'required' => false,
           'multiple' => true,
           'expanded' => true,
        ))
        ->add('submit', SubmitType::class)
        ;
    }

   
}
?>