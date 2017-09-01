<?php

namespace Drupal\ref_settings\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Subscriber for entity settings routes.
 */
class SettingsRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = parent::getSubscribedEvents();
    // Should run after AdminRouteSubscriber so the routes can inherit admin
    // status of the edit routes on entities. Therefore priority -210.
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', -210];
    return $events;
  }

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // use de canonical route as edit form.
    $route_canonical = $collection->get('entity.settings.canonical');
    $route_edit = $collection->get('entity.settings.edit_form');
    $route_canonical->setDefaults($route_edit->getDefaults());
    $route_canonical->setRequirements($route_edit->getRequirements());
    $route_canonical->setOptions($route_edit->getOptions());
  }
}
