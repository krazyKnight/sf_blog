<?php

namespace Blog\ArticleBundle\Controller;

use Blog\ArticleBundle\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addPostAction(Request $request)
    {
        // Dans un premier temps, on vérifie les droits
        /*if (!$this->get('security.AuthorizationChecker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('FORBIDEN');
        }*/


        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::class)
            ->add('contenu', TextareaType::class)
            ->add('datePublication', DateType::class)
            ->add('statut', ChoiceType::class, [
                'choices'=> [
                    'Publié' => Article::STATE_PUBLISHED,
                    'Brouillon' => Article::STATE_DRAFT
                ],
                'choices_as_values' => true
            ])
            ->add('auteur', EntityType::class, [
                'class' => 'BlogArticleBundle:Auteur'
            ])
            ->add('valider', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je procède à l'enregistrement en BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $session = $request->getSession();
            $session->getFlashBag()->add('success', 'Votre article a bien été inséré');

            return $this->redirectToRoute('blog_article_view', ['slug'=>$article->getSlug()]);
        }

        return $this->render('BlogArticleBundle:Admin:add_post.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
