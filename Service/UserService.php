<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Service;
use Doctrine\ORM\EntityManager;
use DW\UserBundle\Entity\User;

class UserService {
    

public static function desableUser($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setEnabled(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
public static function enableUser($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setEnabled(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
public static function accountExpired($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
public static function accountNotExpired($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
public static function accountLocked($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
public static function accountNotLocked($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    
}
