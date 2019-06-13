<?php

namespace App\Components\Parser;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ParserInterface
 */
interface ParserInterface
{
    /**
     * @param ParameterBag $parameterBag
     *
     * @return array
     */
    public function parse(ParameterBag $parameterBag): array;
}