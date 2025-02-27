<?php

namespace App\Controller;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ForgotPasswordType;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
public function login(AuthenticationUtils $authenticationUtils): Response
{
    // Si l'utilisateur est déjà connecté, rediriger vers la page appropriée
    if ($this->getUser()) {
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('backvues'); // Redirection pour admin
        }

        return $this->redirectToRoute('app_user'); // Redirection pour client
    }

    // Récupérer l'erreur de connexion s'il y en a une
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error
    ]);
}


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/forgotPassword', name: 'app_forgetpassword')]
    public function testEmail(MailerInterface $mailer): Response
    {
        $email = (new TemplatedEmail())
            ->from(new Address('gharbi.selim@esprit.tn', 'Test'))
            ->to('gharbi.selim@esprit.tn' ) // Remplacez par une adresse e-mail valide
            ->subject('Test Email')
            ->text('Ceci est un test.');

        try {
            $mailer->send($email);
            return new Response('E-mail envoyé avec succès!');
        } catch (\Exception $e) {
            return new Response('Échec de l\'envoi de l\'e-mail: ' . $e->getMessage());
        }
    }




}
