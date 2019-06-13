<?php

namespace App\Controller\Pages\Customer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationEditController
 */
class ReservationEditController extends AbstractController
{
    /**
     * @Route("/dashboard/reservation/new", methods={"GET"}, name="reservation_form_page")
     * @Template("pages/edit-reservation.html.twig")
     *
     * @return array
     */
    public function renderAddReservation()
    {
        return [];
    }
}