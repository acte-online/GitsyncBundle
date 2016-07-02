<?php

namespace GitsyncBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gitsync
 *
 * @ORM\Table(name="gitsync")
 * @ORM\Entity(repositoryClass="GitsyncBundle\Repository\GitsyncRepository")
 */
class Gitsync
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reponame", type="string", length=255)
     */
    private $reponame;

    /**
     * @var string
     *
     * @ORM\Column(name="dirclone", type="string", length=255)
     */
    private $dirclone;

    /**
     * @var string
     *
     * @ORM\Column(name="dirrepo", type="string", length=255)
     */
    private $dirrepo;

    /**
     * @var string
     *
     * @ORM\Column(name="chwuclone", type="string", length=255)
     */
    private $chwuclone;

    /**
     * @var string
     *
     * @ORM\Column(name="chwgclone", type="string", length=255)
     */
    private $chwgclone;

    /**
     * @var string
     *
     * @ORM\Column(name="chwurepo", type="string", length=255)
     */
    private $chwurepo;

    /**
     * @var string
     *
     * @ORM\Column(name="chwgrepo", type="string", length=255)
     */
    private $chwgrepo;

    /**
     *
     * @ORM\Column(name="dateupdate", type="datetime", nullable=true)
     */
    private $dateupdate;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reponame
     *
     * @param string $reponame
     *
     * @return Gitsync
     */
    public function setReponame($reponame)
    {
        $this->reponame = $reponame;

        return $this;
    }

    /**
     * Get reponame
     *
     * @return string
     */
    public function getReponame()
    {
        return $this->reponame;
    }

    /**
     * Set dirclone
     *
     * @param string $dirclone
     *
     * @return Gitsync
     */
    public function setDirclone($dirclone)
    {
        $this->dirclone = $dirclone;

        return $this;
    }

    /**
     * Get dirclone
     *
     * @return string
     */
    public function getDirclone()
    {
        return $this->dirclone;
    }

    /**
     * Set dirrepo
     *
     * @param string $dirrepo
     *
     * @return Gitsync
     */
    public function setDirrepo($dirrepo)
    {
        $this->dirrepo = $dirrepo;

        return $this;
    }

    /**
     * Get dirrepo
     *
     * @return string
     */
    public function getDirrepo()
    {
        return $this->dirrepo;
    }

    /**
     * Set chwuclone
     *
     * @param string $chwuclone
     *
     * @return Gitsync
     */
    public function setChwuclone($chwuclone)
    {
        $this->chwuclone = $chwuclone;

        return $this;
    }

    /**
     * Get chwuclone
     *
     * @return string
     */
    public function getChwuclone()
    {
        return $this->chwuclone;
    }

    /**
     * Set chwgclone
     *
     * @param string $chwgclone
     *
     * @return Gitsync
     */
    public function setChwgclone($chwgclone)
    {
        $this->chwgclone = $chwgclone;

        return $this;
    }

    /**
     * Get chwgclone
     *
     * @return string
     */
    public function getChwgclone()
    {
        return $this->chwgclone;
    }

    /**
     * Set chwurepo
     *
     * @param string $chwurepo
     *
     * @return Gitsync
     */
    public function setChwurepo($chwurepo)
    {
        $this->chwurepo = $chwurepo;

        return $this;
    }

    /**
     * Get chwurepo
     *
     * @return string
     */
    public function getChwurepo()
    {
        return $this->chwurepo;
    }

    /**
     * Set chwgrepo
     *
     * @param string $chwgrepo
     *
     * @return Gitsync
     */
    public function setChwgrepo($chwgrepo)
    {
        $this->chwgrepo = $chwgrepo;

        return $this;
    }

    /**
     * Get chwgrepo
     *
     * @return string
     */
    public function getChwgrepo()
    {
        return $this->chwgrepo;
    }

    /**
     * Set dateupdate
     *
     * @param \DateTime $dateupdate
     *
     * @return Gitsync
     */
    public function setDateupdate($dateupdate)
    {
        $this->dateupdate = $dateupdate;

        return $this;
    }

    /**
     * Get dateupdate
     *
     * @return \DateTime
     */
    public function getDateupdate()
    {
        return $this->dateupdate;
    }
}
