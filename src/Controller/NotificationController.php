<?php

namespace App\Controller;

use Twig\Environment;

class ContactNotification
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct($mailer, Environment $renderer)
    {

    }
}
