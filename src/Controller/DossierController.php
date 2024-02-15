<?php

// Déclaration des dépendances
namespace App\Controller;

use App\Entity\Dossier;
use App\Repository\DossierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/dossiers', name: 'api_dossier')]
class DossierController extends AbstractController
{
    private $dossierRepository;
    private $serializer;
    private $validator;
    private $entityManager;

    public function __construct(
        DossierRepository $dossierRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->dossierRepository = $dossierRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    private function hydrateDossier(Dossier $dossier, array $data): void
    {
        if (isset($data['designation'])) {
            $dossier->setDesignation($data['designation']);
        }

        if (isset($data['IdFi'])) {
            $dossier->setIdFi($data['IdFi']);
        }
        
    }

    #[Route("", methods: ["GET"], name: "list")]
    public function listDossiers(): JsonResponse
    {
        $dossiers = $this->dossierRepository->findAll();
        $data = $this->serializer->serialize($dossiers, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route("/{id}", methods: ["GET"], name: "get")]
    public function getDossier(int $id): JsonResponse
    {
        $dossier = $this->dossierRepository->find($id);
        if (!$dossier) {
            return new JsonResponse(['error' => 'Dossier introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($dossier, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route("", methods: ["POST"], name: "create")]
    public function createDossier(Request $request): JsonResponse
    {
        $dossier = new Dossier();
        $data = json_decode($request->getContent(), true);
        $this->hydrateDossier($dossier, $data);
        $errors = $this->validator->validate($dossier);
        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }
        $this->entityManager->persist($dossier);
        $this->entityManager->flush();
        $data = $this->serializer->serialize($dossier, 'json');
        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }

    #[Route("/{id}", methods: ["PUT"], name: "update")]
    public function updateDossier(Request $request, int $id): JsonResponse
    {
        $dossier = $this->dossierRepository->find($id);
        if (!$dossier) {
            return new JsonResponse(['error' => 'Dossier introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        $this->hydrateDossier($dossier, $data);
        $errors = $this->validator->validate($dossier);
        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }
        $this->entityManager->flush();
        $data = $this->serializer->serialize($dossier, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route("/{id}", methods: ["DELETE"], name: "delete")]
    public function deleteDossier(int $id): JsonResponse
    {
        $dossier = $this->dossierRepository->find($id);
        if (!$dossier) {
            return new JsonResponse(['error' => 'Dossier introuvable'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($dossier);
        $this->entityManager->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
