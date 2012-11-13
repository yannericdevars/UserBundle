<?php
/**
 * @author Yann-Eric <yann-eric@live.fr>
 */
namespace DW\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * DW\UserBundle\Entity\Role
 *
 * @ORM\Table(name="dw_role")
 * @ORM\Entity(repositoryClass="DW\UserBundle\Entity\RoleRepository")
 */
class Role
{
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $desciption
     *
     * @ORM\Column(name="desciption", type="string", length=500)
     */
    private $desciption;


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
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set desciption
     *
     * @param string $desciption
     * @return Role
     */
    public function setDesciption($desciption)
    {
        $this->desciption = $desciption;
    
        return $this;
    }

    /**
     * Get desciption
     *
     * @return string 
     */
    public function getDesciption()
    {
        return $this->desciption;
    }
    
    public function __toString() {
       return $this->name ;
    }
}
