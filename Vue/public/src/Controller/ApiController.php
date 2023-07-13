<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{

    private $taskRepository;
    private $userRepository;
    private $jwtManager;
    private $serializer;

    public function __construct(EntityManagerInterface $em, JWTTokenManagerInterface $jwtManager, SerializerInterface $serializer)
    {
        $this->taskRepository = $em->getRepository(Task::class);
        $this->userRepository = $em->getRepository(User::class);
        $this->jwtManager = $jwtManager;
        $this->serializer = $serializer;
    }

    private function getData($username)
    {

        $user = $this->userRepository->findOneBy(["name" => $username]);
        $tasks = $this->taskRepository->findBy(['user' => $user->getId()]);

        return $tasks;
    }

    private function tokenToUser($token)
    {

        if ($token !== null && preg_match('/Bearer\s(\S+)/', $token, $matches)) {

            $bearerToken = $matches[1];
            $bearerToken = substr($bearerToken, 1);
            $bearerToken = rtrim($bearerToken, '"');
            try {
                $user = $this->jwtManager->parse($bearerToken);
            } catch (\Exception $e) {
                return array(false);
            }

            return array(true, $user);
        }
        return array(false);
    }

    #[Route('/index', name: 'index', methods: ['GET'])]
    public function index(Request $req): JsonResponse
    {

        $token = $req->headers->get('Authorization');
        $tokenToUser = $this->tokenToUser($token);


        if ($tokenToUser[0]) {

            $user = $tokenToUser[1];

            $jsonData = $this->serializer->serialize($this->getData($user['username']), 'json', [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['user'],
            ]);

            return new JsonResponse($jsonData, 200, [], true);
        }

        return $this->json('something went wrong, try to re-login', 401);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $req): JsonResponse
    {

        $token = $req->headers->get('Authorization');
        $payload = json_decode($req->getContent(), false);

        $tokenToUser = $this->tokenToUser($token);

        if ($tokenToUser[0]) {


            $user = $tokenToUser[1];
            $userEntity = $this->userRepository->findOneBy(['name' => $user['username']]);

            $task = new Task();
            $task->setText($payload->text);
            $task->setDay($payload->day);
            $task->setReminder($payload->reminder);
            $task->setUser($userEntity);
            $this->taskRepository->save($task, true);


            $jsonData = $this->serializer->serialize($this->getData($user['username']), 'json', [
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['user'],
            ]);

            return new JsonResponse($jsonData, 201, [], true);
        }

        return $this->json('something went wrong, try to re-login', 401);
    }

    #[Route('/reminder', name: 'reminder', methods: ['PUT'])]
    public function reminder(Request $req): JsonResponse
    {

        $token = $req->headers->get('Authorization');
        $payload = json_decode($req->getContent(), false);

        $tokenToUser = $this->tokenToUser($token);

        if ($tokenToUser[0]) {

            $taskId = $payload->id;
            $task = $this->taskRepository->find($taskId);

            $task->setReminder(!$task->isReminder());

            $this->taskRepository->save($task, true);

            return $this->json(null, 200);
        }

        return $this->json('something went wrong, try to re-login', 401);
    }

    #[Route('/deleteTask', name: 'delete', methods: ['DELETE'])]
    public function deleteTask(Request $req): JsonResponse
    {

        $token = $req->headers->get('Authorization');
        $payload = json_decode($req->getContent(), false);

        $tokenToUser = $this->tokenToUser($token);

        if ($tokenToUser[0]) {

            $taskId = $payload->id;
            $task = $this->taskRepository->find($taskId);

            $this->taskRepository->remove($task, true);

            return $this->json(null, 200);
        }

        return $this->json('something went wrong, try to re-login', 401);
    }

    // #[Route('/test', name:'test')]
    // public function test(){

    // }
}
