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
     * @var integer
     *
     * @ORM\Column(name="max_contests", type="integer")
     */
    private $max_contests;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="count_contests", type="integer")
     */
    private $count_contests;
    
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


    /**
     * Set max_contests
     *
     * @param integer $maxContests
     * @return League
     */
    public function setMaxContests($maxContests)
    {
        $this->max_contests = $maxContests;

        return $this;
    }

    /**
     * Get max_contests
     *
     * @return integer 
     */
    public function getMaxContests()
    {
        return $this->max_contests;
    }

    /**
     * Set count_contests
     *
     * @param integer $countContests
     * @return League
     */
    public function setCountContests($countContests)
    {
        $this->count_contests = $countContests;

        return $this;
    }

    /**
     * Get count_contests
     *
     * @return integer 
     */
    public function getCountContests()
    {
        return $this->count_contests;
    }
}
