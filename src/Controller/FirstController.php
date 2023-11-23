<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'test.order.route')]
    public function testOrderRoute($maVar) {
        return new Response(content: "
        <html><body>$maVar</body></html>");
    }

    #[Route(path: '/first', name: 'first')]
    public function index(): Response
    {
        //chercher les users dans la base de donnée
        return $this->render('first/index.html.twig', [
            'name' => 'Emeriau',
            'firstname' => 'Nicolas'
        ]);
    }

    #[Route(path: '/sayHello/{name}/{firstname}', name: 'say.hello')]
    public function sayHello(Request $request, $name, $firstname): Response
    {
        return $this->render(view: 'first/hello.html.twig',
            parameters: ['nom' => $name, 'prenom' => $firstname]);
    }

    #[Route('multi/{entier1}/{entier2}',
    name: 'multiplication',
    requirements: ['entier1' => '\d+', 'entier2' => '\d+']
    )]
    public function multiplication($entier1, $entier2) {
        $resultat = $entier1 * $entier2;
        return new Response(content: "<h1>$resultat</h1>");
    }

}
