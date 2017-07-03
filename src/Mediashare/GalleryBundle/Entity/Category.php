<?php

namespace Mediashare\GalleryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Mediashare\AdminBundle\Entity\File;

/**
 * Category
 *
 * @ORM\Table(name="gallery_category")
 * @ORM\Entity
 */
class Category
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
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $childrens;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="childrens")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="deep", type="integer", nullable=true)
     */
    private $deep;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Assert\Length(
     *      max = "25",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean")
     */
    private $online;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;


    /**
     * @ORM\OneToMany(targetEntity="Gallery", mappedBy="category")
     * @ORM\OrderBy({"position" = "ASC"})
     **/
    private $galleries;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Mediashare\AdminBundle\Entity\File", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="gallery_category_file",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    public $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->title;
    }


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
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($this->title);
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Set online
     *
     * @param boolean $online
     * @return Category
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean 
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug =  $this->slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }


    public function getSlugParent()
    {
        if(!$this->parent)
        {
            return "root";
        }
        return $this->parent->getSlug();
    }


    public function addGallery(Gallery $gallery)
    {
        $this->galleries->add($gallery);

        return $this;
    }

    public function removeGallery(Gallery $gallery)
    {
        $this->galleries->remove($gallery);

        return $this;
    }

    public function getGalleries()
    {
        return $this->galleries;
    }

    /**
     * Add Pictures
     *
     * @param File $picture
     * @return Category
     */
    public function addPicture(File $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    public function removePicture(File $picture)
    {
        $this->pictures->removeElement($picture);
    }

    public function getPictures()
    {
        return $this->pictures;
    }


    /**
     * Set parent
     *
     * @param string $parent
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function addChildren(Category $children)
    {
        $this->childrens[] = $children;

        $children->setParent($this);

        return $this;
    }

    public function removeChildren(Category $children)
    {
        $this->childrens->removeElement($children);
        $children->setParent(null);
    }

    public function getChildrens()
    {
        return $this->childrens;
    }


    /**
     * Set deep
     *
     * @param integer $deep
     * @return Category
     */
    public function setDeep($deep)
    {
        $this->deep = $deep;

        return $this;
    }

    /**
     * Get deep
     *
     * @return integer
     */
    public function getDeep()
    {
        return $this->deep;
    }

}
