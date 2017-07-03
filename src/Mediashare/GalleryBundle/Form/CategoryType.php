<?php

namespace Mediashare\GalleryBundle\Form;

use Mediashare\AdminBundle\Form\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                "label" => "Titre * :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('description', 'text', array(
                "label" => "Description :",
                'required' => false,
                'attr' => array('class' => 'tinymce form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('parent', 'entity', array(
                'class' => 'MediashareGalleryBundle:Category',
                'empty_value' => 'Racine',
                'label' => 'Menu parent :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.deep <= 2')
                        ->orderBy('c.position', 'ASC');
                },
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('pictures', 'collection', array(
                'label' => 'Images',
                'type' => new FileType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false
            ))
            ->add('position', 'text', array(
                "label" => "Position :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('online', 'choice', array(
                'label' => 'En ligne ?',
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'multiple' => false,
                'expanded' => true,
                'attr' => array('class' => 'radio'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mediashare\GalleryBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Mediashare_Gallerybundle_category';
    }
}
