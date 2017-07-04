<?php

namespace Mediashare\ScriptBundle\Form;

use Mediashare\AdminBundle\Form\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScriptType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                "label" => "Nom* :",
                'required' => true,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('description', 'textarea', array(
                "label" => "Commentaire :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            // ->add('pictures', 'collection', array(
            //     'label' => 'Images',
            //     'type' => new FileType(),
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false,
            //     'required' => false
            // ))
            ->add('thispath', 'text', array(
                "label" => "Path* :",
                'required' => true,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('payload', 'text', array(
                "label" => "Payload :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('os', 'choice', array(
                'choices' => array(
                    '0' => 'Windows',
                    '1' => 'Mac',
                    '2' => 'Linux',
                    '3' => 'Cross-Platform'
                ),
                'required' => false,
                "label" => "Os* :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('type', 'choice', array(
                'choices' => array(
                    '0' => 'Backdoor',
                    '1' => 'Malware',
                    '2' => 'Rat',
                    '3' => 'Helper',
                    '4' => 'Autres'
                ),
                'required' => false,
                "label" => "Type* :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('host', 'text', array(
                "label" => "Host :",
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('port', 'integer', array(
                  'required' => false,
                  "label" => "Port :",
                  'attr' => array('class' => 'form-control'),
                  'label_attr' => array('class' => 'col-lg-2 control-label'),
              ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Mediashare\ScriptBundle\Entity\Script'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mediashare_scriptbundle_script';
    }
}
