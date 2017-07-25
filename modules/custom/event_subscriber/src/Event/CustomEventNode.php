<?php

namespace Drupal\event_subscriber\Event;

use Symfony\Component\EventDispatcher\Event;


class CustomEventNode extends Event
{

  protected $node;

  function __construct($node)
  {
    $this->node = $node;
  }

  function getTitle() {
    return $this->node->label();
  }
}
