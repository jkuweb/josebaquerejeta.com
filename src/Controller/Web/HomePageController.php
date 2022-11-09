<?php 

namespace App\Controller\Web;

use App\Mailer\Mailer;
use App\Mailer\TwigTemplate;
use App\Form\ContactFormType;
use App\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Http\ValidateCaptchaTokenInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController 
{
    private ValidateCaptchaTokenInterface $validateCaptchaToken;

    public function __construct(ValidateCaptchaTokenInterface $validateCaptchaToken)
    {
        $this->validateCaptchaToken = $validateCaptchaToken;
    }

    #[Route('/', name: 'web_inicio')]
    public function __invoke(Request $request, Mailer $mailer): Response
    {
        $httpReferer = $request->server->get("HTTP_REFERER")."#contact";
        $message = new ContactMessage();
        $form = $this->createForm(ContactFormType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = ($request->request->get('g-recaptcha-response'));
            $this->validateCaptchaToken->__invoke($token); 
            if(!$token) {
                $this->addFlash('email-error-notice', '¡Ha ocurrido un error!');
                return $this->redirect($httpReferer);

            }
            
            $message = $form->getData();
            $payload = [
                'name' => $message->getName(),
                'subject' => $message->getSubject(),
                'email' => $message->getEmail(),
                'message' => $message->getMessage()
            ];
            $reciver = $message->getEmail();
            $template = TwigTemplate::NOTIFICATION_TO_USER_CONTACT_EMAIL_RECEIVED;


            $mailer->send($reciver, $template, $payload);
            $this->addFlash('email-success-notice', '¡Email recibido!');

            return $this->redirect($httpReferer);
        }
        
        return $this->render('web/homepage.html.twig', [
            'contactForm' => $form->createView()
        ]);
        
    }
  
}

