<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Service;
use Doctrine\ORM\EntityManager;
use DW\UserBundle\Entity\User;

class UserService {
    
/**
 * Désactive un utilisateur
 * @param type $controler
 * @param \DW\UserBundle\Entity\User $user
 */
public static function desableUser($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setEnabled(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Active un utilisateur
     * @param type $controler
     * @param \DW\UserBundle\Entity\User $user
     */
public static function enableUser($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setEnabled(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Passe un compte à expiré
     * @param type $controler
     * @param \DW\UserBundle\Entity\User $user
     */
public static function accountExpired($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Passe un compte à non expiré
     * @param type $controler
     * @param \DW\UserBundle\Entity\User $user
     */
public static function accountNotExpired($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Bloque un compte
     * @param type $controler
     * @param \DW\UserBundle\Entity\User $user
     */
public static function accountLocked($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(1);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Débloque un compte
     * @param type $controler
     * @param \DW\UserBundle\Entity\User $user
     */
public static function accountNotLocked($controler, User $user)
    {
       $entity_manager = $controler->getDoctrine()->getEntityManager();
       $user->setAccountExpired(0);
       $entity_manager->persist($user);
       $entity_manager->flush();
    }
    
    /**
     * Vérifie que le compte a le droit
     * @param table $t_roles Roles du compte
     * @param table $t_aut_roles Role requis
     * @throws \Exception
     */
    public function verify($t_roles, $t_aut_roles)
    {
        $autentif_ok = false;
        
        if (count($t_roles) == 0)
        {
            throw new \Exception('Not allowed');
        }
        
        
        foreach ($t_roles as $roles) 
        {
            foreach ($t_aut_roles as $aut_role) {
                if ($roles == $aut_role)
                {
                    $autentif_ok = true;
                }
            }
        }
        
        if (!$autentif_ok)
        {
            throw new \Exception('Not connected');
        }   
    }      
    
    
}
