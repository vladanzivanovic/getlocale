<?php

namespace App\EventListeners;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use App\Components\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use \DateTime;

class ReservationListener
{
    private $email;
    private $parameterBag;
    private $reservationRepository;

    /**
     * ReservationListener constructor.
     *
     * @param ParameterBagInterface $parameterBag
     * @param Email                 $email
     * @param ReservationRepository $reservationRepository
     */
    public function __construct(
        ParameterBagInterface $parameterBag,
        Email $email,
        ReservationRepository $reservationRepository
    ) {
        $this->email = $email;
        $this->parameterBag = $parameterBag;
        $this->reservationRepository = $reservationRepository;
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $reservation = $this->getReservationObject($event);
        $reservation->setCreatedAt(new DateTime());
        $reservation->setModifiedAt(new DateTime());
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $reservation = $this->getReservationObject($event);
        $reservation->setModifiedAt(new DateTime());
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        try {
            $reservation = $this->getReservationObject($event);

            $subjectCustomer = 'Reservation - '.$reservation->getCode();
            $templateCustomer = 'customer_reservation';

            $subjectAdmin = 'Customer Reservation - '.$reservation->getCode();
            $templateAdmin = 'admin_reservation';

            $this->sendCustomerEmail($reservation, $subjectCustomer, $templateCustomer);
            $this->sendAdminEmail($reservation, $subjectAdmin, $templateAdmin);

        } catch (\Throwable $exception) {
            return;
        }
    }

    public function postUpdate(LifecycleEventArgs $event)
    {
        try {
            $reservation = $this->getReservationObject($event);
            $changes = $this->getChanges($reservation);

            $subjectCustomer = 'Reservation successfully updated';
            $templateCustomer = 'customer_reservation_update';

            $subjectAdmin = 'Customer Reservation - '.$reservation->getCode();
            $templateAdmin = 'admin_reservation_update';

            $this->sendCustomerEmail($reservation, $subjectCustomer, $templateCustomer);
            $this->sendAdminEmail($reservation, $subjectAdmin, $templateAdmin, $changes);

        } catch (\Throwable $exception) {
            return;
        }
    }

    private function sendCustomerEmail(Reservation $reservation, string $subject, string $template)
    {
        $emailData = [];

        $emailData['from'] = [$this->parameterBag->get('admin_email'), $this->parameterBag->get('app_name')];
        $emailData['to'] = [$reservation->getEmail(), null];
        $emailData['replyTo'] = getenv('ADMIN_EMAIL');
        $emailData['template'] = $template;
        $emailData['subject'] = $subject;
        $emailData['templateData']['reservation'] = $reservation;

        $this->email->setAndSendEmail($emailData);
    }

    private function sendAdminEmail(Reservation $reservation, string $subject, string $template, ?array $changes = null)
    {
        $emailData = [];

        $emailData['from'] = [$reservation->getEmail(), null];
        $emailData['to'] = [$this->parameterBag->get('admin_email'), $this->parameterBag->get('app_name')];
        $emailData['template'] = $template;
        $emailData['subject'] = $subject;
        $emailData['templateData']['reservation'] = $reservation;

        if (is_array($changes)) {
            $emailData['templateData']['reservation_diff'] = $changes;
        }

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

    private function getChanges(Reservation $reservation)
    {
        $excludedChanges = ['modifiedAt', 'createdAt'];

        $oldReservation = $this->reservationRepository->findOneBy(['code' => $reservation->getCode()]);

        $uow = $this->reservationRepository->getEntityManager()->getUnitOfWork();
        $uow->computeChangeSets();
        $changes = $uow->getEntityChangeSet($oldReservation);

        return array_filter($changes, function ($item, $field) use ($excludedChanges) {
            return !in_array($field, $excludedChanges);
            }, ARRAY_FILTER_USE_BOTH);
    }
}