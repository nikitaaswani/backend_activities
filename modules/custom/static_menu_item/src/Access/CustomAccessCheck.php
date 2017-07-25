<?php
namespace Drupal\static_menu_item\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;

/**
 * Checks access for displaying configuration translation page.
 */
class CustomAccessCheck implements AccessInterface {

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   */
  public function access(AccountInterface $account,NodeInterface $node) {
    $current_user=$account->id();
    $node_author=$node->getOwnerId();
    if($current_user==$node_author) {
      return AccessResult::allowed();
     }
      return AccessResult::forbidden();
  }

  //    if($account->hasPermission('access content')) {
  //       return AccessResult::allowed();
  //    }
  //     return AccessResult::forbidden();
  // }
}
