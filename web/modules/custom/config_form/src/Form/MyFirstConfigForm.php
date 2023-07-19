<?php

namespace Drupal\config_form\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * MyFirstConfigForm controller helps to create a configuration forms
 * 
 * @package Drupal\config_form\Form
 * 
 * @author Uttam karmakar <uttam.karmakar@innoraft.com>
 */
class MyFirstConfigForm extends ConfigFormBase
{

  /**
   * The configuration factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  
  /**
   * MyFirstConfigForm constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configuration factory service.
   */
  public function __construct(ConfigFactoryInterface $configFactory)
  {
    $this->configFactory = $configFactory;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return ['config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'custom_form.config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->configFactory->getEditable('config_form.settings');

    $form['firstname'] = [
      '#type'  => 'textfield',
      '#title' => 'First Name',
      '#default_value' => $config->get('firstname'),
      '#required' => TRUE,
    ];
    $form['lastname'] = [
      '#type'  => 'textfield',
      '#title' => 'Last Name',
      '#default_value' => $config->get('lastname'),
      '#required' => TRUE,
    ];
    $form['phone_number'] = [
      '#type'  => 'tel',
      '#title' => 'Phone Number',
      '#default_value' => $config->get('phone_number'),
      '#required' => TRUE,
    ];
    $form['email'] = [
      '#type'  => 'email',
      '#title' => 'Email Address',
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];
    $form['gender'] = [
      '#type'  => 'radios',
      '#title' => 'Gender',
      '#default_value' => $config->get('gender'),
      '#options' => [
        'male'   => 'Male',
        'female' => 'Female',
        'Others' => 'Others',
      ],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Please Submit the form',
    ];

    // return Parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {

    $phoneNumber = $form_state->getValue('phone_number');
    if (!preg_match('/^\d{10}$/', $phoneNumber)) {
      $form_state->setErrorByName('phone_number', $this->t('Please,enter a valid 10-digit Indian phone number.'));
    }
    $emailAddress = $form_state->getValue('email');
    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please,Enter a valid email address'));
    } else {
      $emailSegments = explode('@', $emailAddress);
      $emailDomain   = strtolower(end($emailSegments));
      if (!in_array($emailDomain, ['yahoo.com', 'gmail.com', 'outlook.com'])) {
        $form_state->setErrorByName('email', $this->t("Emails form public domains are allowed"));
      } elseif (substr($emailAddress, -4) !== '.com') {
        $form_state->setErrorByName('email', $this->t('Email with .com extension is only allowed!'));
      }
    }
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterFace $form_state)
  {
    $config = $this->configFactory->getEditable('config_form.settings');
    // dd($config);
    $config->set("firstname", $form_state->getValue('firstname'));
    $config->set("lastname", $form_state->getValue('lastname'));
    $config->set("phone_number", $form_state->getValue('phone_number'));
    $config->set("email", $form_state->getValue('email'));
    $config->set("gender", $form_state->getValue('gender'));
    \Drupal::messenger()->addMessage('Configurations are saved dude!');
    $config->save();
  }
}
