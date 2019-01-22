<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,
                array('attr' => array('placeholder' => 'Votre pseudo'),
                    'constraints' => array(new NotBlank(array("message" => "Veuillez remplir le champ nom")))))
            ->add('sujet', TextType::class,
                array('attr' => array('placeholder' => 'Sujet de votre demande'),
                    'constraints' => array(new NotBlank(array("message" => "Veuillez remplir le champ sujet")))))
            ->add('email', EmailType::class,
                array('attr' => array('placeholder' => 'Votre email'),
                    'constraints' => array(new NotBlank(array("message" => "Veuillez remplir le champ email")),
                        new Email(array("message" => "Votre email {{ value }} n'est pas un email valide", "checkMX" => "false")))))
            ->add('contenu', TextType::class,
                array('attr' => array('placeholder' => 'Contenu de votre demande'),
                    'constraints' => array(new NotBlank(array("message" => "Veuillez remplir le champ contenu")))));

    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('error_bubbling' => true));
    }

    public function getBlockPrefix()
    {
        return 'contact_form';
    }
}