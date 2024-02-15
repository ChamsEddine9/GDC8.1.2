<?php

// src/Controller/PrimeController.php

namespace App\Controller;

use App\Entity\Prime;
use App\Repository\PrimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/primes', name: 'api_prime')]
class PrimeController extends AbstractController
{
    private $primeRepository;
    private $serializer;
    private $validator;
    private $entityManager;

    public function __construct(
        PrimeRepository $primeRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->primeRepository = $primeRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    private function hydratePrime(Prime $prime, array $data): void
    {
        if (isset($data['nom'])) {
            $prime->setNom($data['nom']);
        }

        if (isset($data['imposable'])) {
            $prime->setImposable($data['imposable']);
        }
    }
   //function pour lister le prime
    #[Route('', methods: ['GET'], name: 'list')]
    public function listPrimes(): JsonResponse
    {
        $primes = $this->primeRepository->findAll();
        $data = $this->serializer->serialize($primes, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
    //function pour retourner le data d'un prime par son id
    #[Route('/{id}', methods: ['GET'], name: 'get')]
    public function getPrime(int $id): JsonResponse
    {
        $prime = $this->primeRepository->find($id);
        if (!$prime) {
            return new JsonResponse(['error' => 'Prime introuvable'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($prime, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }


   //function pour ajouter un prime
    #[Route('', methods: ['POST'], name: 'create')]
    public function createPrime(Request $request): JsonResponse
    {
        $prime = new Prime();
        $data = json_decode($request->getContent(), true);
        $this->hydratePrime($prime, $data);

        $errors = $this->validator->validate($prime);
        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($prime);
        $this->entityManager->flush();

        $data = $this->serializer->serialize($prime, 'json');
        return new JsonResponse($data, Response::HTTP_CREATED, [], true);
    }


    //function pour modifier un prime
    #[Route('/{id}', methods: ['PUT'], name: 'update')]
    public function updatePrime(Request $request, int $id): JsonResponse
    {
        $prime = $this->primeRepository->find($id);
        if (!$prime) {
            return new JsonResponse(['error' => 'Prime introuvable'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $this->hydratePrime($prime, $data);

        $errors = $this->validator->validate($prime);
        if ($errors->count() > 0) {
            $errors = $this->serializer->serialize($errors, 'json');
            return new JsonResponse(['error' => $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->entityManager->flush();

        $data = $this->serializer->serialize($prime, 'json');
        return new JsonResponse($data, Response::HTTP_OK, [], true);
}

    //function pour suprimer un prime
    #[Route('/{id}', methods: ['DELETE'], name: 'delete')]
    public function deletePrime(int $id): JsonResponse
    {
        $prime = $this->primeRepository->find($id);
        if (!$prime) {
            return new JsonResponse(['error' => 'Prime introuvable'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($prime);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
}

}