<?php
namespace App\Controller;

use App\Encoder\MultipartDecoder;
use App\Entity\Oeuvre;
use App\Form\AjouterType;
use App\Repository\OeuvreRepository;
use App\Serializer\UploadedFileDenormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/admin/oeuvre")
 *
 */
class AdminOeuvreController extends AbstractController
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator=$validator;
    }
    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(OeuvreRepository $oeuvreRepo)
    {
      return $this->json($oeuvreRepo->findAll(),200,['groups'=>'read:article']);
    }


    /**
 * @Route("/", name="admin_ajouter", methods={"POST"})
 */
public function ajouter(Request $request,EntityManagerInterface $entityManager):JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if (
        isset($data['titre']) &&
        isset($data['description'])
    ) {
        $oeuvre = new Oeuvre();
        $oeuvre->setTitre($data['titre']);
        $oeuvre->setDescription($data['description']);

        // Gestion de l'image
        if ($request->files->has('image')) {
            $uploadedFile = $request->files->get('image');
            $destination = $this->getParameter('  image_oeuvre_directory'); // Obtenez le répertoire d'upload configuré
            $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($destination, $newFilename);
            $oeuvre->setImage($newFilename);
        }

        // Autres champs à traiter et à assigner à l'entité Oeuvre

        // Enregistrement de l'objet Oeuvre en base de données
        $entityManager->persist($oeuvre);
        $entityManager->flush();

        return $this->json(['message' => 'L\'oeuvre a été créée avec succès'], 201);
    } else {
        return $this->json(['message' => 'Les données sont incomplètes'], 400);
    }


}

 
}
