<?php

namespace App\Form;

use App\Entity\Entree;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EntreeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class, array('label'=>'Date d\'entrees', 'attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            ->add('quantite',TextType::class, array('label'=>'Quantite acheter', 'attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            ->add('prix',TextType::class, array('label'=>'Prix Unitaire', 'attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            ->add('idProduit',entityType::class,array('class'=>Produit::class,'label'=>'Produit acheté','attr'=>array('require'=>'require','class'=>'form-control form-group border-dark text-dark')))
            ->add('Valider', SubmitType::class, array('attr'=>array('class'=>'btn btn-success form-group mt-3',)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entree::class,
        ]);
    }
}
