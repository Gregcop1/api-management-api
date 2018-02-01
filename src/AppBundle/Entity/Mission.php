<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"mission", "mission-read"}},
 *     "denormalization_context"={"groups"={"mission", "mission-write"}}
 * })
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="missions")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id", nullable=false)
     *
     * @Groups({"mission-read", "user"})
     */
    private $project;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="missions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     *
     * @Groups({"mission-read", "project"})
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default" = false})
     *
     * @Groups({"mission-read", "project", "user"})
     */
    private $hidden;

    /**
     * Set hidden.
     *
     * @param bool $hidden
     *
     * @return Mission
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden.
     *
     * @return bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set project.
     *
     * @param Project $project
     *
     * @return Mission
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Mission
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
