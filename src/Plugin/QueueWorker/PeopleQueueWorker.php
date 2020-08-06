<?php

  namespace Drupal\swapi\Plugin\QueueWorker;

  use Drupal\Core\Queue\QueueWorkerBase;
  use Drupal\node\Entity\Node;

  /**
   * Processes Node Tasks.
   *
   * @QueueWorker(
   *   id = "people_queue_worker",
   *   title = @Translation("Task Worker: Node"),
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
        if (!is_array($fieldValue)) {
          $node->set(('field_people_' . $field), $fieldValue);
        }

        foreach ($fieldValue as $list) {
          $node->set(('field_people_' . $field), $list);
        }
      }

      $node->setPublished(true);
      $node->save();
    }
  }
