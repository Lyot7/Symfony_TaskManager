<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    protected TaskRepository $taskRepository;
    protected EntityManagerInterface $manager;

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $manager)
    {
        $this->taskRepository = $taskRepository;
        $this->manager = $manager;
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

    #[Route('/task/create', name: 'app_task_create')]
    #[Route('/task/update/{id}', name: 'app_task_update', requirements: ['id' => "\d+"])]
    public function task(Task $task = null, Request $request){

        if (!$task){
            $task = new Task;
            $task->setCreatedAt(new \DateTime());
        }

        $form = $this->createForm(TaskType::class, $task, []);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $this->manager->persist($task);
            $this->manager->flush();

            return $this->redirectToRoute('app_task');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/task/delete/{id}', name: 'app_task_delete', requirements: ['id' => "\d+"])]
    public function deleteTask(Task $task): Response
    {
        $this->manager->remove($task);
        $this->manager->flush();

        return $this->redirectToRoute('app_task');
    }

}
