<?php
namespace App\Controller;
use App\Entity\Material;
use App\Form\MaterialType;
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
use App\Repository\MaterialRepository;

/**
 * Movie controller.
 * @Route("/api", name="api_")
 */
class MaterialController extends AbstractFOSRestController
{

    
        /**
     * @Rest\Get("/allMaterial")
     * @return Response
     */
    public function criteria(Request $request)
    {
        $type = $request->query->get('type');
        $name = $request->query->get('name');
        $repository = $this->getDoctrine()->getRepository(Material::class);

        $material = $repository->getMaterialByTypaAndName($type,$name);

        return $this->handleView($this->view($material));

    }
    /**
     * @Rest\Post("/MaterialPhoto/{id}")
     * @param $id
     * @return Response
     */
    public function setPhoto(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $material = $repository->find($id);
        $data = json_decode($request->getContent(), true);
        $photo = $data['photo'];
        $material->setPhoto($photo);
        $em = $this->getDoctrine()->getManager();
        $em->remove($material);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }
        /**
     * Get a Material by ID.
     * @Rest\Get("/material/image/{id}")
     * @param $id
     * @return Response
     */
    public function getImageForMaterial($id)
    {
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $material = $repository->find($id);

        return $this->handleView($this->view(
            array("image"=>$material->getImageBase64())
        ));
    }
    /**
     * Get a Material by ID.
     * @Rest\Get("/material/{id}")
     * @param $id
     * @return Response
     */
    public function getMaterialById($id)
    {
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $materials = $repository->find($id);

        return $this->handleView($this->view($materials));
    }
    /**
     * Get a material by ID.
     * @Rest\Get("/MaterialNames")
     * @return Response
     */
    public function getMaterialNames()
    {
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $material = $repository->getMaterialNames();

        return $this->handleView($this->view($material));
    }

    /**
     * Create Movie.
     * @Rest\Post("/material")
     *
     * @return Response
     */
    public function addMaterial(Request $request)
    {
        $movie = new Material();
        $form = $this->createForm(MaterialType::class, $movie);
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
     * Update a Material.
     * @Rest\Put("/material/{id}")
     * @param $id
     * @return Response
     */
    public function updateMaterial(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $material = $this->getDoctrine()->getRepository(Material::class)->find($id);
        $data = json_decode($request->getContent(), true);

        $material->setName($data['name']);
        $material->setQuantity($data['quantity']);
        $material->setType($data['type']);
        $material->setImage($data['image']);

        $entityManager->flush();
        return $this->handleView($this->view(['status' => 'ok'], Response::HTTP_CREATED));
    }

    /**
     * Get a Material by ID.
     * @Rest\Delete("/material/{id}")
     * @param $id
     * @return Response
     */
    public function deleteMaterialById($id)
    {
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $material = $repository->find($id);
        if ($material == null) {
            return $this->handleView($this->view(['status' => 'KO'], Response::HTTP_BAD_REQUEST));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($material);
        $em->flush();
        return $this->handleView($this->view(['status' => 'OK'], Response::HTTP_OK));
    }
    /**
     * Count Material.
     * @Rest\Get("/countMaterial")
     * @return Response
     */
    public function getMaterialCount(MaterialRepository $mateialRepository){
        $repository = $this->getDoctrine()->getRepository(Material::class);
        $materialCount = $repository->countMaterial();
        return $this->handleView($this->view(array("MaterialCount"=>$materialCount)));
    }

}