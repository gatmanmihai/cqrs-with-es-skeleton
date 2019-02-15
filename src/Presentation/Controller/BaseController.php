<?php

namespace App\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    /**
     * @return array
     */
    public static function getSubscribedServices()
    {
        $services = parent::getSubscribedServices();

        $services['validator'] = '?' . ValidatorInterface::class;

        return $services;
    }
}