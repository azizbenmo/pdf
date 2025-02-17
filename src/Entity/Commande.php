<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCommande = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: "Le statut de la commande est obligatoire.")]
    #[Assert\Choice(choices: ["En attente", "Validée", "Expédiée", "Livrée", "Annulée"], message: "Statut invalide.")]
    private ?string $statutCommande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "La date de commande est obligatoire.")]
    #[Assert\Type("\DateTimeInterface", message: "Veuillez entrer une date valide.")]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Assert\NotBlank(message: "Le produit est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom du produit ne peut pas dépasser 255 caractères.")]
    private ?string $produit = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank(message: "Le prix est obligatoire.")]
    #[Assert\Positive(message: "Le prix doit être un nombre positif.")]
    private ?int $prix = null;

    #[ORM\ManyToOne(targetEntity: Livreur::class)]
    #[ORM\JoinColumn(name: "id_livreur", referencedColumnName: "id_livreur", nullable: false)]
    #[Assert\NotNull(message: "Un livreur doit être assigné à la commande.")]
    private ?Livreur $livreur = null;

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getStatutCommande(): ?string
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(string $statutCommande): static
    {
        $this->statutCommande = $statutCommande;
        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getProduit(): ?string
    {
        return $this->produit;
    }

    public function setProduit(string $produit): static
    {
        $this->produit = $produit;
        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): static
    {
        $this->livreur = $livreur;
        return $this;
    }
}
