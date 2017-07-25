<?php
Namespace Drupal\static_menu_item;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomService {

  protected $database;

  public function __construct(Connection $database) {
    $this->database = $database;
  }

  public function write(array $values) {
    return $this->database->insert('name')->fields($values)->execute();

  }

  public function fetch() {
    $results = $this->database->select('name', 'n')->fields('n', array('first_name', 'last_name'))->orderBy(first_name , 'DESC')->range(0,1)->execute()->fetchAssoc();
    return $results;
  }
}

