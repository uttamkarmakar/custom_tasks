<?php

namespace Drupal\event_dashboard\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\event_dashboard\Services\EventDashboardServices;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display the event table and event statistics.
 */
class EventDashboardController extends ControllerBase {

  /**
   * The event table statistics service.
   *
   * @var \Drupal\event_dashboard\EventDashboardServices
   */
  protected $EventDashboardServices;

  /**
   * Constructs an EventTableController object.
   *
   * @param \Drupal\event_dashboard\EventDashboardServices $event_table_stats_service
   *   The event table statistics service.
   */
  public function __construct(EventDashboardServices $event_table_stats_service) {
    $this->EventDashboardServices = $event_table_stats_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('event_dashboard.table_and_stats'),
    );
  }
  
  /**
   * Display the event table and event statistics.
   */
  public function displayTableAndStats() {
    $events = $this->EventDashboardServices->getEventData();
    $eventCountsYearly = $this->EventDashboardServices->calculateEventCountsYearly($events);
    $eventCountsQuarterly = $this->EventDashboardServices->calculateEventCountsQuarterly($events);
    $eventCountsByType = $this->EventDashboardServices->calculateEventCountsByType($events);
    
    // dd($eventCountsQuarterly);
    return [
      '#theme' => 'event_dashboard_statistics',
      '#yearly_counts' => $eventCountsYearly,
      '#quarterly_counts' => $eventCountsQuarterly,
      '#type_counts' => $eventCountsByType,
    ];
  }

}

