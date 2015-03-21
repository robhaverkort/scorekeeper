<?php

namespace ScorekeeperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * League
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ScorekeeperBundle\Entity\LeagueRepository")
 */
class League {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Contest", mappedBy="league")
     */
    protected $contests;

    public function __construct() {
        $this->contests = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return League
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add contests
     *
     * @param \ScorekeeperBundle\Entity\Contest $contests
     * @return League
     */
    public function addContest(\ScorekeeperBundle\Entity\Contest $contests) {
        $this->contests[] = $contests;

        return $this;
    }

    /**
     * Remove contests
     *
     * @param \ScorekeeperBundle\Entity\Contest $contests
     */
    public function removeContest(\ScorekeeperBundle\Entity\Contest $contests) {
        $this->contests->removeElement($contests);
    }

    /**
     * Get contests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContests() {
        return $this->contests;
    }

}
