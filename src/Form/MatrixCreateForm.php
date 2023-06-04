<?php

namespace App\Form;

use App\Entity\Matrix;
use App\Repository\AlternativeRepository;
use App\Repository\CharacteristicRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatrixCreateForm extends AbstractType
{
    public function __construct(
        private AlternativeRepository $alternatives,
        private CharacteristicRepository $characteristics,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Matrix $matrix */
        $matrix = $builder->getData();

        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label_attr' => [
                    'class' => 'form-control-label required',
                ],
                'row_attr' => [
                    'class' => 'form-widget form-group col-md-6 col-xxl-5',
                    'style' => 'padding-right: 14px'
                ],
                'required' => true,
                'label' => 'Название',
            ])
            ->add('alternatives', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select',
                    'data-ea-widget' => 'ea-autocomplete',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'row_attr' => [
                    'class' => 'form-widget form-group col-md-6 col-xxl-5',
                    'style' => 'padding-right: 14px'
                ],
                'choices' => $this->alternatives->findAll(),
                'choice_value' => 'id',
                'choice_label' => 'name',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'data' => $matrix->getAlternatives()->toArray(),
            ])
            ->add('characteristics', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-select',
                    'data-ea-widget' => 'ea-autocomplete',
                ],
                'label_attr' => [
                    'class' => 'form-control-label',
                ],
                'row_attr' => [
                    'class' => 'form-widget form-group col-md-6 col-xxl-5',
                    'style' => 'padding-right: 14px'
                ],
                'choices' => $this->characteristics->findAll(),
                'choice_value' => 'id',
                'choice_label' => 'name',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'data' => $matrix->getCharacteristics()->toArray(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Matrix::class,
        ]);
    }
}
