<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Service;
use Doctrine\ORM\EntityManager;

class PasswordUtilities {
    
/**
 * Génère un nouveau mot de passe
 * @param int $longueur longueur du mot de passe en sortie (par défaut 8)
 * @return string Le mot de passe 
 */
public function generatePassword($longueur=8)
    {
        // ---------------------------------------------------------------------
        //  Générer un mot de passe aléatoire
        // ---------------------------------------------------------------------

            // initialiser la variable $mdp
            $mdp = "";

            // Définir tout les caractères possibles dans le mot de passe,
            // Il est possible de rajouter des voyelles ou bien des caractères spéciaux
            $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

            // obtenir le nombre de caractères dans la chaîne précédente
            // cette valeur sera utilisé plus tard
            $longueurMax = strlen($possible);

            if ($longueur > $longueurMax) {
                $longueur = $longueurMax;
            }

            // initialiser le compteur
            $i = 0;

            // ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
            while ($i < $longueur) {
                // prendre un caractère aléatoire
                $caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);

                // vérifier si le caractère est déjà utilisé dans $mdp
                if (!strstr($mdp, $caractere)) {
                    // Si non, ajouter le caractère à $mdp et augmenter le compteur
                    $mdp .= $caractere;
                    $i++;
                }
            }

            // retourner le résultat final
            return $mdp;

    }
    
    public function insertRandomUsers($controler, $email)
    {
         $entity_manager = $controler->getDoctrine()->getEntityManager();
        for ($i=4; $i<105; $i++)
        {
            $user = new \DW\UserBundle\Entity\User();        
            $user->setUsername('user'.$i);
            $user->setEmail($email.$i);
            $user->setPassword(self::generatePassword(3));
            
            $role = $controler->getDoctrine()->getRepository('DWUserBundle:Role')->findOneBy(array('name' => 'USER'));
            $user->addRole($role);
           
            $entity_manager->persist($user);
        }
        
        $entity_manager->flush();
    }
}
