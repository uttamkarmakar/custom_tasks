<?php

namespace Drupal\ajax_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * MyAjaxForm controller helps to create a general ajax form with required
 * methods for validation,form building and submission
 * 
 * @package Drupal\ajax_form\Form
 * 
 * @author Uttam Karmakar <uttam.karmakar@innoraft.com>
 */
class MyAjaxForm extends FormBase
{
  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'ajax_form.route';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['error'] = [
      '#type' => 'markup',
      '#markup' => '<div id="error-message"></div>',
    ];
    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      // '#prefix' => '<div id="full-name-wrapper">',
      // '#suffix' => '<span class="error"></span></div>',
      // '#field_suffix' => '<div class="error-message"></div>'

    ];

    $form['phone_number'] = [
      '#type' => 'tel',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      // '#prefix' => '<div id="phone-number-wrapper">',
      // '#suffix' => '<span class="error"></span></div>',
      // '#field_suffix' => '<div class="error-message"></div>'
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t("Email Address"),
      '#required' => TRUE,
      // '#field_suffix' => '<div class="error-message"></div>'
    ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::submitData',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading please wait....'),
        ],
      ],
    ];

    $form['element'] = [
      '#type' => 'markup',
      '#markup' => "<div class='success'></div>",
    ];

    return $form;
  }

  /**
   * @method submitData
   *  This method helps to validate form based on some conditions and performs
   *  ajax while validating
   * 
   *  @param array $form
   *    Contains the form array.
   *  @param \Drupal\Core\Form\FormStateInterface $form_state
   *    The form state object containing the form submission data
   *   
   */
  public function submitData(array &$form, FormStateInterface $form_state)
  {
    $ajax_response = new AjaxResponse();

    $validateOutput = $this->validate($form_state);

    if ($validateOutput === TRUE) {
      $ajax_response->addCommand(new HtmlCommand('.success', 'Your Form Submitted Successfully'));
      $ajax_response->addCommand(new \Drupal\Core\Ajax\CssCommand('#error-message', ['display' => 'none']));
    } else {
      $ajax_response->addCommand(new HtmlCommand('#error-message', $validateOutput));
    }
    return $ajax_response;
  }

  /**
   * Validates the form submission.
   *
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object containing the form values.
   *
   * @return bool|string
   *   TRUE if the form submission is valid, or a string error message if validation fails.
   */
  public function validate(FormStateInterface $form_state)
  {
    $name = $form_state->getValue('full_name');
    $number = $form_state->getValue('phone_number');
    $email = $form_state->getValue('email');

    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
      return '**name should contain alphabets only';
    } elseif (!preg_match('/^\d{10}$/', $number)) {
      return '**Only 10 digits numbers are allowed';
    }

    $emailSegments = explode('@', $email);
    $emailDomain = strtolower(end($emailSegments));

    if (empty($email)) {
      return '**Please,fill the email field';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return 'Enter a validate email';
    } elseif (!in_array($emailDomain, ['yahoo.com', 'gmail.com', 'outlook.com'])) {
      return '**Only public domains emails are allowed';
    } elseif (substr($email, -4) !== '.com') {
      return '**Email with only .com extensions are allowed';
    }
    return TRUE;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
  }
}
