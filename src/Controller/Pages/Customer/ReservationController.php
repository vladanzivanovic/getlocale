<?php

namespace App\Controller\Pages\Customer;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReservationController
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/dashboard", methods={"GET"}, name="reservation_list_page")
     * @Template("pages/reservation-list.html.twig")
     *
     * @return array
     */
    public function index()
    {
        return [];
    }
}