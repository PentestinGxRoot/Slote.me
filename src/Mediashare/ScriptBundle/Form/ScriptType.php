<?php

namespace Mediashare\ScriptBundle\Form;

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
            ->add('name')
            ->add('description')
            ->add('thispath')
            ->add('payload')
            ->add('os')
            ->add('host')
            ->add('port')
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
