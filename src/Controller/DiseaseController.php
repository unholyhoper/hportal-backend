<?php
namespace App\Controller;
use App\Entity\Disease;
use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\DiseaseRepository;
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