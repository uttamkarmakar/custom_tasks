<?php

namespace Drupal\dependency_module;

use Drupal\node\Entity\Node;

class ShowNodeTitle {

  public function showTitle($nid) {
    $node = Node::load($nid);
    if ($node) {
      return $node->getTitle();
    }
    return 'No Node found';
  }
}
