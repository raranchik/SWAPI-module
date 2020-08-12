<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "films_queue_worker",
   *   title = @Translation("Films node"),
   *   cron = {"time" = 60}
   * )
   */

  class FilmsQueueWorker extends QueueWorkerBase {
    public function processItem($films) {
      $node = Node::create([
        'type' => 'films',
        'title' => $films['title'],
      ]);

      foreach ($films as $field => $fieldValue) {
        $node->set(('field_' . $field), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
