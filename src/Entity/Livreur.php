<?php
namespace App\Entity;

use App\Repository\LivreurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_livreur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom du livreur ne peut pas être vide.")]
    #[Assert\Length(min: 2, max: 100, minMessage: "Le nom doit comporter au moins {{ limit }} caractères.", maxMessage: "Le nom ne peut pas dépasser {{ limit }} caractères.")]
    private ?string $nom_livreur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom du livreur ne peut pas être vide.")]
    private ?string $prenom_livreur = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas un email valide.")]
    #[Assert\NotBlank(message: "L'email du livreur ne peut pas être vide.")]
    private ?string $mail_livreur = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: "/^\d{8}$/",
        message: "Le numéro de téléphone doit être composé uniquement de 8 chiffres."
    )]
    private ?int $telephone_livreur = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "La disponibilité du livreur doit être précisée.")]
    private ?bool $disponible = null;

    // Getter et Setter pour l'ID
    public function getIdLivreur(): ?int
    {
        return $this->id_livreur;
    }

    // Getter et Setter pour le nom
    public function getNomLivreur(): ?string
    {
        return $this->nom_livreur;
    }

    public function setNomLivreur(string $nom_livreur): static
    {
        $this->nom_livreur = $nom_livreur;
        return $this;
    }

    // Getter et Setter pour le prénom
    public function getPrenomLivreur(): ?string
    {
        return $this->prenom_livreur;
    }

    public function setPrenomLivreur(string $prenom_livreur): static
    {
        $this->prenom_livreur = $prenom_livreur;
        return $this;
    }

    // Getter et Setter pour le mail
    public function getMailLivreur(): ?string
    {
        return $this->mail_livreur;
    }

    public function setMailLivreur(string $mail_livreur): static
    {
        $this->mail_livreur = $mail_livreur;
        return $this;
    }

    // Getter et Setter pour le téléphone
    public function getTelephoneLivreur(): ?int
    {
        return $this->telephone_livreur;
    }

    public function setTelephoneLivreur(int $telephone_livreur): static
    {
        $this->telephone_livreur = $telephone_livreur;
        return $this;
    }

    // Getter et Setter pour la disponibilité
    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): static
    {
        $this->disponible = $disponible;
        return $this;
    }

    // Relation OneToMany avec l'entité Commande
    #[ORM\OneToMany(mappedBy: "livreur", targetEntity: Commande::class)]
    private iterable $commandes;

    public function getCommandes(): iterable
    {
        return $this->commandes;
    }
}

