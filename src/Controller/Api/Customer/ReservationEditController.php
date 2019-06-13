<?php

namespace App\Controller\Api\Customer;

use App\Components\Parser\ParserInterface;
use App\Components\Reservation\ReservationEditHandler;
use App\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationEditController
 */
class ReservationEditController extends AbstractController
{
    private $parser;
    private $editHandler;

    /**
     * ReservationEditController constructor.
     *
     * @param ParserInterface        $parser
     * @param ReservationEditHandler $editHandler
     */
    public function __construct(
        ParserInterface $parser,
        ReservationEditHandler $editHandler
    ) {
        $this->parser = $parser;
        $this->editHandler = $editHandler;
    }

    /**
     * @Route("/reservation/add", methods={"POST"}, name="api_reservation_add")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function addReservation(Request $request): JsonResponse
    {
        $parsedData = $this->parser->parse($request->request);

        $response = $this->editHandler->addReservation($parsedData);

        if (is_array($response)) {
            return $this->json($response, JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json([]);
    }

    /**
     * @Route("/reservation/edit/{code}", methods={"POST"}, name="api_reservation_update")
     *
     * @param Reservation $reservation
     * @param Request     $request
     *
     * @return JsonResponse
     */
    public function editReservation(Reservation $reservation, Request $request)
    {
        $parsedData = $this->parser->parse($request->request);

        $response = $this->editHandler->editReservation($reservation, $parsedData);

        if (is_array($response)) {
            return $this->json($response, JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->json([]);
    }
}