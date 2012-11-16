<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
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
     * Permet de recréer un mot de passe et de l'envoyer par e-mail
     * @param string $email email du compte
     * @return type
     */
    public function passwordReinitAction($email)
    {
        $userService = $this->get("userService");
        $userService->verify($this->getRequest()->getSession()->get('userAutentif'), array('SUPER-ADMIN'));
        
         $User = $this->getDoctrine()->getRepository('DWUserBundle:User')->findOneBy(array('email' => $email));
         
         if (is_object($User))
         {
            $passw = $User->getPassword();
            
            // Appelle un utilitaire pour redéfinir le mot de passe
            $passwordUtilities = $this->get("passwordUtilities");
            $passw = $passwordUtilities->generatePassword();
            
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
    
    /**
     * Fonction non protégée pour se loguer
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function loginAction(Request $request)
    {
        
           $user = new User();
        
            $form = $this->createFormBuilder($user)
                    ->add('username', 'text')
                    ->add('password', 'text')
                    ->getForm();
           
        
        if ($request->isMethod('POST')) 
        {
            
            $form->bind($request);
            
            $user = $form->getData();
            
            $tab_res = $request->request->get("form");
            $tab_res_sortie = array();
            foreach ($tab_res as $param)
            {
                $tab_res_sortie[] = $param;
            }
            
            $encoded_password = sha1($tab_res_sortie[1]);
            
            $user_log = $this->getDoctrine()->getRepository('DWUserBundle:User')->findOneBy(array ('username' => $user->getUsername(), 'encrypted_password' => $encoded_password));
            
            $t_roles = array();
            
            if (is_object($user_log))
            {
                foreach ($user_log->getRoles() as $role)
                {
                    $t_roles[] = $role->getName();
                }
            }
           
            
            if (is_object($user_log))
            {
                    $this->getRequest()->getSession()->set('userAutentif', $t_roles);
                
            }
            else 
            {
               $this->getRequest()->getSession()->set('userAutentif', null);
            }
        }
        
         return $this->render('DWUserBundle:Default:login.html.twig', array(
                'form' => $form->createView(),
            ));     
    }   
    
}
