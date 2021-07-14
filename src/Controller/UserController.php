<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Criteria;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Form\UserType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
     * @Rest\Post("/user/add")
     *
     * @return Response
     */
    public function postUser(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        $movie = new User();


        $form = $this->createForm(UserType::class, $movie);
        $data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();


        $movie->setPassword($passwordEncoder->encodePassword($movie, $data['password']));
        $orgDate =  $data['birthDate']['day']."-".$data['birthDate']['month']."-".$data['birthDate']['year'];
        $date=date_create( $orgDate);
        $movie->setBirthDate($date);
        $movie->setUsername($data['username']);
        $movie->setFirstName($data['firstname']);
        $movie->setLastName($data['lastname']);
        $movie->setCin($data['cin']);
        $movie->setEmail($data['email']);
        $movie->setAddress($data['address']);
        $movie->setCountry($data['country']);
        $movie->setPhone($data['phone']);
        $movie->setMedicalSerial($data['medicalSerial']);
        $movie->setRoles(array($data['role']));
        //todo medical serial
        $movie->setMedicalSerial(9999);
        $em->persist($movie);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));

        return $this->handleView($this->view($form->getErrors()));
    }


    /**
     * Create Movie.
     * @Rest\Get("/currentUser")
     * @param $id
     * @return Response
     */
    public function getCurrentUser()
    {
        $user = $this->getUser();
        return $this->handleView(
            $this->view(array(
                'id' => $user->getId(),
                'user_firstName' => $user->getFirstName(),
                'user_firstName' => $user->getFirstName(),
                'cin' => $user->getCin(),
                'address' => $user->getAddress(),
                'country' => $user->getCountry(),
                'email' => $user->getEmail(),
                'phone' => $user->getPhone(),
            ))
        );
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
        return $this->handleView($this->view(array('doctorCount' => $doctorCount,
            'delegateCount' => $delegateCount,
            'clientCount' => $clientCount,
        )));
    }

    /**
     * Create Movie.
     * @Rest\Put("/user")
     * @return Response
     */
    public function updateCurrentUser(Request $request)
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $user->setUsername($data['userName']);
        $user->setPassword($data['password']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setCin($data['cin']);
        $user->setAddress($data['address']);
        $user->setCountry($data['country']);
        $user->setEmail($data['email']);
        $user->setPhone($data['phone']);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }


    /**
     * Lists all Movies.
     * @Rest\Get("/user/doctors")
     *
     * @return Response
     */
    public function getAllDoctors()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
            $usersArray = array_filter(
                $users,
                function ($user) {
                    return $user->getRoles()[0]== 'ROLE_DOCTOR';
                });
        return $this->handleView($this->view($usersArray));
    }

    /**
     * Lists all Movies.
     * @Rest\Get("/user/users")
     *
     * @return Response
     */
    public function getAllUsers()
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
            $usersArray = array_filter(
                $users,
                function ($user) {
                    return $user->getRoles()[0]== 'ROLE_DOCTOR';
                });
        return $this->handleView($this->view($usersArray));
    }




}