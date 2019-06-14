<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class DateInAdvance
 * @Annotation
 */
class DateInAdvance extends Constraint
{
    public $days;

    public $message = "Date should be {{ days }} days in advance";
}