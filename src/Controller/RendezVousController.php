<?php
namespace App\Controller;
use App\Entity\Disease;
use App\Entity\RendezVous;
use App\Entity\Role;
use App\Entity\User;
use App\Form\RendezVousType;
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
class RendezVousController extends AbstractFOSRestController
{
    /**
     * Create Movie.
     * @Rest\Post("/appointment")
     *
     * @return Response
     */
    public function addmedecine(Request $request)
    {
        $movie = new RendezVous();
        $data = json_decode($request->getContent(), true);
        $movie->setDate(new \DateTime($data['date']));
        $movie->setDescription($data['description']);
        $movie->setPriority($data['priorite']);
        $movie->setStatus($data['status']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($movie);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));

    }
    /**
     * Lists all medecines.
     * @Rest\Get("/allAppointments")
     *
     * @return Response
     */
    public function allAppointments()
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }

    /**
     * Update a Medecine.
     * @Rest\Put("/appointment/{id}")
     * @param $id
     * @return Response
     */
    public function updateRendezVous(Request $request, $id)
    {


        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $data = json_decode($request->getContent(), true);
        var_dump($data);
        $medecine = $repository->find($id);
        $doctor=$data['doctor'];
        $user = $this->getDoctrine()->getRepository(User::class)->find($doctor['id']);
        $medecine->setDoctor($user);
        $medecine->setDate(new \DateTime($data['date']));
        $medecine->setPriority($data['priority']);
        $medecine->setStatus($data['status']);
        $medecine->setDescription($data['description']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

}