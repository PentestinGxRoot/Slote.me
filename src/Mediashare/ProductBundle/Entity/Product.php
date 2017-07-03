<?php

namespace Mediashare\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Mediashare\AdminBundle\Entity\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Mediashare\ProductBundle\Entity\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product
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
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @ORM\Column(type="string")
     */
    protected $slug;


    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="reference", type="string", length=255,  nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var string

     * @ORM\Column(name="promotion_price", type="integer", nullable=true)
     */
    private $promotionPrice;

    /**
     * @var string
     * @Assert\Length(
     *      max = "255",
     *      maxMessage = "Ce champs ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="url_link", type="string", length=255,  nullable=true)
     */
    private $urlLink;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */

    private $position;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean", nullable=true)
     */
    private $online;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promotion_start_date", type="date", nullable=true)
     */
    private $promotionStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="promotion_end_date", type="date", nullable=true)
     */
    private $promotionEndDate;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Mediashare\AdminBundle\Entity\File", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="product_file",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    public $pictures;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="date")
     */
    private $updateDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="date")
     */
    private $createDate;


    /**
     * @Assert\NotBlank(message="Veuillez renseigner ce champs")
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;


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
     * @return Product
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
     * Set promotionPrice
     *
     * @param string $promotionPrice
     * @return Product
     */
    public function setPromotionPrice($promotionPrice)
    {
        $this->promotionPrice = $promotionPrice;

        return $this;
    }

    /**
     * Get promotionPrice
     *
     * @return string
     */
    public function getPromotionPrice()
    {
        return $this->promotionPrice;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Set reference
     *
     * @param string $reference
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set urlLink
     *
     * @param string $urlLink
     * @return Product
     */
    public function setUrlLink($urlLink)
    {
        $this->urlLink = $urlLink;

        return $this;
    }

    /**
     * Get urlLink
     *
     * @return string
     */
    public function getUrlLink()
    {
        return $this->urlLink;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Product
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()

    {
        return $this->category;
    }

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Product
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
     * Set online
     *
     * @param boolean $online
     * @return Product
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
     * Set promotionStartDate
     *
     * @param \DateTime $promotionStartDate
     * @return Product
     */
    public function setPromotionStartDate($promotionStartDate)
    {
        $this->promotionStartDate = $promotionStartDate;

        return $this;
    }

    /**
     * Get promotionStartDate
     *
     * @return \DateTime
     */
    public function getPromotionStartDate()
    {
        return $this->promotionStartDate;
    }

    /**
     * Set promotionEndDate
     *
     * @param \DateTime $promotionEndDate
     * @return Product
     */
    public function setPromotionEndDate($promotionEndDate)
    {
        $this->promotionEndDate = $promotionEndDate;

        return $this;
    }

    /**
     * Get promotionEndDate
     *
     * @return \DateTime
     */
    public function getPromotionEndDate()
    {
        return $this->promotionEndDate;
    }


    /**
     * Add Pictures
     *
     * @param File $picture
     * @return Product
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
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return Product
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return Product
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        if (null == $this->createDate) {
            $this->createDate = new \DateTime();
        }
        $this->updateDate = new \DateTime();
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
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

}
