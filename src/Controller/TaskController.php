<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    #[Route('/task', name: 'app_task')]
    public function index(): Response
    {
        // On va chercher par doctrine le repository de nos Task
        // $this->taskRepository

        // Dans ce repository nous récupérons toutes les données
        $tasks = $this->taskRepository->findAll();

        // Affichage des données dans le var_dumper
        // dd($tasks);

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks
        ]);
    }
}
