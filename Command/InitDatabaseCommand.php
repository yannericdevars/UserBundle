<?php

namespace DW\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitDatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('init:database')
            ->setDescription('Initialise un SUPER-ADMIN et un ADMIN')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*******************************************
         *     Supprime et reconstruit la base
         *******************************************/
      
        $kernel = $this->getApplication()->getKernel();
        $application = $this->getApplication();
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
        $super_admin->setEmail($this->getContainer()->getParameter('email_sender'));
        $super_admin->setPassword('superadminpass');
          
        // initialise les roles
        $role = new \DW\UserBundle\Entity\Role();
        $role->setName('SUPER-ADMIN');
        $role->setDesciption("Super administrateur : possède tous les droits");
        
        $role2 = new \DW\UserBundle\Entity\Role();
        $role2->setName('ADMIN');
        $role2->setDesciption("Administrateur : possède les droits d'administration");
        
         // Assigne les roles aux utilisateurs
        $super_admin->addRole($role);
        $super_admin->addRole($role2);
        
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        
        //Persistance
        $em->persist($super_admin);
        
        $em->flush();
       
        $output->writeln("<info>La base a ete reinitialisee !!!!</info>");
    }
}
