<?php

namespace App\Controller;

use App\Entity\Disease;
use App\Entity\RendezVous;
use App\Entity\Role;
use App\Entity\User;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
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
        $movie->setPatient($this->getUser());
        $data = json_decode($request->getContent(), true);
        $movie->setDate(new \DateTime($data['date']));
        $movie->setDescription($data['description']);
        $movie->setPriority($data['priority']);
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
     * Update an appointment.
     * @Rest\Put("/appointment/{id}")
     * @param $id
     * @return Response
     */
    public function updateRendezVousByDoctor(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $data = json_decode($request->getContent(), true);
        var_dump($data);
        $medecine = $repository->find($id);
        $medecine->setDoctor($this->getUser());
        $medecine->setDate(new \DateTime($data['date']));
        $medecine->setPriority($data['priority']);
        $medecine->setStatus($data['status']);
        $medecine->setDescription($data['description']);
        $medecine->setDoctor($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($medecine);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * Lists all medecines.
     * @Rest\Get("/getAppointmentsForCurrentUser")
     *
     * @return Response
     */
    public function getAppointmentsForCurrentUser(RendezVousRepository $rendezVousRepository)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $movies = $repository->getAppointmentsForUser($this->getUser());
        return $this->handleView($this->view($movies));
    }

    /**
     * Lists all medecines.
     * @Rest\Put("/appointmentToCurrentUser/{id}")
     *
     * @return Response
     */
    public function appointToCurrentDoctor($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        $appointment->setDoctor($this->getUser());
        $em->persist($appointment);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_OK));

        return $this->handleView($this->view(['status' => 'KO'], Response::HTTP_BAD_REQUEST));

    }


    /**
     * Lists all medecines.
     * @Rest\Get("/appointment/{id}")
     *
     * @return Response
     */
    public function getAppointmentById($id)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        $dfirstName = null;
        $dlastName = null;
        if ($appointment->getDoctor() != null) {
            $dfirstName = $appointment->getDoctor()->getFirstName();
            $dlastName = $appointment->getDoctor()->getLastName();
        }
        $pfirstName = null;
        $plastName = null;
        if ($appointment->getPatient() != null) {
            $pfirstName = $appointment->getPatient()->getFirstName();
            $plastName = $appointment->getPatient()->getLastName();
        }

        return $this->handleView(
            $this->view(array(
                'id' => $appointment->getId(),
                'doctor_firstName' => $dfirstName,
                'doctor_lastName' => $dlastName,
                'patient_firstName' => $pfirstName,
                'patient_lastName' => $plastName,
                'date' => $appointment->getDate(),
                'priority' => $appointment->getPriority(),
                'status' => $appointment->getStatus(),
                'description' => $appointment->getDescription(),
            )));
    }

    /**
     * Lists all medecines.
     * @Rest\Get("/canAssignToHimself/{id}")
     *
     * @return Response
     */
    public function canAssignToHimself($id)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        $canAssign = false;
        if ($appointment->getDoctor() == null && in_array('ROLE_DOCTOR', $this->getUser()->getRoles())) {
            $canAssign = true;
        }
        return $this->handleView(
            $this->view(array(
                'canAssign' => $canAssign,

            )));
    }
    /**
     * Lists all medecines.
     * @Rest\Get("/canValidateAppointment/{id}")
     *
     * @return Response
     */
    public function canValidateAppointment($id)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        $canAssign = false;
        if ($appointment->getDoctor() == $this->getUser() && in_array('ROLE_DOCTOR', $this->getUser()->getRoles()) && $appointment->getStatus()=='PENDING') {
            $canAssign = true;
        }
        return $this->handleView(
            $this->view(array(
                'canValidate' => $canAssign,

            )));
    }
    /**
     * Lists all medecines.
     * @Rest\Get("/canReopenOppointment/{id}")
     *
     * @return Response
     */
    public function canReopenOppointment($id)
    {
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        $canAssign = false;
        if ($appointment->getPatient() == $this->getUser() && in_array('ROLE_USER', $this->getUser()->getRoles()) && $appointment->getStatus()=='REJECTED') {
            $canAssign = true;
        }
        return $this->handleView(
            $this->view(array(
                'canReopen' => $canAssign,

            )));
    }

    /**
     * Cancel an appointment.
     * @Rest\Put("/cancelAppointment/{id}")
     * @param $id
     * @return Response
     */
    public function cancelAppointmentForCurrentUser($id)
    {

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);


        $appointment->setStatus("CANCELED");

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * Lists all medecines.
     * @Rest\Get("/canReject/{id}")
     *
     * @return Response
     */
    public function canReject($id)
    {
        $canReject = false;

        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);
        if ($appointment->getDoctor() == $this->getUser() && ($appointment->getStatus()=="PENDING" ||$appointment->getStatus()=="REOPENED" ) ) {
            $canReject = true;
        }
        return $this->handleView(
            $this->view(array(
                'canReject' => $canReject,

            )));
    }


    /**
     * Cancel an appointment.
     * @Rest\Put("/rejectAppointment/{id}")
     * @param $id
     * @return Response
     */
    public function rejectAppointment($id)
    {

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);


        $appointment->setStatus("REJECTED");

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * Cancel an appointment.
     * @Rest\Put("/reopenAppointment/{id}")
     * @param $id
     * @return Response
     */
    public function reopenAppointment($id)
    {

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);


        $appointment->setStatus("REOPENED");

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }


    /**
     * Cancel an appointment.
     * @Rest\Put("/validateAppointment/{id}")
     * @param $id
     * @return Response
     */
    public function validateAppointment($id)
    {

        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(RendezVous::class);
        $appointment = $repository->find($id);


        $appointment->setStatus("IN FORCE");

        $em = $this->getDoctrine()->getManager();
        $em->persist($appointment);
        $em->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }
}