<?php

use App\classes\PortfolioContactForm;
use src\TimberStarter;
use Timber\Timber;

define( 'TIMBER_TEXT_DOMAIN', 'timber' );

require_once __DIR__ . '/vendor/autoload.php';

Timber::init();

/*MAil contact*/
$contactForm = PortfolioContactForm::get_instance();
$contactForm->init();

/*Theme timber*/
TimberStarter::get_instance();