<?php

namespace Mediashare\ProductBundle\Form;

use Mediashare\AdminBundle\Form\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder


            ->add('category', 'entity', array(
                'class' => 'MediashareProductBundle:Category',
                'property' => 'title',
                'empty_value' => 'Catégorie',
                'label' => 'Choix de la catégorie :',
                'required' => true,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('title', 'text', array(
                "label" => "Titre * :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('urlLink', 'url', array(
                "label" => "Lien vidéo :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('reference', 'text', array(
                "label" => "Référence :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('price', 'text', array(
                "label" => "Prix :",
                'required' => false,
                'attr' => array('class' => 'form-control form-price'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('promotionPrice', 'text', array(
                'required' => false,
                "label" => "Prix promo :",
                'attr' => array('class' => 'form-control form-price'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('description', 'text', array(
                "label" => "Description :",
                'required' => false,
                'attr' => array('class' => 'tinymce form-control'),
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
            ))
            ->add('promotionStartDate', 'date', array(
                'label' => "Date de début de la promotion :",
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'form-control date_picker'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('promotionEndDate', 'date', array(
                'label' => "Date de fin de la promotion :",
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'form-control date_picker'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))

            ->add('pictures', 'collection', array(
                'label' => 'Images',
                'type' => new FileType(),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false
            ));

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mediashare\ProductBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Mediashare_productbundle_product';
    }
}
