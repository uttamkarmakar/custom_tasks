<?php

  namespace Drupal\movie_budget\Form;

  use Drupal\Core\Form\ConfigFormBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Configuration form for budget settings.
   */
  class BudgetConfigurationForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
      return ['movie_budget.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
      return 'movie_budget_config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
      $config = $this->config('movie_budget.settings');

      $form['budget_amount'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Budget Amount'),
        '#default_value' => $config->get('budget_amount'),
        '#description' => $this->t('Enter the budget-friendly amount for the movies.'),
        '#required' => TRUE,
      ];

      return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
      $config = $this->config('movie_budget.settings');
      $config->set('budget_amount', $form_state->getValue('budget_amount'))->save();

      parent::submitForm($form, $form_state);
    }

}
