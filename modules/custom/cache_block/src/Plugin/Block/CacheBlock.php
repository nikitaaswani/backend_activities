<?php

namespace Drupal\cache_block\Plugin\Block;

// use Drupal\cache_block\CustomService;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\Query\Sql\Query;
use Drupal\Core\Entity\Query\QueryInterface;
/**
 * Provides a 'Custom Config' Block.
 *
 * @Block(
 *   id = "cache_api_block",
 *   admin_label = @Translation("Cache block"),
 *   category = @Translation("custom"),
 * )
 */


class CacheBlock extends BlockBase {

  public function build() {

    $renderer = \Drupal::service('renderer');
    $current_user = \Drupal::currentUser();
    $email = $current_user->getEmail();
    // kint($current_user->getEmail());
    // exit();

    $query = \Drupal::entityQuery('node')
              ->condition('type','article')
              ->sort('created' , 'DESC')
              ->range(0,3);
    $nids = $query->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nids);
    // kint($nodes);
    // exit();
    $node[]= "";
    $i=1;
    foreach ($nodes as $key => $value) {
      $title[$i] =  $value->getTitle();
      $node[$i] = 'node:' . $key;
      // kint($node['title']);
      // exit();
      $i++;
    }
    $title[] = "Current User mail id :" . $email;
      // kint($title);
      //   exit();
    $build = [
      // '#markup' => $this->t("Current User mail id : @email",array('@email' => $email)),
      '#theme' => 'item_list',
      '#items' => $title,
      '#title' => $this->t('title of last three nodes :'),
      '#cache' => [
        'contexts' => [
          'user',
        ],
        'tags' => ['$node'],
      ]
    ];
    // $renderer->addCacheableDependency($build, \Drupal\user\Entity\User::load($current_user->id()));
    return $build;


    // $data = \Drupal::service('cache_block.node_fetch_query')->fetcher();
    // kint($nodes);
    // return [
    // "#markup" => "hello",
    // ];
  }
}
