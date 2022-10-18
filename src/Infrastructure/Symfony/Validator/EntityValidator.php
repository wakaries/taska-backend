<?php

namespace App\Infrastructure\Symfony\Validator;

use App\Validator\App;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $em) {}

    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\Entity $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $entity = $this->em->getRepository($constraint->class)->getByUuid($value);
        if ($entity == null) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
