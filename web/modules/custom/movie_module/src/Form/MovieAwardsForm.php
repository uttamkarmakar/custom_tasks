<?php

namespace Drupal\movie_module\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Movie Awards form.
 *
 * @property \Drupal\movie_module\MovieAwardsInterface $entity
 */
class MovieAwardsForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $movie_id = $this->entity->get('movie') ?? '';
    // var_dump($movie_id);
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the movie awards.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\movie_module\Entity\MovieAwards::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['year'] = [
      '#type' => 'number',
      '#title' => $this->t('Year'),
      '#default_value' => $this->entity->get('year'),
      '#description' => $this->t('The year the movie won the award.'),
      '#required' => TRUE,
    ];
    
    $form['movie'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Movie'),
      '#target_type' => 'node',
      '#selection_handler' => 'default:node',
      '#selection_settings' => [
        'target_bundles' => ['movie'],
      ],
      '#default_value' => $this->entityTypeManager->getStorage('node')->load($movie_id) ?? '',
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new movie awards %label.', $message_args)
      : $this->t('Updated movie awards %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
