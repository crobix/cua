<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Security
 *
 * @ORM\Table(name="security", uniqueConstraints={@ORM\UniqueConstraint(name="security_project_id_uindex", columns={"project_id"}), @ORM\UniqueConstraint(name="security_id_uindex", columns={"id"})})
 * @ORM\Entity
 */
class Security
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="library", type="string", length=255, nullable=false)
     */
    private $library;

    /**
     * @var string
     *
     * @ORM\Column(name="library_version", type="string", length=10, nullable=false)
     */
    private $libraryVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $comment = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="link", type="text", length=65535, nullable=true, options={"default"="NULL"})
     */
    private $link = 'NULL';

    /**
     * @var \Project
     *
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * })
     */
    private $project;


}
