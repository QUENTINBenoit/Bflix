<?php

namespace App\Repository;

use App\Entity\Tvshow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tvshow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tvshow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tvshow[]    findAll()
 * @method Tvshow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TvshowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tvshow::class);
    }

    // /**
    //  * @return Tvshow[] Returns an array of Tvshow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tvshow
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    /**
     * Méthode retournant toutes les séries triées par ordre alphabétique
     *
     * @return void
     */
    public function findAllOrderAlpha()
    {
        $qb = $this->createQueryBuilder('tv'); //=> l'alias va faire référence à l'entité courante (TvShow)
        $qb->orderBy('tv.title', 'ASC');       //=> je trie le résultat par title ascendant. 
        $query = $qb->getQuery();              //=> je créer ma requête SQL 
        return $query->execute();              //=> j'exécute et retourne le résultat sous forme d'un tableau d'objets de la classe TvShow
    }

    public function findWithDetails($id)
    {


        $qb = $this->createQueryBuilder('tv');
        // Je cible la série demandée ($id)
        $qb->where('tv.id = :id');
        $qb->setParameter(':id', $id);
        // Je créer mes jointure pour recupèrer les infons de autres entitée en une seule requete
        // ici j'utilise un leftjoin car si j'ai un série qui n' pas de valaur associée, 
        // je recupère quand même les infos de ma séries a la =/= de join qui est beaucoup plus strict:
        // si pas de valeur dans une proprièter == un erreur 
        $qb->leftJoin('tv.seasons', 'sais');
        $qb->leftJoin('tv.characters', 'personnages');
        $qb->leftJoin('tv.categories', 'categories');
        $qb->leftJoin('sais.episodes', 'episodes');

        // demmande de recuperer les infos des autres tables     
        $qb->addSelect('sais, personnages, categories, episodes');
        $query = $qb->getQuery();
        \dd($query);
        return $query->getOneOrNullResult();
    }
}
