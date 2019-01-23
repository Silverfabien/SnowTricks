<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, ['label' => 'Votre Pseudo :', 'required' => true,
                'constraints' => [new NotBlank(['message' => 'Veuillez renseigné votre pseudo'])]])
            ->add('plainPassword', PasswordType::class, ['label' => 'Votre Mot de passe :', 'required' => true,
                'constraints' => [new NotBlank(['message' => 'Veuillez renseigné votre mot de passe'])]])
            ->add('email', EmailType::class, ['label' => 'Votre Email :', 'required' => true,
                'constraints' => [new NotBlank(['message' => 'Veuillez renseigné votre email']), new Email(['message' => "Votre email {{ value }}, n'est pas un email valide"])]]);
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