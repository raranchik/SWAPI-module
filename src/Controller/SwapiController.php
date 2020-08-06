<?php

namespace Drupal\swapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\swapi\Form\SwapiSearch;

class SwapiController extends ControllerBase {
  public function test() {
    $output = [];

    $output['markup'] = \Drupal::service('swapi.data_retrieval')->getPeople();

    return $output['markup'];
  }
}
