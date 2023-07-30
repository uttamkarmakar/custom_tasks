<?php

namespace Drupal\movie_module;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of movie awardss.
 */
class MovieAwardsListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Label');
    $header['id'] = $this->t('Machine name');
    $header['year'] = $this->t('Year');
    $header['movie'] = $this->t('Movie');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\movie_module\MovieAwardsInterface $entity */

    $movie_id = $entity->get('movie');
    $movie_name =  \Drupal::entityTypeManager()->getStorage('node')->load($movie_id);
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['year'] =  $entity->get('year');
    $row['movie'] =  $movie_name->label();
    return $row + parent::buildRow($entity);
  }

}
