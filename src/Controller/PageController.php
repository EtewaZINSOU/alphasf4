<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PageController
{
    /**
     * @Route("/page")
     * @param Environment $twig
     * @return Response
     */
    public function number(Environment $twig)
    {
        $number = mt_rand(0, 100);

        return new Response($twig->render('page.html.twig',['number' => $number]));

//        return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
    }

}