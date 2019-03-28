<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plainPassword', RepeatedType::class, ['type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas', 'required' => true,
                'first_options' => ['label' => 'Votre nouveau mot de passe',
                    'constraints' => [new NotBlank(['message' => 'Veuillez renseigné le champs "Nouveau mot de passe"'])]],
                'second_options' => ['label' => 'Tapez votre mot de passe à nouveau',
                    'constraints' => [new NotBlank(['message' => 'Veuillez renseigné le champs "Mot de passe à nouveau"'])]]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SnowTricksBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'snowtricksbundle_user';
    }
}