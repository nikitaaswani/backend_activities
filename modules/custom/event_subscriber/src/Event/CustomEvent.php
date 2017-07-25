<?php

namespace Drupal\event_subscriber\Event;

final class CustomEvent {

  /**
   * Name of the event fired when a new incident is reported.
   *
   * This event allows modules to perform an action whenever a new incident is
   * reported via the incident report form. The event listener method receives a
   * \Drupal\events_example\Event\IncidentReportEvent instance.
   *
   * @Event
   *
   * @see \Drupal\events_example\Event\IncidentReportEvent
   *
   * @var string
   */
  const NODE_INSERT = 'node.insert';

}
