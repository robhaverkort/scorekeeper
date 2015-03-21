<?php

namespace ScorekeeperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ScorekeeperBundle\Entity\ResultRepository")
 */
class Result {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=16)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="results")
     * @ORM\JoinColumn(name="contest_id", referencedColumnName="id")
     */
    protected $contest;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="results")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Result
     */
    public function setTotal($total) {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set contest
     *
     * @param \ScorekeeperBundle\Entity\Contest $contest
     * @return Result
     */
    public function setContest(\ScorekeeperBundle\Entity\Contest $contest = null) {
        $this->contest = $contest;

        return $this;
    }

    /**
     * Get contest
     *
     * @return \ScorekeeperBundle\Entity\Contest 
     */
    public function getContest() {
        return $this->contest;
    }

    /**
     * Set user
     *
     * @param \ScorekeeperBundle\Entity\User $user
     * @return Result
     */
    public function setUser(\ScorekeeperBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ScorekeeperBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }


    /**
     * Set details
     *
     * @param string $details
     * @return Result
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }
}
