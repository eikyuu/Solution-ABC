<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Recommendation;
use App\Entity\Prestation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecommendationStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('clientName')
            ->add('infoClient')
            ->add('prestations', EntityType::class, [
                  'choices' => $options['prestations'],
                  'class' => Prestation::class,
                  'choice_label' => 'name',
                  'multiple' => true
              ]);
        ;
        $options;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recommendation::class,
            'prestations' => []
        ]);

        $resolver->setAllowedTypes('prestations', 'array');
    }
}
