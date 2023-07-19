<?php

namespace Drupal\dependency_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\dependency_module\MyCustomService;
use Drupal\dependency_module\ShowNodeTitle;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller class for custom module functionality.
 */
class MyController extends ControllerBase
{

  /**
   * The custom service for performing calculations.
   *
   *  @var \Drupal\dependency_module\MyCustomService
   */
  protected $myCustomService;

  /**
   * The custom service for retrieving node titles.
   *
   *  @var \Drupal\dependency_module\ShowNodeTitle
   */
  protected $showTitle;

  /**
   * MyController constructor.
   *
   *  @param \Drupal\dependency_module\MyCustomService $myCustomService
   *    The custom service for performing calculations.
   *  @param \Drupal\dependency_module\ShowNodeTitle $showTitle
   *    The custom service for retrieving node titles.
   */
  public function __construct(MyCustomService $myCustomService, ShowNodeTitle $showTitle)
  {
    $this->myCustomService = $myCustomService;
    $this->showTitle = $showTitle;
  }

  /**
   * Creates an instance of the MyController class.
   *
   *  @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *    The service container.
   *
   *  @return \Drupal\dependency_module\Controller\MyController
   *    The created instance of the MyController class.
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('dependency_module.sum_service'),
      $container->get('dependency_module.title_service')
    );
  }

  /**
   * Displays the sum of two numbers.
   *
   *  @return array
   *    A render array containing the sum markup.
   */
  public function displaySum()
  {
    $sumOfTwo = $this->myCustomService->getSum(10, 23);
    return [
      '#markup' => $this->t('The sum is @sum', ['@sum' => $sumOfTwo]),
    ];
  }

  /**
   * Displays the title of a node.
   *
   *  @param int $nid
   *    The node ID.
   *
   *  @return array
   *    A render array containing the node title markup.
   */
  public function displayTitle($nid)
  {
    $myTitle = $this->showTitle->showTitle($nid);

    return [
      '#markup' => $this->t('The title of the requested node id is @node', [
        '@node' => $myTitle
      ])
    ];
  }
}
