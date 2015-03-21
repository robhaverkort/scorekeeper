<?php

namespace ScorekeeperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ScorekeeperBundle\Entity\ContestRepository")
 */
class Contest {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="League", inversedBy="contests")
     * @ORM\JoinColumn(name="league_id", referencedColumnName="id")
     */
    protected $league;

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="contest")
     */
    protected $results;

    public function __construct() {
        $this->results = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Contest
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set league
     *
     * @param \ScorekeeperBundle\Entity\League $league
     * @return Contest
     */
    public function setLeague(\ScorekeeperBundle\Entity\League $league = null) {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return \ScorekeeperBundle\Entity\League 
     */
    public function getLeague() {
        return $this->league;
    }

    /**
     * Add results
     *
     * @param \ScorekeeperBundle\Entity\Result $results
     * @return Contest
     */
    public function addResult(\ScorekeeperBundle\Entity\Result $results) {
        $this->results[] = $results;

        return $this;
    }

    /**
     * Remove results
     *
     * @param \ScorekeeperBundle\Entity\Result $results
     */
    public function removeResult(\ScorekeeperBundle\Entity\Result $results) {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResults() {
        return $this->results;
    }

}
