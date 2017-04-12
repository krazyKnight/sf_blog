<?php

namespace Blog\ArticleBundle\Controller;

use Blog\ArticleBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogArticleBundle:Article');

        $articleList = $repository->listArticles($page);

        return $this->render('BlogArticleBundle:Default:index.html.twig', [
            'articleList'=>$articleList
        ]);
    }

    /**
     * @Template
     * @param $id
     * @return array
     */
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogArticleBundle:Article');

        $article = $repository->findOneBy([
            "slug"=>$slug,
            "statut"=>Article::STATE_PUBLISHED
        ]);

        return ["article"=>$article];
    }
}
