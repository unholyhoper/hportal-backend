<?php
namespace App\Controller;
use App\Entity\Medecine;
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
        if ($medecine==null){
            return $this->handleView($this->view(['status' => 'KO'], Response::HTTP_BAD_REQUEST));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }


//    /**
//     * Get a Medecine by ID.
//     * @Rest\PUT("/medecine/{id}")
//     * @param $id
//     * @return Response
//     */
//    public function editMedecineById(Request $request)
//    {
//        $data = json_decode($request->getContent(), true);
//
//
//    }

}