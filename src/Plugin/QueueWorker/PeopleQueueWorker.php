<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * A Node Publisher that publishes nodes on CRON run.
   *
   * @QueueWorker(
   *   id = "people_queue_worker",
   *   title = @Translation("Task worker: Node"),
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
        $node->set(('field_' . $field), $fieldValue);
      }

      $node->setPublished(true);
      $node->save();
    }
  }
