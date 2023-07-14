<?php
  namespace Drupal\mymodule\Controller;
  
  use Drupal\Core\Controller\ControllerBase;
  use Drupal\node\Entity\NodeType;
  
  /**
   * MyFirstController helps to provide dynamic permissions by creating
   * permissions for each node type created in the site through mymodule
   * 
   * @package Drupal\mymodule\Controller
   * 
   * @author Uttam Karmakar <uttam.karmakar@innoraft.com>
   */
  class MyFirstController extends ControllerBase {
    /**
     * @method myFunction
     *  A simple method to display a markup in the page.
     * 
     *  @return array
     *    Returns an array of markup.
     */
    public function myFunction() {
      return[
        '#markup' => 'This is my first custom page',
      ];
    }
    /**
     * @method dynamicPermissions
     *  This method helps to provide dynamic permission to all the node types.
     * 
     *  @return array
     *    Returns an array of permissions.
     */
    public function dynamicPermissions() {
      $permissions = [];
      
      foreach(NodeType::loadMultiple() as $type) {
        $type_id = $type->id();
        $type_params = ['%type' => $type->label()];
        $permissions += [
          'controller'. $type_id . 'permission' => [
            'title' => $this->t('%type : Controller permission',$type_params),
            'description' => 'permission for controller based on node',
            'restrict access' => TRUE,
            
          ],
        ];
      }
      return $permissions;
    }
  }
  