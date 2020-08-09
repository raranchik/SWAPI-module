<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "vehicles_queue_worker",
   *   title = @Translation("Vehicles node"),
   *   cron = {"time" = 60}
   * )
   */

  class VehiclesQueueWorker extends QueueWorkerBase {
    public function processItem($vehicle) {
      $node = Node::create([
        'type' => 'vehicles',
        'title' => 'Vehicle',
      ]);

      foreach ($vehicle as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
