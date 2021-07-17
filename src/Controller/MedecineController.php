<?php

namespace App\Controller;

use App\Entity\Medecine;
use App\Entity\Role;
use App\Entity\User;
use App\Form\MedecineType;
use App\Repository\MedecineRepository;
use App\Repository\RoleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
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
        $entityManager = $this->getDoctrine()->getManager();
        $medecine = $this->getDoctrine()->getRepository(Medecine::class)->find($id);
        $data = json_decode($request->getContent(), true);

        $medecine->setReference($data['reference']);
//        $medecine->setManufacturer($data['manufacturer']);
        $medecine->setQuantity($data['quantity']);
        $medecine->setPrice($data['price']);
        $medecine->setImage($data['price']);

        $entityManager->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    /**
     * Count Medecines.
     * @Rest\Get("/countMedecines")
     * @return Response
     */
    public function getMedecinesCount(MedecineRepository $medecineRepository){
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $doctorCount = $repository->countMedecines();
        return $this->handleView($this->view(array("doctorCount"=>$doctorCount)));
    }


    /**
     * @Rest\Get("/allMedecines")
     * @return Response
     */
    public function criteria(Request $request)
    {
        $manufacturer = $request->query->get('manufacturer');
        $reference = $request->query->get('reference');
        $repository = $this->getDoctrine()->getRepository(Medecine::class);

        $medecines = $repository->getMedecinesByManufacturerAndReference($manufacturer,$reference);

        return $this->handleView($this->view($medecines));

    }

    /**
     * @Rest\Post("/medecinePhoto/{id}")
     * @param $id
     * @return Response
     */
    public function setPhoto(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $medecine = $repository->find($id);
        $data = json_decode($request->getContent(), true);
        $photo = $data['photo'];
        $medecine->setPhoto($photo);
        $em = $this->getDoctrine()->getManager();
        $em->remove($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }

    /**
     * Get a Medecine by ID.
     * @Rest\Get("/medecine/image/{id}")
     * @param $id
     * @return Response
     */
    public function getImageForMedecine($id)
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $medecine = $repository->find($id);

        return $this->handleView($this->view(
            array("image"=>$medecine->getImageBase64())
        ));
    }

    /**
     * Get a Medecine by Name.
     * @Rest\Get("/medecinesNames")
     * @return Response
     */
    public function getMedecinesNames()
    {
        $repository = $this->getDoctrine()->getRepository(Medecine::class);
        $medecines = $repository->getMedecineNames();

        return $this->handleView($this->view($medecines));
    }
}