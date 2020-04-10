<?php

namespace ProductBundle\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use ProductBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    private $idMother = -1;
    private $motherName = "null";

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    if (!is_null($category->getIdcategorymother())) {
                        return $category->getName();
                    }

                },
                'group_by' => function (Category $category) {
                    if (is_null($category->getIdcategorymother())) {
                        $this->idMother = $category->getId();
                        $this->motherName = $category->getName();
                    }
                    if ($category->getIdcategorymother() === $this->idMother) {

                        return $this->motherName;
                    }
                },
                'placeholder' =>'you need to chose category!'
            ])
            ->add('price')
            ->add('imgsrc', FileType::class,[
                'mapped'=>false,
                'label'=>'choose picture'
            ])
            ->add('captcha', CaptchaType::class, array(
                'width' => 200,
                'height' => 50,
                'length' => 6,
            ))
            ->add('Valider', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProductBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'productbundle_produit';
    }


//    private function getChoices()
//    {   $category=new Category();
//
//        $choices = Category::NAME;
//        $output = [];
//        foreach ($choices as $k => $v) {
//            $output[$v] = $k;
//
//        }
//        return $output;
//    }


}
