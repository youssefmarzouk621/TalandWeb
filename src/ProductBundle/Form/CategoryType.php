<?php

namespace ProductBundle\Form;

use ProductBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('idcategorymother', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    if (is_null($category->getIdcategorymother())) {
                        return $category->getName();
                    }
                }
            ])
            ->add('Valider', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductBundle\Entity\Category'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productbundle_category';
    }


}
