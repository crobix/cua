<?php
/**
 * @copy In Extenso (c) 2019
 * Added by : loic at 11/06/19 13:15
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        return $this->render("index.html.twig");
    }
}
