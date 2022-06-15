<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRole',TextType::class, array('label'=>'La categorie du produit', 'attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            //->add('user',entityType::class,array('class'=>User::class,'choice_label' => 'nom','mapped' => false,'attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            //->add('users')
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group mt-3 ')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Role::class,
        ]);
    }
}
