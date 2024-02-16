<?php
// src/Controller/PrimeController.php

namespace App\Controller;

use App\Entity\Salarie;
use App\Entity\PrimeSalarie;
use App\Repository\PrimeRepository;
use App\Repository\SalarieRepository;
use App\Repository\PrimesalarieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/salaries', name: 'api_salarie')]
class SalarieController extends AbstractController
{
    private $salarieRepository;
    private $primesalarieRepository;
    private $primeRepository;
    private $serializer;
    private $validator;
    private $entityManager;

    public function __construct(
        SalarieRepository $salarieRepository,
        PrimeRepository $primeRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        primesalarieRepository $primesalarieRepository
    ) {
        $this->salarieRepository = $salarieRepository;
        $this->primeRepository = $primeRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->primesalarieRepository = $primesalarieRepository;
    }

    #[Route('', methods: ['GET'], name: 'list_salaries')]
    public function listSalaries(): JsonResponse
    {
        $salaries = $this->salarieRepository->findAll();
        $data = $this->serializer->serialize($salaries, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', methods: ['GET'], name: 'get_salarie')]
public function getSalarie(int $id): JsonResponse
{
    $salarie = $this->salarieRepository->find($id);
    if (!$salarie) {
        return new JsonResponse(['error' => 'Salarie introuvable pour l\'ID ' . $id], Response::HTTP_NOT_FOUND);
    }
    $salarieData = $this->serializer->serialize($salarie,'json');
    return new JsonResponse($salarieData, Response::HTTP_OK, [], true);
}

    
    #[Route('/{id}/primes', methods: ['GET'], name: 'getprimesalarie')]
    public function getPrimeSalarie(int $id): JsonResponse
    {
        $salarie = $this->salarieRepository->find($id);
        if (!$salarie) {
            return new JsonResponse(['error' => 'Salarie introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Chargez les primes associées à ce salarié
        $primesAssociees = $this->primesalarieRepository->findBy(['salarie' => $salarie]);

        // Ajoutez les primes et montants au tableau des données du salarié
        $primesData = [];
        foreach ($primesAssociees as $primeAssociee) {
            $prime = $primeAssociee->getPrime();
            if ($prime) {
                $primesData[] = [
                    'prime_id' => $prime->getId(),
                    'prime_nom' => $prime->getNom(),
                    'montant' => $primeAssociee->getMontant(),
                ];
            }
        }

        return new JsonResponse(['primes' => $primesData], Response::HTTP_OK);
    }

        

//return $this->json($salarieData, Response::HTTP_OK, [], ['json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS]);

    #[Route('', methods: ['POST'], name: 'create_salarie')]
    public function createSalarie(Request $request): JsonResponse
    {
        $salarieData = json_decode($request->getContent(), true);
        if ($salarieData === null) {
            return new JsonResponse(['error' => 'Données de salarié manquantes ou invalides'], Response::HTTP_BAD_REQUEST);
        }
        $salarie = new Salarie();
        $this->hydrateSalarie($salarie, $salarieData);

        $errors = $this->validator->validate($salarie);
        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($salarie);
        $this->entityManager->flush();

        $this->associatePrimes($salarieData, $salarie);


        return new JsonResponse(['success' => 'Salarie créé avec succès.'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'], name: 'update_salarie')]
        public function updateSalarie(Request $request, int $id): JsonResponse
        {
            $salarie = $this->salarieRepository->find($id);
            if (!$salarie) {
                return new JsonResponse(['error' => 'Salarie introuvable'], Response::HTTP_NOT_FOUND);
            }

            $salarieData = json_decode($request->getContent(), true);
            if ($salarieData === null) {
                return new JsonResponse(['error' => 'Données de salarié manquantes ou invalides'], Response::HTTP_BAD_REQUEST);
            }

            $this->hydrateSalarie($salarie, $salarieData);

            $errors = $this->validator->validate($salarie);
            if ($errors->count() > 0) {
                $errors = $this->serializer->serialize($errors, 'json');
                return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
            }

            $this->entityManager->flush();

            return new JsonResponse(['success' => 'Salarie mis à jour avec succès.'], Response::HTTP_OK);
        }

    #[Route('/{id}', methods: ['DELETE'], name: 'delete_salarie')]
    public function deleteSalarie(int $id): JsonResponse
    {
        $salarie = $this->salarieRepository->find($id);
        if (!$salarie) {
            return new JsonResponse(['error' => 'Salarie introuvable'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($salarie);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    private function hydrateSalarie(Salarie $salarie, array $data): void
    {
        if (isset($data['nom'])) {
            $salarie->setNom($data['nom']);
        }

        // Ajoutez d'autres propriétés à hydrater selon votre modèle Salarie
    }

    private function associatePrimes(array $salarieData, Salarie $salarie): void
{
    if (isset($salarieData['primes']) && is_array($salarieData['primes'])) {
        foreach ($salarieData['primes'] as $primeAssociation) {
            $primeId = $primeAssociation['prime_id'];
            $montant = $primeAssociation['montant'];

            $prime = $this->primeRepository->find($primeId);
            if ($prime) {
                $primeSalarie = new PrimeSalarie();
                $primeSalarie->setPrime($prime);
                $primeSalarie->setSalarie($salarie);
                $primeSalarie->setMontant($montant);

                $this->entityManager->persist($primeSalarie);
            }
        }

        $this->entityManager->flush();
    }
}
}