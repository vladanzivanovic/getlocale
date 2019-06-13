<?php

namespace App\Repository;

use App\Components\Api\LanguageService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Gedmo\Translatable\TranslatableListener;

/**
 * Class ExtendedEntityRepository
 */
class ExtendedEntityRepository extends ServiceEntityRepository
{
    /**
     * @param object $object
     */
    public function persist($object): void
    {
        $this->_em->persist($object);
    }

    /**
     * @param object $object
     */
    public function remove($object): void
    {
        $this->_em->remove($object);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    /**
     * @param $object
     */
    public function save($object): void
    {
        $this->persist($object);
        $this->flush();
    }
}
