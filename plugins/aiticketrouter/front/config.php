<?php

// Include GLPI core bootstrap
include("../../../inc/includes.php");

use GlpiPlugin\Aiticketrouter\Form\ConfigForm;
use Session;
use Html;

Session::checkRight("config", UPDATE);

// Display GLPI native header
Html::header('AI Ticket Router Config', $_SERVER['PHP_SELF'], "config", "plugins");

ConfigForm::display();

// Display GLPI native footer
Html::footer();