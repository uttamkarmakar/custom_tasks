<?php

  namespace Drupal\event_dashboard\Services;

  use Drupal\Core\Database\Connection;
  use Drupal\Core\Datetime\DateFormatterInterface;
  use Drupal\Core\Datetime\DrupalDateTime;

  /**
   * Service to handle fetching event data and calculating statistics.
   */
  class EventDashboardServices {

    /**
     * The database connection.
     *
     * @var \Drupal\Core\Database\Connection
     */
    protected $database;

    /**
     * The date formatter.
     *
     * @var \Drupal\Core\Datetime\DateFormatterInterface
     */
    protected $dateFormatter;

    /**
     * Constructs an EventTableStatsService object.
     *
     * @param \Drupal\Core\Database\Connection $database
     *   The database connection.
     * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
     *   The date formatter.
     */
    public function __construct(Connection $database, DateFormatterInterface $date_formatter) {
      $this->database = $database;
      $this->dateFormatter = $date_formatter;
    }

    /**
     * Get the events data.
     *
     * @return array
     *   An array containing event data.
     */
    public function getEventData() {
      $events = [];

      $query = $this->database->select('node_field_data', 'n')
        ->fields('n', ['nid', 'title', 'type']);
      $query->condition('type', 'events');
      $query->leftJoin('node__field_date', 'ed', 'n.nid = ed.entity_id');
      $query->addField('ed', 'field_date_value', 'event_date');
      $query->leftJoin('node__field_details', 'details', 'n.nid = details.entity_id');
      $query->addField('details', 'field_details_value', 'details_value');
      $query->leftJoin('node__field_event_type', 'et', 'n.nid = et.entity_id');
      $query->addField('et', 'field_event_type_value', 'event_type');

      $result = $query->execute()->fetchAll();
      // dpq($query);
      // dd($result);
      foreach ($result as $row) {
        $event_date = new DrupalDateTime($row->event_date);

        $events[] = [
          'title' => $row->title,
          'type' => $row->event_type,
          'date' => $this->dateFormatter->format($event_date->getTimestamp(), 'custom', 'Y-m-d'),
          'details' => $row->details_value,
        ];
      }

      return $events;
    }

    /**
     * Calculate event statistics by year.
     *
     * @param array $events
     *   The array of events.
     *
     * @return array
     *   An array containing event counts for each year.
     */
    public function calculateEventCountsYearly(array $events) {
      $eventCountsYearly = [];

      foreach ($events as $event) {
        $event_date = new DrupalDateTime($event['date']);
        $event_year = $event_date->format('Y');

        if (!isset($eventCountsYearly[$event_year])) {
          $eventCountsYearly[$event_year] = 0;
        }
        $eventCountsYearly[$event_year]++;
      }

      return $eventCountsYearly;
    }

    /**
     * Calculate event statistics by quarter.
     *
     * @param array $events
     *   The array of events.
     *
     * @return array
     *   An array containing event counts for each quarter.
     */
    public function calculateEventCountsQuarterly(array $events) {
      $eventCountsQuarterly = [];

      foreach ($events as $event) {
        $event_date = new DrupalDateTime($event['date']);
        $event_quarter = 'Quarter: ' . ceil($event_date->format('n') / 3);

        if (!isset($eventCountsQuarterly[$event_quarter])) {
          $eventCountsQuarterly[$event_quarter] = 0;
        }
        $eventCountsQuarterly[$event_quarter]++;
        // dd($eventCountsQuarterly);
      }

      return $eventCountsQuarterly;
    }

    /**
     * Calculate event statistics by type.
     *
     * @param array $events
     *   The array of events.
     *
     * @return array
     *   An array containing event counts for each event type.
     */
    public function calculateEventCountsByType(array $events) {
      $eventCountsByType = [];

      foreach ($events as $event) {
        if (!isset($eventCountsByType[$event['type']])) {
          $eventCountsByType[$event['type']] = 0;
        }
        $eventCountsByType[$event['type']]++;
        // dd($eventCountsByType);
      }
      return $eventCountsByType;
    }

}
