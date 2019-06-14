<?php

namespace App\Components\Reservation;

use App\Components\Helper\RandomCodeGenerator;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use App\Validator\ValidatorParser;
use \DateTime;

class ReservationEditHandler
{
    private $reservationRepository;
    private $validator;
    private $codeGenerator;

    /**
     * ReservationEditHandler constructor.
     *
     * @param ReservationRepository $reservationRepository
     * @param ValidatorParser       $validator
     * @param RandomCodeGenerator   $codeGenerator
     */
    public function __construct(
        ReservationRepository $reservationRepository,
        ValidatorParser $validator,
        RandomCodeGenerator $codeGenerator
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->validator = $validator;
        $this->codeGenerator = $codeGenerator;
    }

    /**
     * @param User  $user
     * @param array $data
     *
     * @return array|null
     */
    public function addReservation(User $user, array $data): ?array
    {
        $reservation = new Reservation();
        $reservation->setEmail($data['email'])
            ->setComment($data['comment'])
            ->setDate(new DateTime($data['date']))
            ->setCode($this->codeGenerator->random())
            ->setUser($user)
        ;

        $errors = $this->validate($reservation);

        if (is_array($errors)) {
            return $errors;
        }

        $this->reservationRepository->save($reservation);

        return null;
    }

    /**
     * @param Reservation $reservation
     * @param array       $data
     *
     * @return array|null
     */
    public function editReservation(Reservation $reservation, array $data): ?array
    {
        $reservation->setEmail($data['email'])
            ->setComment($data['comment'])
            ->setDate(new DateTime($data['date']))
            ->setAdminComment($data['admincomment']);

        $errors = $this->validate($reservation);

        if (is_array($errors)) {
            return $errors;
        }

        $this->reservationRepository->save($reservation);

        return null;
    }

    private function validate(Reservation $reservation)
    {
        $errors = $this->validator->validate($reservation, null, ['ReservationEdit']);
        $errorData = null;

        if ($errors->count() > 0) {
            $errorData = $this->validator->parseErrors($errors);
        }

        return $errorData;
    }
}