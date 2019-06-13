<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValidatorParser
 */
class ValidatorParser extends TraceableValidator
{
    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        parent::__construct($validator);
    }

    /**
     * @param ConstraintViolationListInterface|ConstraintViolationList $errors
     *
     * @return array
     */
    public function parseErrors(ConstraintViolationListInterface $errors): array
    {
        $errorsArray = [];
        foreach ($errors->getIterator() as $val) {
            $key = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $val->getPropertyPath()));
            if (!isset($errorsArray[$key])) {
                $errorsArray[$key] = $val->getMessage();
            }
        }

        return $errorsArray;
    }
}
