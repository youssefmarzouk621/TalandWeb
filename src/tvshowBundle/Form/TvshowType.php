<?php

namespace tvshowBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TvshowType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('episodenum')->add('description')->add('duree')->add('type')->add('link')->add('year')->add('coverimage')->add('galeryimage1')->add('galeryimage2')->add('galeryimage3')->add('galeryimage4')->add('galeryimage5');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'tvshowBundle\Entity\Tvshow'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tvshowbundle_tvshow';
    }


}
