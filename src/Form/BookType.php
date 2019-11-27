<?php

namespace App\Form;

use App\Entity\Book;
use PhpParser\Node\NullableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('NBpages')
            ->add('style', ChoiceType::class, [
                'choices' => [
                    'Thriller' => 'thriller',
                    'Policier' => 'policier',
                    'Roman' => 'roman'
                ]
            ])
            ->add('stock')
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
