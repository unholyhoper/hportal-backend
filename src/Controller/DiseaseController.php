<?php
namespace App\Controller;
use App\Entity\Disease;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\DiseaseRepository;
use App\Form\DiseaseType;
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
class DiseaseController extends AbstractFOSRestController
{

    /**
     * Lists all medecines.
     * @Rest\Get("/allDiseases")
     *
     * @return Response
     */
    public function allMedecines()
    {
        $repository = $this->getDoctrine()->getRepository(Disease::class);
        $diseases = $repository->findall();
        return $this->handleView($this->view($diseases));
    }
    /**
     * Get a Medecine by ID.
     * @Rest\Get("/disease/{id}")
     * @param $id
     * @return Response
     */
    public function getDiseaseById($id)
    {
        $repository = $this->getDoctrine()->getRepository(Disease::class);
        $disease = $repository->find($id);

        return $this->handleView($this->view($disease));
    }
    /**
     * Get a Medecine by ID.
     * @Rest\Get("/diseaseNames")
     * @return Response
     */
    public function getDiseaseNames()
    {
        $repository = $this->getDoctrine()->getRepository(Disease::class);
        $disease = $repository->getDiseasesNames();

        return $this->handleView($this->view($disease));
    }
    /**
     * Update a Material.
     * @Rest\Put("/disease/{id}")
     * @param $id
     * @return Response
     */
    public function updatedisease(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $disease = $this->getDoctrine()->getRepository(Disease::class)->find($id);
        $data = json_decode($request->getContent(), true);

        $disease->setName($data['name']);
        $disease->setDescription($data['description']);

        $entityManager->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
    /**
     * Create Movie.
     * @Rest\Post("/disease")
     *
     * @return Response
     */
    public function addMaterial(Request $request)
    {
        $disease = new Disease();
        $form = $this->createForm(DiseaseType::class, $disease);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($disease);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
    /**
     * Get a Disease by ID.
     * @Rest\Delete("/disease/{id}")
     * @param $id
     * @return Response
     */
    public function deleteDiseaseById($id)
    {
        $repository = $this->getDoctrine()->getRepository(Disease::class);
        $disease = $repository->find($id);
        if ($disease == null) {
            return $this->handleView($this->view(['status' => 'KO'], Response::HTTP_BAD_REQUEST));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($disease);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }
    /**
     * Count Material.
     * @Rest\Get("/countDisease")
     * @return Response
     */
    public function getDieseaseCount(DiseaseRepository $diseaseRepository){
        $repository = $this->getDoctrine()->getRepository(Disease::class);
        $DieseaseCount = $repository->countDiesease();
        return $this->handleView($this->view(array("DiseaseCount"=>$DieseaseCount)));
    }

}