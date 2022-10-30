<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'c-form__input'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese su nombre',
                    ]),
            ]          
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'c-form__input'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese su email',
                    ]),
            ]          
            ])
            ->add('subject', ChoiceType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'c-form__select'
                ],
                'choices'  => [
                    '' => '',
                    'Presupuesto' => 'presupuesto',
                    'Soporte' => 'soporte',
                    'Otros...' => 'otros',
                ],
                'constraints' => [
                        new NotBlank([
                            'message' => 'Por favor, seleccione una de las opciones',
                        ]),
                ]                    
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 10,
                    'class' => 'c-form__textarea'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingrese un mensaje',
                ]),
            ]          

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
