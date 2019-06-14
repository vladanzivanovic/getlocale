<?php

namespace App\Controller\Pages\Customer;

use App\Entity\Reservation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationEditController
 */
class ReservationEditController extends AbstractController
{
    /**
     * @Route("/dashboard/reservation/new", methods={"GET"}, name="add_reservation_form_page")
     * @Template("pages/edit-reservation.html.twig")
     *
     * @return array
     */
    public function renderAddReservation()
    {
        return [];
    }

    /**
     * @Route("/dashboard/reservation/edit/{code}", methods={"GET"}, name="edit_reservation_form_page")
     * @Template("pages/edit-reservation.html.twig")
     *
     * @param Reservation $reservation
     *
     * @return array
     */
    public function renderEditReservation(Reservation $reservation)
    {
        return [
            'email' => $reservation->getEmail(),
            'comment' => $reservation->getComment(),
            'date' => $reservation->getDate()->format('Y-m-d'),
        ];
    }
}