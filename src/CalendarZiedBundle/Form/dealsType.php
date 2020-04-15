<?php

namespace CalendarZiedBundle\Form;

use CalendarZiedBundle\Controller\dealsController;
use CalendarZiedBundle\Entity\Calendars;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class dealsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventdescription')
            ->add('start')
            ->add('end')
            ->add('termid')
            ->add('calendarname', EntityType::class, [
            'class' => calendars::class,
            'choice_label' => 'calendarname',
        ])
            ->add('imageFile', VichImageType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CalendarZiedBundle\Entity\deals'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'calendarbundle_deals';
    }


}
