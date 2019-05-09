<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Movie controller.
 * @Rest\Route("/api/articles", name="api_article")
 */

class JournalController extends AbstractFOSRestController
{

    /**
     * Liste tout les article
     * @Rest\Get("/")
     */

    public function getAllCars()
    {
        $cars = $this->getDoctrine()->getRepository(Article::class)->findall();
        return $cars;
    }

    /**
     *
     * Retourne un article
     * @Rest\Get("/{id}")
     */
    public function getCar(int $id)
    {
        $article = $repository = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if(is_null($article)){
            throw new HttpException(404, "Car #".$idCar.' n\'existe pas');
        }
        return $article;
    }

    /**
     * Ajoute un article
     * @Rest\Post("/")
     *
     */
    public function postCar(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ArticleType::class, new Article());
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article = $form->getData();
            $em->persist($article);
            $em->flush();
            return $article;
        } else{
            return $form->getErrors();
        }
    }

    /**
     *
     * Modifie un article
     * @Rest\Put("/{id}")
     */
    public function putCar(Request $request, int $id)
    {
        $article = $repository = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if(is_null($article)){
            throw new HttpException(404, "Marque #".$idCar.'n\'existe pas');
        }
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article = $form->getData();
            $em->persist($article);
            $em->flush();
            return $article;
        } else{
            return $form->getErrors();
        }
    }

    /**
     * Supprime un article
     * @Rest\Delete("/{id}")
     */
    public function deleteCar(Request $request, int $id)
    {
        $article = $repository = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if(is_null($article)){
            throw new HttpException(404, "Marque #".$id.'n\'existe pas');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return 'Deleted Successfully';
    }
}
