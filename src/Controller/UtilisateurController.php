<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Form\VendorType; // Ajoutez cette ligne

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
#[Route('/utilisateur')]
final class UtilisateurController extends AbstractController
{
    #[Route(name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $utilisateurRepository->createQueryBuilder('u')->getQuery();
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Page actuelle
            3 // Nombre d'utilisateurs par page
        );

        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, 'monmotdepasse');
            $utilisateur->setPassword($hashedPassword);

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id_user<\d+>}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(int $id_user, UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur = $utilisateurRepository->find($id_user);

        if (!$utilisateur) {
            throw $this->createNotFoundException("Utilisateur non trouvé");
        }

        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id_user}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/utilisateur/{id_user}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getIdUser(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (empty($utilisateur->getRoles())) {
                $utilisateur->setRoleUser('ROLE_CLIENT');
            }

            // Hachage du mot de passe avant de sauvegarder
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($hashedPassword);

            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('frontend/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/test-email', name: 'app_test_email')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from(new Address('gharbi.selim@esprit.tn', 'Test'))
            ->to('gharbi.selim01@gmail.com' ) // Remplacez par une adresse e-mail valide
            ->subject('Test Email')
            ->text('Ceci est un test.');

        try {
            $mailer->send($email);
            return new Response('E-mail envoyé avec succès!');
        } catch (\Exception $e) {
            return new Response('Échec de l\'envoi de l\'e-mail: ' . $e->getMessage());
        }
    }
    #[Route('/inscription-vendeur', name: 'app_inscription_vendeur')]
    public function inscriptionVendeur(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(VendorType::class, $utilisateur);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Définir le rôle et le statut spécifiques
            $utilisateur->setRoleUser('ROLE_VENDOR');
            $utilisateur->setIsActive(false); // Désactiver jusqu'à validation
    
            // Hachage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($utilisateur, $utilisateur->getMotDePasseUser());
            $utilisateur->setMotDePasseUser($hashedPassword);
    
            $entityManager->persist($utilisateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_login');
        }
    
        return $this->render('frontend/inscriptionV.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}