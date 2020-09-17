<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $existingUser = $this->userRepository->findOneBy([
            'email' => $value
        ]);

        if (!$existingUser) {
            return;
        }


        // /* @var $constraint \App\Validator\UniqueUser */

        // if (null === $value || '' === $value) {
        //     return;
        // }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            // ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
