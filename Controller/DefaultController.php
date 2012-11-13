<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \DW\UserBundle\Service\PasswordUtilities;
use \DW\UserBundle\Entity\User;
use \Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Page d'accueil
     * @return type
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        
        $form = $this->createFormBuilder($user)->add('email', 'text')->getForm();
        if ($request->isMethod('POST')) 
        {
            $form->bind($request);
            $user = $form->getData();
           
            $user->setPassword($this->passwordReinitAction($user->getEmail()));
            
        }
        
        return $this->render('DWUserBundle:Default:index.html.twig', array(
            'form' => $form->createView()));
    }
    
    /**
     * Initialise la base de données
     * @return type
     */
    public function initDatabaseAction()
    {

        /*******************************************
         *     Supprime et reconstruit la base
         *******************************************/
        $kernel = $this->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);
        //DROP le Schema 
        $options = array('command' => 'doctrine:schema:drop',"--force" => true);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
        //CREATE le Schema 
        $options = array('command' => 'doctrine:schema:update',"--force" => true);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
        
        
        /*******************************************
         *         Initialise les valeurs
         *******************************************/
        
        // Initialise les utilisateurs        
        $super_admin = new \DW\UserBundle\Entity\User();        
        $super_admin->setUsername('superadmin');
        $super_admin->setEmail($this->container->getParameter('email_sender'));
        $super_admin->setPassword('superadminpass');
        
        $admin = new \DW\UserBundle\Entity\User();        
        $admin->setUsername('admin');
        $admin->setEmail($this->container->getParameter('email_sender').'2');
        $admin->setPassword('adminpass');
                
        $user = new \DW\UserBundle\Entity\User();        
        $user->setUsername('user');
        $user->setEmail($this->container->getParameter('email_sender').'3');
        $user->setPassword('userpass');
        
        // initialise les roles
        $role = new \DW\UserBundle\Entity\Role();
        $role->setName('SUPER-ADMIN');
        $role->setDesciption("Super administrateur : possède tous les droits");
        
        $role2 = new \DW\UserBundle\Entity\Role();
        $role2->setName('ADMIN');
        $role2->setDesciption("Administrateur : possède les droits d'administration");
        
        $role3 = new \DW\UserBundle\Entity\Role();
        $role3->setName('USER');
        $role3->setDesciption("Utilisateur : possède les droits d'utilisateur");
        
        // Assigne les roles aux utilisateurs
        $super_admin->addRole($role);
        $super_admin->addRole($role2);
        $admin->addRole($role2);        
        $user->addRole($role3);
        
        $em = $this->getDoctrine()->getEntityManager();
        
        //Persistance
        $em->persist($super_admin);
        $em->persist($admin);
        $em->persist($user);
        $em->flush();
        
        PasswordUtilities::insertRandomUsers($this, $this->container->getParameter('email_sender'));
        
        return $this->render('DWUserBundle:Default:index.html.twig');
          
    }
    
    /**
     * Permet de recréer un mot de passe et de l'envoyer par e-mail
     * @param string $email email du compte
     * @return type
     */
    public function passwordReinitAction($email)
    {
         $User = $this->getDoctrine()->getRepository('DWUserBundle:User')->findOneBy(array('email' => $email));
         
         if (is_object($User))
         {
            $passw = $User->getPassword();
            
            // Appelle un utilitaire pour redéfinir le mot de passe
            $passw = PasswordUtilities::generatePassword();
            
            $User->setPassword($passw);
            
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($User);
            $em->flush();
            
                try {
                $message = \Swift_Message::newInstance()
                ->setSubject('A propos de votre compte')
                ->setFrom($this->container->getParameter('email_sender'))
                ->setTo($email)
                ->setBody($this->renderView('DWUserBundle:Default:passwordReinit.html.twig', array('passw' => $passw)))
                ;
                $this->get('mailer')->send($message);
                }
                catch (Exception $e)
                {
                    print $e->getMessage();
                }
         }
         
         return $this->render('DWUserBundle:Default:index.html.twig');
         
    }
    
}
