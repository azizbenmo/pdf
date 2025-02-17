<?php

namespace App\Controller;

use App\Entity\Livreur;
use App\Form\Livreur1Type;
use App\Repository\LivreurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/livreur')]
final class LivreurController extends AbstractController
{
    #[Route(name: 'app_livreur_index', methods: ['GET'])]
    public function index(LivreurRepository $livreurRepository): Response
    {
        // Afficher tous les livreurs
        return $this->render('livreur/index.html.twig', [
            'livreurs' => $livreurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_livreur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        // Création d'un nouveau livreur
        $livreur = new Livreur();
        $form = $this->createForm(Livreur1Type::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Validation des données
            $errors = $validator->validate($livreur);

            if (count($errors) > 0) {
                // Si des erreurs de validation existent, nous les affichons
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            } else {
                // Sauvegarde du livreur dans la base de données si tout est valide
                $entityManager->persist($livreur);
                $entityManager->flush();

                return $this->redirectToRoute('app_livreur_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('livreur/new.html.twig', [
            'livreur' => $livreur,
            'form' => $form,
        ]);
    }

    #[Route('/{id_livreur}', name: 'app_livreur_show', methods: ['GET'])]
    public function show(Livreur $livreur): Response
    {
        // Charger les commandes associées au livreur
        // Assurez-vous que la relation OneToMany dans l'entité Livreur est correctement définie.
        $commandes = $livreur->getCommandes();  // Récupérer les commandes associées au livreur

        // Vérifier si des commandes sont présentes (optionnel, juste pour gestion d'erreur ou message)
        if (!$commandes) {
            $this->addFlash('notice', 'Ce livreur n\'a aucune commande associée.');
        }

        // Rendre la vue et passer le livreur et ses commandes associées
        return $this->render('livreur/show.html.twig', [
            'livreur' => $livreur,
            'commandes' => $commandes,  // Passer les commandes du livreur à la vue
        ]);
    }

    #[Route('/{id_livreur}/edit', name: 'app_livreur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Livreur $livreur, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        // Formulaire d'édition du livreur
        $form = $this->createForm(Livreur1Type::class, $livreur);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Validation des données
            $errors = $validator->validate($livreur);

            if (count($errors) > 0) {
                // Si des erreurs de validation existent, nous les affichons
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            } else {
                // Sauvegarder les modifications
                $entityManager->flush();

                return $this->redirectToRoute('app_livreur_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('livreur/edit.html.twig', [
            'livreur' => $livreur,
            'form' => $form,
        ]);
    }

    #[Route('/{id_livreur}', name: 'app_livreur_delete', methods: ['POST'])]
    public function delete(Request $request, Livreur $livreur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $livreur->getId_livreur(), $request->request->get('_token'))) {
            // Supprimer le livreur
            $entityManager->remove($livreur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_livreur_index', [], Response::HTTP_SEE_OTHER);
    }
}
