<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Country;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array
    $options)
    {
        $builder
            ->add('name', TextType::class, 
                array('label' => 'Nom de la ville', 
                'attr' => array('class' => 'form-control',
                'title' => 'Nom de la tâche',
            )))

            ->add('countrycode', EntityType::class, [
                'class' => Country::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Pays',
                'attr' => array(
                    'class' => 'form-control',
                    'title' => 'name'
                )
            ])

            ->add('district', TextType::class,
                array('label' => 'Région', 
                'attr' => array('class' => 'form-control',
                'title' => 'Région',
            )))

            ->add('population', TextType::class, 
                array('label' => 'Population', 
                'attr' => array('class' => 'form-control',
                'title' => 'Population',
            )));

            $builder->add('save', SubmitType::class, array(
                'label' => 'Enregistrer',
                'attr' => array(
                    'class' => 'btn btn-primary btn-margin',
                    'title' => 'Enregistrer'
                )
            ));
}


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\City',
            'route' => null
        ));
    }
}
