<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @return Sorties[]
     */
    public function findSearch(SearchData $search)
    {
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder->leftJoin('s.siteOrganisateur', 'c')
            ->addSelect('c');

        if (!empty($search->q)) {
            $queryBuilder->andWhere('s.nom LIKE :q');
            $queryBuilder->setParameter('q', "%" . $search->q . "%");
        }

        if (!empty($search->startDate) && !empty($search->endDate)) {
            $queryBuilder->andWhere('s.datedebut BETWEEN :startDate AND :endDate');
            $queryBuilder->setParameter('startDate', $search->startDate);
            $queryBuilder->setParameter('endDate', $search->endDate);
        }

        if (!empty($search->campus)) {
            $queryBuilder->andWhere('s.siteOrganisateur IN (:campus)');
            $queryBuilder->setParameter('campus', $search->campus);
        }
        /*A afficher en mode connecte mais a revoir ne fonctionne pas, pb accession attribut choice
        if (!empty($search->status)){
                    $queryBuilder->andWhere('s.datecloture < :now');
                    $queryBuilder->setParameter('now', new \DateTime('now'));
                }*/

        $query = $queryBuilder->getQuery();
        $results = $query->getResult();
        return $results;
    }
}
