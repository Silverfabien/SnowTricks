<?php

namespace SnowTricksBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TricksType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder' => 'Nom du Tricks'],
                    'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champs nom']),
                        new Length(['max' => 35, 'maxMessage' => 'Le nom ne doit pas dépasser 35 caractères'])]])
                ->add('description', TextareaType::class, ['label' => 'Description', 'attr' => ['placeholder' => 'Description du tricks'],
                    'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champs description']),
                        new Length(['max' => 2000, 'maxMessage' => 'Le message ne doit pas dépasser 2000 caractères'])]])
                ->add('figureGroup', TextType::class, ['label' => 'Groupe', 'attr' => ['placeholder' => 'Groupe du tricks'],
                    'constraints' => [new NotBlank(['message' => 'Veuillez remplir le champs groupe']),
                        new Length(['max' => 255, 'maxMessage' => 'Le message ne doit pas dépasser 255 caractères'])]])
                ->add('pictures', CollectionType::class, ['entry_type' => TricksPictureType::class,
                    'entry_options' => ['label' => false], 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false])
                ->add('videos', CollectionType::class, ['entry_type' => TricksVideoType::class,
                    'entry_options' => ['label' => false], 'allow_add' => true, 'allow_delete' => true, 'by_reference' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SnowTricksBundle\Entity\Tricks'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'snowtricksbundle_tricks';
    }


}
