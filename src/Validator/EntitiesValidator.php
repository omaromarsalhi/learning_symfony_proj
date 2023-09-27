<?php

namespace App\Validator;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EntitiesValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function validate($email, Constraint $constraint)
    {

        if (!$constraint instanceof Entities) {
            throw new UnexpectedTypeException($constraint, Entities::class);
        }

        if (null === $email || '' === $email) {
            return;
        }

        if (!is_string($email)) {
            throw new UnexpectedValueException($email, 'string');
        }

        if (!$this->userExists($email)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }

    private function userExists(string $email): bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $email));
        return null === $user;
    }




    public function validate4Update($id, $email, Constraint $constraint)
    {
        if (null === $email || '' === $email) {
            return false;
        }

        if (!is_string($email)) {
            throw new UnexpectedValueException($email, 'string');
        }

        if (!$this->userExists4Update($email, $id)) {
            $this->context->buildViolation("bla bla")->addViolation();
        } else
            return true;
    }

    private function userExists4Update(string $email, int $id): bool
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $email));
        return ($user->getId() == $id || null === $user);
    }
}



 // public function validate($value, Constraint $constraint)
    // {
    //     /* @var App\Validator\Entities $constraint */

    //     if (null === $value || '' === $value) {
    //         return;
    //     }

    //     // TODO: implement the validation here
    //     $this->context->buildViolation($constraint->message)
    //         ->setParameter('{{ value }}', $value)
    //         ->addViolation();
    // }