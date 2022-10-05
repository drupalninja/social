<?php

namespace Drupal\social\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class SocialCommands extends DrushCommands {

  /**
   * Create dummy users for social timelline.
   *
   * @usage social-dummy-users
   *   No arguments required.
   *
   * @command social:dummy-users
   * @aliases sdu
   */
  public function dummyUsers() {
    $this->output()->writeln('Creating dummy users...');

    $user_storage = \Drupal::entityTypeManager()->getStorage('user');
    for ($i = 0; $i < 10; $i++) {
      $user = $user_storage->create([
        'name' => 'socialuser' . $i,
        'mail' => 'socialuser' . $i . '@example.com',
        'pass' => 'socialuser' . $i,
        'status' => 1,
      ]);
      $user->save();

      $comment_storage = \Drupal::entityTypeManager()->getStorage('comment');
      for ($c = 0; $c < 10; $c++) {
        $comment = $comment_storage->create([
          'entity_type' => 'user',
          'entity_id' => $user->id(),
          'field_name' => 'field_posts',
          'comment_type' => 'posts',
          'uid' => $user->id(),
          'status' => 1,
          'subject' => 'Comment ' . $c . ' for user ' . $i,
          'comment_body' => [
            'value' => 'Comment ' . $c . ' for user ' . $i,
            'format' => 'basic_html',
          ],
        ]);
        $comment->save();
      }
    }

    $this->output()->writeln('Done creating dummy users.');
  }

}
