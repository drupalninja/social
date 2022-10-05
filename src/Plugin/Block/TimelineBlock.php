<?php

namespace Drupal\social\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\views\Views;

/**
 * Provides a timeline block.
 *
 * @Block(
 *   id = "social_timeline",
 *   admin_label = @Translation("Timeline"),
 *   category = @Translation("Custom")
 * )
 */
class TimelineBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $user = \Drupal::routeMatch()->getParameter('user');

    if (!$user) {
      return;
    }

    $uid = $user->id();

    // Get the current user.
    $author_uids = [$uid];

    // Get the users that the current user is following.
    $following = \Drupal::entityTypeManager()->getStorage('flagging')->loadByProperties([
      'flag_id' => 'following',
      'uid' => $uid,
    ]);

    // Add the users that the current user is following to the list of authors.
    foreach ($following as $follow) {
      $author_uids[] = $follow->get('entity_id')->getString();
    }

    $build = [];

    // Embed the posts_timeline view.
    $view = Views::getView('posts_timeline');
    $view->setDisplay('default');

    // Filter the posts by the authors (following and current author).
    $view->setArguments([implode('+', $author_uids)]);
    $view->execute();

    // Add the comment form if we are on the current user's timeline.
    if ($uid == \Drupal::currentUser()->id()) {
      $build['comment_form'] = [
        '#lazy_builder' => [
          'comment.lazy_builders:renderForm',
          [
            'user',
            $uid,
            'field_posts',
            'posts',
          ],
        ],
        '#create_placeholder' => TRUE,
      ];
    }

    $build['view'] = $view->render();

    // Disable caching.
    $build['#cache']['max-age'] = 0;

    return $build;
  }

}
