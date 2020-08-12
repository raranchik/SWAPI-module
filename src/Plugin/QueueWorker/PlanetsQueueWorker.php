<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "planets_queue_worker",
   *   title = @Translation("Planets node"),
   *   cron = {"time" = 60}
   * )
   */

  class PlanetsQueueWorker extends QueueWorkerBase {
    public function processItem($planet) {
      $node = Node::create([
        'type' => 'planets',
        'title' => $planet['name'],
      ]);

      foreach ($planet as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
