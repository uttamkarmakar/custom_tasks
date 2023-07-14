<?php

function custom_general_form_alter(&$form, \Drupal\Core\Form\FormStateInterface $form_state, $form_id)
{
  if ($form_id == 'node_article_edit_form') {
    // \Drupal::messenger()->addMessage("form_id of this form is @id: ",['@id' => $form_id]);
    $form['actions']['submit']['#value'] = "Click to Edit this Great Article!!";
    $form['body']['widget'][0]['#title'] = 'New body';
    $form['title']['widget'][0]['value']['#title'] = 'New Title';
  }
  if ($form_id == 'node_article_form') {
    $form['actions']['submit']['#value'] = ("Save this Great Article!!");
  }
  if ($form_id == 'taxonomy_vocabulary_form') {
    $form['description']['#title'] = ("Please give a brief description");
  }
}

function custom_general_entity_view(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
  $module_handler = \Drupal::moduleHandler();
  $module_handler->invokeAll('node_view_count', [$entity]);
  $build['view_count'] = [
    '#cache' => ['max-age' => 0],
  ];
}

function custom_general_node_view_count(EntityInterface $entity)
{
  $session = \Drupal::request()->getSession();
  $current_count = $session->get('current_count', []);
  if (!isset($current_count[$entity->id()])) {
    $current_count[$entity->id()] = 1;
  } else {
    $current_count[$entity->id()]++;
  }
  var_dump($current_count[$entity->id()]);
  $session->set('current_count', $current_count);
  \Drupal::messenger()->addMessage('you have visited @nid for @total times in this session', [
    '@nid' => $entity->id(),
    '@total' => $current_count[$entity->id()],
  ]);
}

