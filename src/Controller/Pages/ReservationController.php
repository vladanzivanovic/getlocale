<?php

namespace App\Controller\Pages;

use App\Entity\User;
use App\Repository\ReservationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationController
 */
class ReservationController extends AbstractController
{
    /**
     * @var ReservationRepository
     */
    private $reservationRepository;

    /**
     * ReservationController constructor.
     *
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(
        ReservationRepository $reservationRepository
    ) {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @Route("/dashboard", methods={"GET"}, name="reservation_list_page")
     * @Template("pages/reservation-list.html.twig")
     *
     * @return array
     */
    public function index()
    {
        /** @var User $user */
        $user = $this->getUser();
        $isAdmin = $user->hasRole('ROLE_ADMIN');

        $reservations = $this->reservationRepository->getReservations($user, $isAdmin);

        return [
            'reservations' => $reservations
        ];
    }
}