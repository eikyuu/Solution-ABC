<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registeremail', EmailType::class)
            ->add('name', null, ['attr' => ['placeholder' => 'Jean Dupont']])
            ->add('company', null, ['attr' => ['placeholder' => 'Entreprise du chene']])
            ->add('phonenumber', null, ['attr' => ['placeholder' => '02 47 00 00 00']])
            ->add('workingLocation', null, ['attr' => ['placeholder' => '49 rue du vieux chene']])
            ->add('postCode', null, ['attr' => ['placeholder' => '63000']])
            ->add('city', null, ['attr' => ['placeholder' => 'Clermont-Ferrand']])
            ->add('profileImage', null, [
                  'data' => 'https://image.flaticon.com/icons/png/512/64/64572.png',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ;
            $builder->add('jobs', EntityType::class, [
                'class' => Job::class,
                'choice_label' => 'nameJob',
                'multiple' => true,
                'by_reference' => false
            ]);
            $options;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
