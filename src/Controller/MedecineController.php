<?php

namespace App\Controller;

use App\Entity\Medecine;
use App\Entity\Role;
use App\Entity\User;
use App\Form\MedecineType;
use App\Repository\MedecineRepository;
use App\Repository\RoleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Form\UserType;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class MedecineController extends AbstractFOSRestController
{
    /**
     * Lists all medecines.
     * @Rest\Get("/allMedecines")
     *
     * @return Response
     */
    public function allMedecines()
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }

    /**
     * Get a Medecine by ID.
     * @Rest\Get("/medecine/{id}")
     * @param $id
     * @return Response
     */
    public function getMedecineById($id)
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $medecine = $repository->find($id);

        return $this->handleView($this->view($medecine));
    }


    /**
     * Get a Medecine by ID.
     * @Rest\Delete("/medecine/{id}")
     * @param $id
     * @return Response
     */
    public function deleteMedecineById($id)
    {
        echo $id;
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $medecine = $repository->find($id);
        if ($medecine == null) {
            return $this->handleView($this->view(['status' => 'KO'], Response::HTTP_BAD_REQUEST));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }

    /**
     * Create Movie.
     * @Rest\Post("/medecine")
     *
     * @return Response
     */
    public function addmedecine(Request $request)
    {
        $movie = new Medecine();
        $form = $this->createForm(MedecineType::class, $movie);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($movie);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }

    /**
     * Update a Medecine.
     * @Rest\Put("/medecine/{id}")
     * @param $id
     * @return Response
     */
    public function updateMedecine(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $data = json_decode($request->getContent(), true);
        $medecine = $repository->find($id);

        $medecine->setReference($data['reference']);
//        $medecine->setManufacturer($data['manufacturer']);
        $medecine->setReference($data['quantity']);
        $medecine->setReference($data['price']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    /**
     * Create Movie.
     * @Rest\Get("/countMedecines")
     * @return Response
     */
    public function getMedecinesCount(MedecineRepository $medecineRepository){
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $doctorCount = $repository->countMedecines();
//        $response = array("doctorCount"=>$doctorCount,
//        ));
        return $this->handleView($this->view(array("doctorCount"=>$doctorCount)));
    }
}