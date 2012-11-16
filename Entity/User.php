<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;

/**
 * DW\UserBundle\Entity\User
 *
 * @ORM\Table(name="dw_user")
 * @ORM\Entity(repositoryClass="DW\UserBundle\Entity\UserRepository")
 */
class User
{
    
    /** @ManyToMany(targetEntity="Role", cascade={"persist"}) 
     *  @JoinTable(name="dw_user_role")
     */
    private $roles;
    
     public function getRoles() {
        return $this->roles;
    }
    
     public function getStringRoles() {
        
        $string_roles = '';
         foreach ($this->roles as $key => $value) {
             $string_roles .= $value->getName().' / ';
             
         }
         return $string_roles; 
        
    }
    
    public function addRole($role) {
        $this->roles[] = $role;
    }
    
    public function removeRole($role) {
       // Not implemented here  
      
    }
    
    
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true, unique=true)
     */
    private $email;
    
    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    
    /**
     * @var string $encrypted_password
     *
     * @ORM\Column(name="encrypted_password", type="string", length=255)
     */
    private $encrypted_password;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var boolean $accountExpired
     *
     * @ORM\Column(name="accountExpired", type="boolean", nullable=true)
     */
    private $accountExpired;

    /**
     * @var boolean $accountLocked
     *
     * @ORM\Column(name="accountLocked", type="boolean", nullable=true)
     */
    private $accountLocked;
  
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->setEncryptedPassword($password);
        
        $this->password = 'XXX Encrypted XXX';
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set encrypted_password
     *
     * @param string $encrypted_password
     * @return User
     */
    public function setEncryptedPassword($password)
    {
        $this->encrypted_password = sha1($password);
    
        return $this;
    }

    /**
     * Get encrypted_password
     *
     * @return string 
     */
    public function getEncryptedPassword()
    {
        return $this->encrypted_password;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set accountExpired
     *
     * @param boolean $accountExpired
     * @return User
     */
    public function setAccountExpired($accountExpired)
    {
        $this->accountExpired = $accountExpired;
    
        return $this;
    }

    /**
     * Get accountExpired
     *
     * @return boolean 
     */
    public function getAccountExpired()
    {
        return $this->accountExpired;
    }

    /**
     * Set accountLocked
     *
     * @param boolean $accountLocked
     * @return User
     */
    public function setAccountLocked($accountLocked)
    {
        $this->accountLocked = $accountLocked;
    
        return $this;
    }

    /**
     * Get accountLocked
     *
     * @return boolean 
     */
    public function getAccountLocked()
    {
        return $this->accountLocked;
    }
    



}
