<?php

namespace Mediashare\ScriptBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Script
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Mediashare\ScriptBundle\Entity\ScriptRepository")
 */
class Script
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="thispath", type="string", length=255)
     */
    public $thispath;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="string", length=255, nullable=true)
     */
    private $payload;

    /**
     * @var string
     *
     * @ORM\Column(name="os", type="string", length=255, nullable=true)
     */
    private $os;

    /**
     * @var string
     *
     * @ORM\Column(name="host", type="string", length=255, nullable=true)
     */
    private $host;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Script
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Script
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set thispath
     *
     * @param string $thispath
     * @return Script
     */
    public function setThispath($thispath)
    {
        $this->thispath = $thispath;

        return $this;
    }

    /**
     * Get thispath
     *
     * @return string
     */
    public function getThispath()
    {
        return $this->thispath;
    }

    /**
     * Set payload
     *
     * @param string $payload
     * @return Script
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set os
     *
     * @param string $os
     * @return Script
     */
    public function setOs($os)
    {
        $this->os = $os;

        return $this;
    }

    /**
     * Get os
     *
     * @return string
     */
    public function getOs()
    {
        return $this->os;
    }

    /**
     * Set host
     *
     * @param string $host
     * @return Script
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Get host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return Script
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }
}
