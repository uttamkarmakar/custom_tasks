<?php

namespace Drupal\generic_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterFace;

/**
 * GenericForm controller helps to generate a general form which is extending
 * FormBase class
 * 
 * @package Drupal\generic_form\Form
 * 
 * @author Uttam Karmakar <uttam.karmakar@innoraft.com>
 */
class GenericForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'generic_form.generic';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#required' => TRUE,
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterFace $form_state)
  {
    $name  = $form_state->getValue('full_name');
    $phone = $form_state->getValue('phone_number');
    $email = $form_state->getValue('email');
    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
      $form_state->setErrorByName('full_name', $this->t('Name should contain alphabets only'));
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
      $form_state->setErrorByName('phone_number', $this->t('Enter 10 Digits Numbers Only'));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please,Enter a Valid Email'));
    }
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    \Drupal::messenger()->addMessage($this->t('Form submitted successfully!'));
  }
}
