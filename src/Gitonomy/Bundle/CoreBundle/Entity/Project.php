<?php

namespace Gitonomy\Bundle\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=32)
     */
    protected $name;

    /**
     * @ORM\Column(type="string",length=32)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Gitonomy\Bundle\CoreBundle\Entity\Repository", mappedBy="project")
     */
    protected $repositories;

    /**
     * @ORM\OneToMany(targetEntity="Gitonomy\Bundle\CoreBundle\Entity\UserRole", mappedBy="project")
     */
    protected $userRoles;

    public function __construct()
    {
        $this->repositories = new ArrayCollection();
        $this->userRoles    = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getMainRepository()
    {
        foreach ($this->repositories as $repository) {
            if ($repository->getIsProjectRepository()) {
                return $repository;
            }
        }

        throw new \RuntimeException(sprintf('No main repository for project %s', $this->name));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getRepositories()
    {
        return $this->repositories;
    }

    public function setRepositories(ArrayCollection $repositories)
    {
        $this->repositories = $repositories;
    }

    public function addRepository(Repository $repository)
    {
        $this->repositories->add($repository);
    }

    public function getUserRoles()
    {
        return $this->userRoles;
    }
}
