<?php

  namespace Drupal\movie_budget\EventSubscriber;

  use Drupal\Core\Config\ConfigFactoryInterface;
  use Drupal\Core\Messenger\MessengerInterface;
  use Drupal\Core\Routing\RouteMatchInterface;
  use Symfony\Component\EventDispatcher\EventSubscriberInterface;
  use Symfony\Component\HttpKernel\Event\RequestEvent;
  use Symfony\Component\HttpKernel\KernelEvents;

  /**
   * Class MyBudgetEventSubscriber.
   */
  class MyBudgetEventSubscriber implements EventSubscriberInterface {

    /**
     * The config factory service.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * The route match service.
     *
     * @var \Drupal\Core\Routing\RouteMatchInterface
     */
    protected $routeMatch;

    /**
     * The messenger service.
     *
     * @var \Drupal\Core\Messenger\MessengerInterface
     */
    protected $messenger;

    /**
     * Constructs a new MyBudgetEventSubscriber object.
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   The config factory service.
     * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
     *   The route match service.
     * @param \Drupal\Core\Messenger\MessengerInterface $messenger
     *   The messenger service.
     */
    public function __construct(ConfigFactoryInterface $config_factory, RouteMatchInterface $route_match, MessengerInterface $messenger) {
      $this->configFactory = $config_factory;
      $this->routeMatch = $route_match;
      $this->messenger = $messenger;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
      return [
        KernelEvents::REQUEST => ['budgetFriendly'],
      ];
    }

    /**
     * Handles the REQUEST event.
     */
    public function budgetFriendly(RequestEvent $event) {
      // dump("hello");
      // dd($this->routeMatch->getParameter('node'));
      // Check if the current route is for viewing a node entity.
      if ($this->routeMatch->getRouteName() === 'entity.node.canonical') {
        $node = $this->routeMatch->getParameter('node');
        // Ensure that the loaded entity is a node entity of type 'movie'.
        if ($node && $node->getType() === 'movie') {
          $movie_price = $node->get('field_movie_price')->value;
          $budget = $this->configFactory->get('movie_budget.settings')->get('budget_amount');
          if ($movie_price < $budget) {
            $this->messenger->addMessage(t('The movie is under budget'));
          }
          else if ($movie_price > $budget) {
            $this->messenger->addMessage(t('The movie is over budget'));
          }
          else {
            $this->messenger->addMessage(t('The movie is within budget'));
          }
        } 
      }
    }
}


