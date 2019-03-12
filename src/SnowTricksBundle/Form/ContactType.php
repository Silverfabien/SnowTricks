<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('nom', TextType::class, ['label' => 'Votre nom', 'constraints' => [new NotBlank(['message' => 'Veuillez renseigné le champs "Nom"'])]])
            ->add('sujet', TextType::class, ['label' => 'Sujet de votre demande', 'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champ "Sujet"'])]])
            ->add('email', EmailType::class, ['label' => 'Votre email', 'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champ "Email"']),
                new Email(['message' => 'Votre email {{ value }} n\'est pas un email valide'])]])
            ->add('contenu', TextareaType::class, ['label' => 'Contenu de votre demande',
                'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champ "Contenu"'])]]);

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