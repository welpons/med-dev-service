<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @todo add html template
     * 
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return new Response('med-dev-service - DDD Sample Application');
    }
}
