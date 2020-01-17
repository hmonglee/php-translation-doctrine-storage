<?php

declare(strict_types=1);

namespace Translation\PlatformAdapter\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Translation\PlatformAdapter\Doctrine\Entity\Translation;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends EntityRepository
{
    /**
     * Find all domains.
     *
     * @return array
     */
    public function findAllDomains()
    {
        return $this->createQueryBuilder('t')
            ->select('DISTINCT(t.domain) AS domain')
            ->getQuery()
            ->getArrayResult();
    }
}
