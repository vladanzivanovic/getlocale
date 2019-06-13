<?php

namespace App\EventListeners;

use App\Entity\Reservation;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Components\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ReservationListener
{
    private $email;
    private $parameterBag;

    /**
     * ReservationListener constructor.
     *
     * @param ParameterBagInterface $parameterBag
     * @param Email                 $email
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        Email $email
    ) {
        $this->email = $email;
        $this->parameterBag = $parameterBag;
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        try {
            $reservation = $this->getReservationObject($event);

            $this->sendCustomerEmail($reservation);
            $this->sendAdminEmail($reservation);

        } catch (\Throwable $exception) {
            return;
        }
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        try {
            $reservation = $this->getReservationObject($event);

            $this->sendCustomerEmail($reservation);
            $this->sendAdminEmail($reservation);

        } catch (\Throwable $exception) {
            return;
        }
    }

    private function sendCustomerEmail(Reservation $reservation)
    {
        $emailData = [];

        $subject = 'Reservation success ';
        $template = 'customer_reservation';

        $emailData['from'] = [$this->parameterBag->get('admin_email'), 'Go Locale'];
        $emailData['to'] = [$reservation->getEmail(), null];
        $emailData['replyTo'] = getenv('ADMIN_EMAIL');
        $emailData['template'] = $template;
        $emailData['subject'] = $subject;
        $emailData['templateData']['reservation'] = $reservation;

        $this->email->setAndSendEmail($emailData);
    }

    private function sendAdminEmail(Reservation $reservation)
    {
        $emailData = [];

        $subject = 'Customer Reservation - '.$reservation->getCode();
        $template = 'admin_reservation';

        $emailData['from'] = [$reservation->getEmail(), null];
        $emailData['to'] = [$this->parameterBag->get('admin_email'), 'Go Locale'];
        $emailData['template'] = $template;
        $emailData['subject'] = $subject;
        $emailData['templateData']['reservation'] = $reservation;

        $this->email->setAndSendEmail($emailData);
    }

    private function getReservationObject(LifecycleEventArgs $event): ?Reservation
    {
        $reservation = $event->getObject();

        if (!$reservation instanceof Reservation) {
            throw new \Exception('object must be instance of Reservation class');
        }

        return $reservation;
    }
}