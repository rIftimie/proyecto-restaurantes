<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;

class RegistrationFormType extends AbstractType
{
    private $restaurantRepository;
    private $userRepository;

    public function __construct(RestaurantRepository $restaurantRepository,UserRepository $userRepository){
        $this->restaurantRepository = $restaurantRepository;
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $restaurants = $this->restaurantRepository->getRestaurant();
        $roles = $this->userRepository->getRolesbyId();

        $builder
            ->add('username')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
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
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => $roles,
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('restaurant', ChoiceType::class, [
                'label' => 'restaurant',
                'choices' => $restaurants,
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
