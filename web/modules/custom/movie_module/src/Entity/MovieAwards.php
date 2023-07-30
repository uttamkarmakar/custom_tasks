<?php

namespace Drupal\movie_module\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\movie_module\MovieAwardsInterface;

/**
 * Defines the movie awards entity type.
 *
 * @ConfigEntityType(
 *   id = "movie_awards",
 *   label = @Translation("Movie Awards"),
 *   label_collection = @Translation("Movie Awardss"),
 *   label_singular = @Translation("movie awards"),
 *   label_plural = @Translation("movie awardss"),
 *   label_count = @PluralTranslation(
 *     singular = "@count movie awards",
 *     plural = "@count movie awardss",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\movie_module\MovieAwardsListBuilder",
 *     "form" = {
 *       "add" = "Drupal\movie_module\Form\MovieAwardsForm",
 *       "edit" = "Drupal\movie_module\Form\MovieAwardsForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "movie_awards",
 *   admin_permission = "administer movie_awards",
 *   links = {
 *     "collection" = "/admin/structure/movie-awards",
 *     "add-form" = "/admin/structure/movie-awards/add",
 *     "edit-form" = "/admin/structure/movie-awards/{movie_awards}",
 *     "delete-form" = "/admin/structure/movie-awards/{movie_awards}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "year" = "year",
 *     "movie" = "movie"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "year",
 *     "movie"
 *   }
 * )
 */
class MovieAwards extends ConfigEntityBase implements MovieAwardsInterface {

  /**
   * The movie awards ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The movie awards label.
   *
   * @var string
   */
  protected $label;

  /**
   * The movie awards year
   * 
   *  @var int
   */
  protected $year;
  
  /**
   * The movie that won the award
   * 
   *  @var \Drupal\node\Entity\Node
   */
  protected $movie;
 
}
