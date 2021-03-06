<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ApiResource(attributes={
 *     "normalization_context"={"groups"={"period", "period-read"}},
 *     "denormalization_context"={"groups"={"period", "period-write"}}
 * })
 */
class Period
{
    /**
     * @ORM\ManyToOne(targetEntity=Project::class, inversedBy="periods")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     *
     * @Groups({"period", "user-read"})
     */
    private $project;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="periods")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Groups({"period", "project-read"})
     */
    private $user;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     *
     * @Groups({"period", "project-read", "user-read"})
     */
    private $start;

    /**
     * @ORM\ManyToOne(targetEntity=PeriodType::class)
     * @ORM\JoinColumn(name="period_type_id", referencedColumnName="id")
     *
     * @Groups({"period"})
     */
    private $type;

    /**
     * Set start.
     *
     * @param string $start
     *
     * @return Period
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start.
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set project.
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Period
     */
    public function setProject(\AppBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Period
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set type.
     *
     * @param \AppBundle\Entity\PeriodType|null $type
     *
     * @return Period
     */
    public function setType(\AppBundle\Entity\PeriodType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return \AppBundle\Entity\PeriodType|null
     */
    public function getType()
    {
        return $this->type;
    }
}
