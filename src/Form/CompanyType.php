<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;
use function Symfony\Component\String\u;

class CompanyType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name')
            ->add('address')
            // ->add('address', TextType::class, [
            //     'constraints' => new Sequentially([
            //         new Length(min: 2, max:20),
            //         // A city cannot have numbers
            //         new Regex('/^\D+$/', message: 'This value cannot have numbers.'),
            //     ]),
            // ])
            ->add('save', SubmitType::class, [
                'label' => 'Save company',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoCapitalizeAddress(...))
        ;
    }

    public function autoCapitalizeAddress(PreSubmitEvent $event): void {
        $data = $event->getData();
        // $data['address'] = strtoupper($data['address']);
        // $data['address'] = u($data['address'])->upper()->toString();
        $data['address'] = ucfirst($data['address']);
        // dd($data);
        $event->setData($data);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
