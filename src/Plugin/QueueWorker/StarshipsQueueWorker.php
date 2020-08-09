<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "starships_queue_worker",
   *   title = @Translation("Starships node"),
   *   cron = {"time" = 60}
   * )
   */

  class StarshipsQueueWorker extends QueueWorkerBase {
    public function processItem($starship) {
      $node = Node::create([
        'type' => 'starships',
        'title' => 'Starship',
      ]);

      foreach ($starship as $field => $fieldValue) {
        $node->set(('field_' . strtolower($field)), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
