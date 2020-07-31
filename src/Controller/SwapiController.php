<?php

namespace Drupal\swapi\Controller;

use Drupal\Core\Controller\ControllerBase;

class SwapiController extends ControllerBase {
  public function helloWorld() {
    $output = array();

    $output['#title'] = 'HelloWorld page title';

    $output['#markup'] = 'Hello World!';

    return $output;
  }

}
