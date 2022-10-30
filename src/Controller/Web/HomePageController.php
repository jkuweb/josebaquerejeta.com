<?php 

namespace App\Controller\Web;

use App\Mailer\Mailer;
use App\Mailer\TwigTemplate;
use App\Form\ContactFormType;
use App\Entity\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController 
{
    #[Route('/', name: 'web_inicio')]
    public function __invoke(Request $request, Mailer $mailer): Response
    {
        $message = new ContactMessage();
        $form = $this->createForm(ContactFormType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $httpReferer = $request->server->get("HTTP_REFERER")."#contact";
            return $this->redirect($httpReferer);
        }
        
        return $this->render('web/homepage.html.twig', [
            'contactForm' => $form->createView()
        ]);
        
    }
  
}

