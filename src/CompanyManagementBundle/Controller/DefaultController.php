<?php

namespace CompanyManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CompanyManagementBundle:Default:index.html.twig');
    }
}
