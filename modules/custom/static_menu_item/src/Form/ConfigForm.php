<?php

namespace Drupal\static_menu_item\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {

  public function getFormId() {
    return 'config_form';
  }

  protected function getEditableConfigNames() {
    return [
      'static_menu_item.settings.appid',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('static_menu_item.settings.appid');

    $form['id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('App ID'),
      '#default_value' => $config->get('appid'),
    );

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('static_menu_item.settings.appid')
      ->set('appid', $form_state->getValue('id'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}

