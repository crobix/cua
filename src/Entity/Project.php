<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name="project", uniqueConstraints={@ORM\UniqueConstraint(name="project_id_uindex", columns={"id"})})
 * @ORM\Entity
 */
class Project
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255, nullable=false)
     */
    private $projectName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="php_version", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $phpVersion = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="symfony_version", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $symfonyVersion = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="path", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $path = 'NULL';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    private function onSave()
    {
        $this->updatedAt = new \DateTime("now");
    }

}
