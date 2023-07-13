<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/auth', name: 'auth_')]
class AuthController extends AbstractController
{
    private $userRepository;
    private $passwordHasher;
    private $jwtManager;
    private $serializer;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $jwtManager, SerializerInterface $serializer)
    {
        $this->userRepository = $em->getRepository(User::class);
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
        $this->serializer = $serializer;
    }

    private function userExists($name)
    {
        $user = $this->userRepository->findBy(['name' => $name]);
        if (sizeof($user) == 0) {
            return array(true, $user);
        }

        return array(false, null);
    }

    #[Route('/register', name: 'register')]
    public function register(Request $req): JsonResponse
    {
        $payload = json_decode($req->getContent(), false);
        $pass = $payload->password;
        $coPass = $payload->coPassword;

        if ($pass != $coPass) {
            return $this->json('passwords are not the same');
        }

        $name = $payload->name;
        if (!$this->userExists($name)[0]) {
            return $this->json('username is occupied');
        }
        
        $user = new User();
        $user->setName($name);
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));

        $this->userRepository->save($user, true);
        return $this->json($this->jwtManager->create($user), 201);
        
    }

    #[Route('/login', name: 'login', methods:['POST'])]
    public function login(Request $req): JsonResponse
    {
        $payload = json_decode($req->getContent(), false);

        $name = $payload->name;
        $exists = $this->userExists($name);
        if ($exists[0]) {
            return $this->json('wrong username or/and password', 401); // wrong username
        }

        $user = $this->userRepository->findOneBy(['name' => $name]);
        $pass = $payload->password;
        if($this->passwordHasher->isPasswordValid($user, $pass)){

            return $this->json($this->jwtManager->create($user));
            
        }

        return $this->json('wrong username or/and password', 401); // wrong password

    }

    // #[Route('/test', name: 'token')]
    // public function token(Request $req): JsonResponse
    // {
    //     $user = $this->userRepository->find(2);

    // $jsonData = $serializer->serialize($user, 'json', [
    // AbstractNormalizer::IGNORED_ATTRIBUTES => ['password'], // Specify any attributes to ignore
    // ]);

    // return new JsonResponse($jsonData, 200, [], true);
    // dd($this->passwordHasher->isPasswordValid($user, '1234'));
    // $pass = $this->passwordHasher->hashPassword($user,"123");
    // dd($pass);
    // $token = $req->headers->get('Authorization');

    // if ($token !== null && preg_match('/Bearer\s(\S+)/', $token, $matches)) {
    //     $bearerToken = $matches[1];

    //     return $this->json($bearerToken,200);
    // }

    // $token = $this->jwtManager->create($user);
    // dd($token);

    // $token = $req->headers->get('Authorization');
    // if ($token !== null && preg_match('/Bearer\s(\S+)/', $token, $matches)) {

    //     $bearerToken = $matches[1];

    //     $user = $this->jwtManager->parse($bearerToken);

    //     return $this->json($user['username'],200);
    // }


    // }


}
