<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
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
 */
class RegisterController extends AbstractFOSRestController
{
    /**
     * Create Movie.
     * @Rest\Post("/register")
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
}