<?php
namespace App\Controller;
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
class UserController extends AbstractFOSRestController
{
    /**
     * Lists all Movies.
     * @Rest\Get("/users")
     *
     * @return Response
     */
    public function getUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $movies = $repository->findall();
        return $this->handleView($this->view($movies));
    }
    /**
     * Create Movie.
     * @Rest\Post("/user")
     *
     * @return Response
     */
    public function postUser(Request $request)
    {
        $movie = new User();
        $form = $this->createForm(UserType::class, $movie);
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
     * Create Movie.
     * @Rest\Get("/user/{id}")
     * @param $id
     * @return Response
     */
    public function getUserById($id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        return $this->handleView($this->view($user));
    }

    /**
     * Create Movie.
     * @Rest\Get("/countRoles")
     * @param $id
     * @return Response
     */
    public function getcountRoles(RoleRepository $roleRepository)
    {
        $repository = $this->getDoctrine()->getRepository(Role::class);
        $delegateCount = $roleRepository->countDelegate();
        $doctorCount = $roleRepository->countDoctors();
        $clientCount = $roleRepository->countClient();
        return $this->handleView($this->view(array('doctorCount'=>$doctorCount,
            'delegateCount'=>$delegateCount,
            'clientCount'=>$clientCount,
        )));
    }


}