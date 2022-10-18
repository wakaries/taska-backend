<?php

namespace App\Infrastructure\Symfony\Validator;

use App\Validator\App;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaskValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\Task $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        /*
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
        */
    }
}
