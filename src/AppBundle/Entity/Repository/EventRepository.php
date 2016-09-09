<?php
/**
 * @author Serzh Yevtushenko <s.evtyshenko@gmail.com>
 * Date: 9/9/16
 */

namespace AppBundle\Entity\Repository;


use AppBundle\Entity\SocialAccount;
use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{

    public function deleteByAccount(SocialAccount $socialAccount)
    {
        $this->createQueryBuilder('e')
             ->delete()
             ->where('e.account = :account')
             ->setParameter('account', $socialAccount)
             ->getQuery()->execute();
    }
}