<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class ToDoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        //afficher notre tableau todo
        // si le tableau est dans la session, je ne fais que l'afficher
        if (!$session->has(name: 'todos')) {

            $todos = [
                'achat'=>'acheter clé usb',
                'cours'=>'finaliser mon cours',
                'correction'=>'corriger mes examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash(type: 'info', message: "la liste des todos vient d'être initialisée");
        }
        // sinon je l'initialise puis je l'affiche
        return $this->render('to_do/index.html.twig');
    }

    #[Route(
        '/add/{name}/{content}',
        name: 'todo.add',
        defaults: ['name' => 'sf6', 'content' => 'techwall']
    )]
    public function addTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        //vérifier si j'ai mon tableau dans la session
        if ($session->has(name: 'todos')) {
            //si oui on travaille
            //vérifier si on a un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (isset($todos[$name])) {
                //si oui afficher message d'erreur
                $this->addFlash(type: 'error', message: "le todo d'id $name existe déjà dans la liste des todos");
            } else {
                //si non on l'ajoute et on affiche un message de succès
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "le todo d'id $name a été ajouté avec succès");
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controleur initial soit index

            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée");

        }
        return $this->redirectToRoute(route: 'todo');
    }

    #[Route('/update/{name}/{content}', name: 'todo.update')]
    public function updateTodo(Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        //vérifier si j'ai mon tableau dans la session
        if ($session->has(name: 'todos')) {
            //si oui on travaille
            //vérifier si on a un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (!isset($todos[$name])) {
                //si oui afficher

                $this->addFlash(type: 'error', message: "le todo d'id $name n'existe pas dans la liste des todos");
            } else {
                //si non on l'ajoute et on affiche un message de succès
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "le todo d'id $name a été modifié avec succès");
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controleur initial soit index

            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée");

        }
        return $this->redirectToRoute(route: 'todo');
    }

    #[Route('/delete/{name}', name: 'todo.delete')]
    public function deleteTodo(Request $request, $name): RedirectResponse {
        $session = $request->getSession();
        //vérifier si j'ai mon tableau dans la session
        if ($session->has(name: 'todos')) {
            //si oui on travaille
            //vérifier si on a un todo avec le meme name
            $todos = $session->get(name: 'todos');
            if (!isset($todos[$name])) {
                //si oui afficher le message d'erreur

                $this->addFlash(type: 'error', message: "le todo d'id $name n'existe pas dans la liste des todos");
            } else {
                //si non on l'ajoute et on affiche un message de succès
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash(type: 'success', message: "le todo d'id $name a été supprimé avec succès");
            }
        } else {
            //si non
            //afficher une erreur et on va rediriger vers le controleur initial soit index

            $this->addFlash(type: 'error', message: "la liste des todos n'est pas encore initialisée");

        }
        return $this->redirectToRoute(route: 'todo');

    }

    #[Route('/reset/', name: 'todo.reset')]
    public function resetTodo(Request $request): RedirectResponse {
     $session = $request->getSession();
     $session->remove(name: 'todos');
     return $this->redirectToRoute(route: 'todo');
    }

}
