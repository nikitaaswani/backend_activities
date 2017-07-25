<?php

namespace Drupal\static_menu_item\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class PageController extends ControllerBase implements AccessInterface {
  public function description() {
    return [
      '#markup' => $this->t('Hello! I am your node listing page.'),
    ];
  }

  public function arguments($arg) {
    return [
      '#markup' => $this->t('Hello! I am your @arg listing page.',
        ['@arg' => $arg]),
    ];
  }

  public function parameterUpcasting(NodeInterface $node) {
    // return node_view($node);
    return [
    '#markup' => $node->getTitle(),
    ];
  }

  public function multipleParameterUpcasting(NodeInterface $node1,NodeInterface $node2) {
    return [
    '#markup' => $this->t('We are two articles.Our names are @name1 and @name2.' ,['@name1' => $node1->getTitle(),'@name2' => $node2->getTitle()]),
    ];
  }

  public function access(AccountInterface $account,NodeInterface $node) {
    $current_user=$account->id();
    $node_author=$node->getOwnerId();
    if($current_user==$node_author) {
      return AccessResult::allowed();
     }
      return AccessResult::forbidden();
  }
}
