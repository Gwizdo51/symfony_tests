<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
            ])
            ->add('destination', ChoiceType::class, [
                'choices' => [
                    'Customer support' => 'customer.support@site.com',
                    'Sales' => 'sales@site.com',
                    'Feedback' => 'feedback@site.com',
                ],
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => '',
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send message',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
