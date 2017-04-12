<?php

namespace Blog\UserBundle\Controller;

use Stof\DoctrineExtensionsBundle\DependencyInjection\Compiler\SecurityContextPass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class DefaultController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('BlogUserBundle:Default:login.html.twig', [
            'error' => $error,
            'lastUsername' => $session->get(Security::LAST_USERNAME)
        ]);
    }
}
