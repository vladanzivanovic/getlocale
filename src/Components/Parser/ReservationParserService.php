<?php

namespace App\Components\Parser;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class ReservationParserService
 */
class ReservationParserService implements ParserInterface
{
    /**
     * @param ParameterBag $parameterBag
     *
     * @return array
     */
    public function parse(ParameterBag $parameterBag): array
    {
        return [
            'email' => $parameterBag->get('email'),
            'comment' => $parameterBag->get('comment'),
            'date' => $parameterBag->get('date'),
        ];
    }
}