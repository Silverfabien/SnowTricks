<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            'constraints' => [new NotBlank(['message' => 'Veuillez renseigné votre "Pseudo"'])]])
            ->add('plainPassword', RepeatedType::class, ['type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne correspondent pas', 'required' => true,
                'first_options' => ['label' => 'Votre mot de passe',
                    'constraints' => [new NotBlank(['message' => 'Veuillez renseigné le champs "Mot de passe"'])]],
                'second_options' => ['label' => 'Tapez votre mot de passe à nouveau',
                    'constraints' => [new NotBlank(['message' => 'Veuillez renseigné le champs "Mot de passe à nouveau"'])]]])
            ->add('email', EmailType::class, ['label' => 'Votre Email :', 'required' => true,
                'constraints' => [new NotBlank(['message' => 'Veuillez renseigné votre "Email"']),
                    new Email(['message' => "Votre email {{ value }}, n'est pas un email valide"])]])
            ->add('picture', UserPictureType::class, ['label' => false]);
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