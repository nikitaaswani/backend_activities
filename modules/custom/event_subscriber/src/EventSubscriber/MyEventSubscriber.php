<?php

namespace Drupal\event_subscriber\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Drupal\Component\Utility\Unicode;
use Drupal\event_subscriber\Event\CustomEvent;
use Drupal\event_subscriber\Event\CustomEventNode;

class MyEventSubscriber implements EventSubscriberInterface
{
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('injectHeader');
    $events[CustomEvent::NODE_INSERT][] = array('logEntry');
    return $events;
  }
  public function injectHeader(FilterResponseEvent $event)
  {
    $current_path = \Drupal::service('path.current')->getPath();
    $output = substr($current_path, 0, 5);
    if($output == "/node")
    {
      $response = $event->getResponse();
      $response->headers->set('access-control-allow-origin', '*');
    }
  }

  public function logEntry(CustomEventNode $nodeEvent) {
    \Drupal::logger('content_entity_example')->notice($nodeEvent->getTitle());
  }
}
