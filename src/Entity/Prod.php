<?php

namespace App\Entity;

use App\Repository\ProdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: ProdRepository::class)]
class Prod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idProduit = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Le code produit ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Le code produit ne peut contenir que des lettres.'
    )]
    private ?string $codeproduit = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'La Description ne peut contenir que des lettres.'
    )]
    private ?string $des = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "L'unité ne peut pas être vide")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z]+$/',
        message: 'Lunité ne peut contenir que des lettres.'
    )]
    private ?string $idunite = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'La catégorie ne peut pas être vide')]
    private ?string $cat = null;

    #[ORM\Column(length: 150)]
    private ?string $image = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La quantité minimum ne peut pas être vide')]
    #[Assert\Type(type: 'integer', message: 'La quantité minimum doit être un entier')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'La quantité minimum doit être supérieure ou égale à zéro')]
    #[Assert\LessThanOrEqual(value: 999999, message: 'La quantité minimum ne peut pas être négative')]
    private ?int $qtemin = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'La quantité en stock ne peut pas être vide')]
    #[Assert\Type(type: 'integer', message: 'La quantité en stock doit être un entier')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'La quantité en stock doit être supérieure ou égale à zéro')]
    #[Assert\LessThanOrEqual(value: 999999, message: 'La quantité en stock ne peut pas être négative')]
    private ?int $qtestock = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le prix unitaire ne peut pas être vide')]
    #[Assert\Type(type: 'float', message: 'Le prix unitaire doit être un nombre décimal')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Le prix unitaire doit être supérieur ou égal à zéro')]
    #[Assert\LessThanOrEqual(value: 999999.99, message: 'Le prix unitaire ne peut pas être négatif')]
    private ?float $prixunitaire = null;

    /**
     * @ORM\ManyToMany(targetEntity=Categorie::class)
     * @ORM\JoinTable(
     *     name="prod_categories",
     *     joinColumns={@ORM\JoinColumn(name="prod_id", referencedColumnName="idProduit")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="categorie_id", referencedColumnName="idcategorie")}
     * )
     */
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function getCodeproduit(): ?string
    {
        return $this->codeproduit;
    }

    public function setCodeproduit(string $codeproduit): self
    {
        $this->codeproduit = $codeproduit;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(string $des): self
    {
        $this->des = $des;

        return $this;
    }

    public function getIdunite(): ?string
    {
        return $this->idunite;
    }

    public function setIdunite(?string $idunite): self
    {
        $this->idunite = $idunite;

        return $this;
    }

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQtemin(): ?int
    {
        return $this->qtemin;
    }

    public function setQtemin(int $qtemin): self
    {
        $this->qtemin = $qtemin;

        return $this;
    }

    public function getQtestock(): ?int
    {
        return $this->qtestock;
    }

    public function setQtestock(int $qtestock): self
    {
        $this->qtestock = $qtestock;

        return $this;
    }

    public function getPrixunitaire(): ?float
    {
        return $this->prixunitaire;
    }

    public function setPrixunitaire(float $prixunitaire): self
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }

   /**
 * @return Collection|Categorie[]
 */
public function getCategories(): Collection
{
    if (!isset($this->categories)) {
        $this->categories = new ArrayCollection();
    }
    return $this->categories;
}

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
