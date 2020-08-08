<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "people_queue_worker",
   *   title = @Translation("People node"),
   *   cron = {"time" = 60}
   * )
   */

  class PeopleQueueWorker extends QueueWorkerBase {


    public function processItem($Character) {
      $node = Node::create([
        'type' => 'people',
        'title' => 'People',
      ]);

      foreach ($Character as $field => $fieldValue) {
        $node->set(('field_people_' . $field), $fieldValue);
      }

      $this->saveNode($node);
    }

    private function saveNode($node){
      $node->setPublished(true);
      $node->save();
    }
  }
