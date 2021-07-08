<?php
namespace App\Controller;
use App\Entity\Disease;
use App\Entity\Role;
use App\Entity\User;
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

}