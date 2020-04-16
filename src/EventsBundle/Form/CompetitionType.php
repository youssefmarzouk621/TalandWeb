<?php

namespace EventsBundle\Form;

use EventsBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CompetitionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('namecomp')
                ->add('desccomp')
                ->add('nbrmaxspec')
                ->add('nbrmaxpar')
                ->add('location')
                ->add('lat', null, array('label' => false))
                ->add('lng', null, array('label' => false))
                ->add('startingdate')
                ->add('endingdate')
                ->add('pricecomp')
                ->add('idcat',EntityType::class, array(
                    'class'=>Category::class,
                    'choice_label'=>'name',
                    'multiple'=>false))
                ->add('imageFile', VichImageType::class)
                ->add('Valider',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventsBundle\Entity\Competition'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventsbundle_competition';
    }


}
