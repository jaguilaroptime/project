<?php
/**
 * Class Product
 * User: JAGUILAR
 * Date: 29/09/2016
 */

namespace AppBundle\Entity;


use AppBundle\Entity\ProductCategory;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @UniqueEntity("code", message="Este código ya existe en otro producto")
 * @UniqueEntity("name", message="Este nombre ya existe en otro producto")
 */
class Product
{
    const NUM_ITEMS = 5;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotBlank(
     *     message="El Código es un campo obligatorio"
     * )
     * @Assert\Regex(
     *     pattern="/^\w(\w)*(-{1})?(\w)*\w$/",
     *     match=true,
     *     message="El código no puede contener caracteres especiales ni espacios."
     * )
     * @Assert\Length(
     *     min = "4", max="10",minMessage="El código debe tener mínimo 4 caracteres y máximo 10."
     * )
     */
    private $code;
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(
     *     message="El nombre es un campo obligatorio"
     * )
     * @Assert\Length(
     *     min = "4", minMessage="El nombre debe contener mínimo 4 caracteres."
     * )
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *     message="La descripción es un campo obligatorio"
     * )
     */
    private $description;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(
     *     message="La marca es un campo obligatorio"
     * )
     */
    private $trademark;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ProductCategory")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     * @Assert\NotBlank(
     *     message="La Categoría es un campo obligatorio"
     * )
     */
    private $category;
    /**
     * @ORM\Column(type="float",precision=8,scale=2)
     * @Assert\NotBlank(
     *     message="El precio es un campo obligatorio"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="El precio debe ser un numero mayor a 0"
     * )
     * @Assert\Type(
     *     "numeric",
     *     message="El precio debe ser un número válido"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Por favor inserta una imagen al producto")
     * @Assert\File(mimeTypes={"image/png","image/jpeg"})
     */
    private $img;

    private $path;
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var
     * @ORM\Column(type="date")
     */
    private $birthday;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\Column(name="gender_code", type="string", length=5)
     */
    private $genderCode;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTrademark()
    {
        return $this->trademark;
    }

    /**
     * @param mixed $trademark
     */
    public function setTrademark($trademark)
    {
        $this->trademark = $trademark;
    }

    /**
     * @return ProductCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return product
     */
    public function setCategory(ProductCategory $category)
    {
        return $this->category = $category;
    }


    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getGenderCode()
    {
        return $this->genderCode;
    }

    /**
     * @param mixed $genderCode
     */
    public function setGenderCode($genderCode)
    {
        $this->genderCode = $genderCode;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    public function getWebPath()
    {
        // ... $webPath being the full image URL, to be used in templates
        $webPath = $this->path;
        return $webPath;
    }
}