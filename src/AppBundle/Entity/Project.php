<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Project.
 *
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"project", "project-read"}},
 *     "denormalization_context"={"groups"={"project", "project-write"}}
 * })
 */
class Project
{
    /**
     * @var int The id of this project.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"project-read", "user-read", "period"})
     */
    private $id = -1;

    /**
     * @var string The name of this project.
     *
     * @ORM\Column
     * @Groups({"project", "user-read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(name="User", referencedColumnName="id")
     *
     * @Groups({"project"})
     */
    private $chief;

    /**
     * @ORM\OneToMany(targetEntity=Period::class, mappedBy="project", cascade={"persist"})
     * @Groups({"project-write"})
     */
    private $periods;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->periods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set chief.
     *
     * @param \AppBundle\Entity\User|null $chief
     *
     * @return Project
     */
    public function setChief(\AppBundle\Entity\User $chief = null)
    {
        $this->chief = $chief;

        return $this;
    }

    /**
     * Get chief.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getChief()
    {
        return $this->chief;
    }

    /**
     * Add period.
     *
     * @param \AppBundle\Entity\Period $period
     *
     * @return Project
     */
    public function addPeriod(\AppBundle\Entity\Period $period)
    {
        $this->periods[] = $period;

        return $this;
    }

    /**
     * Remove period.
     *
     * @param \AppBundle\Entity\Period $period
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePeriod(\AppBundle\Entity\Period $period)
    {
        return $this->periods->removeElement($period);
    }

    /**
     * Get periods.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriods()
    {
        return $this->periods;
    }
}
