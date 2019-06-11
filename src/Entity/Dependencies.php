<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dependencies
 *
 * @ORM\Table(name="dependencies", uniqueConstraints={@ORM\UniqueConstraint(name="dependencies_project_id_uindex", columns={"project_id"}), @ORM\UniqueConstraint(name="dependencies_id_uindex", columns={"id"})})
 * @ORM\Entity
 */
class Dependencies
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
     * @var string|null
     *
     * @ORM\Column(name="library", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $library = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="version", type="string", length=10, nullable=true, options={"default"="NULL"})
     */
    private $version = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $state = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="to_library", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $toLibrary = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="to_version", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $toVersion = 'NULL';

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
