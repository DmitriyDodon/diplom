<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @Route("/register", name="app_register", options={"sitemap" = { "section" = "pages" }})
     * @IsGranted("ROLE_MANAGER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @return Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler,
        LoginFormAuthenticator $authenticator
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $targetBack = $request->get('targetBack') ?: null;

        if ($form->isSubmitted()) {
            $existUser = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['username' => $form->get('username')->getData()]);
            if (!empty($existUser)) {
                $credentials['password'] = $form->get('plainPassword')->getData();
                $isCredentialsRight = $authenticator->checkCredentials($credentials, $existUser);
                if ($isCredentialsRight) {
                    try {
                        $guardHandler->authenticateUserAndHandleSuccess(
                            $existUser,
                            $request,
                            $authenticator,
                            'main' // firewall name in security.yaml
                        );
                        if ($targetBack !== null) {
                            return $this->redirect($targetBack);
                        }
                        return $this->redirectToRoute('index');
                    } catch (Exception $exception) {
                        $this->logger->error($exception->getMessage());
                    }
                }
            }
        }


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            try {
//                if ($user->getUsername() && filter_var($user->getUsername(), FILTER_VALIDATE_EMAIL)) {
//                    $this->mailingService->sendMessage(
//                        $user->getUsername(),
//                        'Welcome ME-QR',
//                        '',
//                        'email/creating_qr_email/email_welcome.twig'
//                    );
//                }
                // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                    ->from(new Address('registration@me-qr.com', 'Me-QR Code Service'))
//                    ->to($user->getUsername())
//                    ->subject('Please Confirm your Email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
                // do anything else you need here, like send an email
                $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            } catch (Exception $exception) {
                $this->logger->error($exception->getMessage());
            }
            if ($targetBack !== null){
                $response = $this->redirect($targetBack);
            }else{
                $response = $this->redirectToRoute('index');
            }

            $response->headers->setCookie(new Cookie('qrCodes', null, strtotime('now + 1 year'), '/'));

            return $response;
        }


        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'targetBack' => $targetBack
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
//        try {
//            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
//        } catch (VerifyEmailExceptionInterface $exception) {
//            $this->addFlash('verify_email_error', $exception->getReason());
//
//            return $this->redirectToRoute('app_register');
//        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
