<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="contacts")
 */
class Contact {
     
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int 
     */
    private $id;
     
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @var string 
     */
    private $firstName;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @var string 
     */
    private $lastName;
    
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @var int 
     */
    private $number;
    
    /**
     * @ORM\Column(type="integer")
     * @var integer 
     */
    private $dateCreated;
    
    /**
     * 
     * @return int
     */
    function getId(): int {
        return $this->id;
    }
    
    function getFirstName() {
        return $this->firstName;
    }
    
    function getLastName() {
        return $this->lastName;
    }
    
    /**
     * 
     * @return int
     */
    function getNumber() {
        return $this->number;
    }
    
    /**
     * 
     * @return int
     */
    function getDateCreated(): int {
        return $this->dateCreated;
    }
    
    /**
     * 
     * @param int $id
     * @return void
     */
    function setId(int $id): void {
        $this->id = $id;
    }
    
    /**
     * 
     * @param string $first_name
     * @return void
     */
    function setFirstName(string $first_name): void {
        $this->firstName = $first_name;
    }
    
    /**
     * 
     * @param string $last_name
     * @return void
     */
    function setLastName(string $last_name): void {
        $this->lastName = $last_name;
    }
    
    /**
     * 
     * @param int $number
     * @return void
     */
    function setNumber($number): void {
        $this->number = $number;
    }
    
    /**
     * 
     * @param integer $date_created
     * @return void
     */
    function setDateCreated(int $date_created): void {
        $this->dateCreated = $date_created;
    }

}
