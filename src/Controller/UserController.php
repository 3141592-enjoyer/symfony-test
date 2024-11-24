<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/api/users')]
class UserController extends AbstractController
{
    private $userRepository;
    private $serializer;
    private $passwordHasher;
    private $validator;
    private $entityManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
		$users = $this->userRepository->findAll();
    	$normalizedUsers = [];
    	foreach ($users as $user) {
        	$normalizedUsers[] = [
            	'id' => $user->getId(),
            	'name' => $user->getName(),
            	'password' => $user->getPassword(),
        	];
    	}
    	return new JsonResponse($normalizedUsers, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_user_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
   		$data = json_decode($request->getContent(), true);

    	if (json_last_error() !== JSON_ERROR_NONE) {
        	return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
    	}

    	if (!isset($data['name'], $data['password'])) {
        	return new JsonResponse(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
    	}

    	$user = new User();
    	$user->setName($data['name']);
		$user->setPassword($data['password']);
    	$encodedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());

    	$user->setPassword($encodedPassword);
    	$this->entityManager->persist($user);
    	$this->entityManager->flush();

    	return new JsonResponse(['message' => 'User created successfully'], Response::HTTP_CREATED);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {
		$userData = [
        	'id' => $user->getId(),
        	'name' => $user->getName(),
        	'password' => $user->getPassword(),
    	];
    	return new JsonResponse($userData, Response::HTTP_OK);
    }


    #[Route('/edit/{id}', name: 'app_user_edit', methods: ['PUT'])]
    public function edit(Request $request, User $user): JsonResponse
    {
		$data = json_decode($request->getContent(), true);

    	if (json_last_error() !== JSON_ERROR_NONE) {
        	return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
    	}

    	if (isset($data['name'])) {
        	$user->setName($data['name']);
    	}

		if (isset($data['password'])) {
        	$encodedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        	$user->setPassword($encodedPassword);
    	}

   		$this->entityManager->persist($user);
    	$this->entityManager->flush();

    	return new JsonResponse(['message' => 'User updated successfully'], Response::HTTP_OK);
    }

    #[Route('/delete/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
		$this->entityManager->remove($user);
    	$this->entityManager->flush();
    	return new JsonResponse(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
