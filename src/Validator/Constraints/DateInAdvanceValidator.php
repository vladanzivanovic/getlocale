<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use \DateTime;

/**
 * Class DateInAdvanceValidator
 */
class DateInAdvanceValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $diff = $value->diff((new DateTime()));
        $days = $diff->days;
        $isInAdvance = $diff->invert === 1;

        if (!$isInAdvance || ($isInAdvance && $days < $constraint->days)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $constraint->days)
                ->addViolation();
        }
    }
}