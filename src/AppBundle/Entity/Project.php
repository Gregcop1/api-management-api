<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"project-write", "user-read"})
     */
    private $id;

    /**
     * @var string The name of this project.
     *
     * @ORM\Column
     * @Groups({"project", "user-read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Mission::class, mappedBy="project", cascade={"persist"})
     * @Groups({"project-write"})
     */
    private $missions;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->missions = new ArrayCollection();
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
     * Add mission.
     *
     * @param Mission $mission
     *
     * @return Project
     */
    public function addMission(Mission $mission)
    {
        $this->missions[] = $mission;

        return $this;
    }

    /**
     * Remove mission.
     *
     * @param Mission $mission
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMission(Mission $mission)
    {
        return $this->missions->removeElement($mission);
    }

    /**
     * Get missions.
     *
     * @return Collection
     */
    public function getMissions()
    {
        return $this->missions;
    }

    /**
     * @Groups({"project-read"})
     */
    public function getUsers(): Collection
    {
        $users = new ArrayCollection();

        /** @var Mission $mission */
        foreach ($this->missions as $mission) {
            $users->add($mission->getUser());
        }

        return $users;
    }
}
