<?php
namespace App\Controller;
use App\Entity\User;
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
     * Lists all Users.
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
     * Get a user.
     * @Rest\Get("/user/{id}")
     *
     * @return Response
     */
    public function getUser(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $movies = $repository->find($id);
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
        $user = new User();
        dump($request->getContent());
        $form = $this->createForm(UserType::class, $user);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
        }
        return $this->handleView($this->view($form->getErrors()));
    }
}