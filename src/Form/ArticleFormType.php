<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose something catchy!',
            ])
            ->add('content', null, [
                'rows' => 15
            ])
            ->add('author', UserSelectTextType::class, [
                'disabled' => $isEdit
            ])
            ->add('location', ChoiceType::class, [
                'choices' => [
                    'The Solar System' => 'solar_system',
                    'Near a star' => 'star',
                    'Interstellar Space' => 'interstellar_space'
                ],
                'required' => false,
                'placeholder' => 'Choose a location'
            ])
            ->add('specificLocationName', ChoiceType::class, [
                'choices' => [
                    'TODO' => 'TODO'
                ],
                'required' => false,
                'placeholder' => 'Where exactly?'
            ]);

        if ($options['include_published_at']) {
            $builder->add('publishedAt', null, [
                'widget' => 'single_text'
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'include_published_at' => false
        ]);
    }
}
