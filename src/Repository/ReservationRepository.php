<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ExtendedEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @param User $user
     * @param bool $isAdmin
     *
     * @return array
     */
    public function getReservations(User $user, bool $isAdmin)
    {
        $query = $this->createQueryBuilder('r')
            ->select(
                'r.id',
                'r.email',
                'r.comment',
                'r.adminComment as admin_comment',
                'r.code',
                'DATE_FORMAT(r.date, \'%d/%m/%Y\') as date',
                'user.email as user_email'
            )
            ->join('r.user', 'user')
            ->orderBy('r.date', 'DESC');

        if (false === $isAdmin) {
            $query->where('r.user = :user')
                ->setParameter('user', $user);
        }

        return $query->getQuery()->getArrayResult();
    }
}
