<?php

namespace Drupal\static_menu_item\Form;

use Drupal\static_menu_item\CustomService;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;


class DependencyInjectionForm extends FormBase {

  protected $service;

  private $states = [
    'india' => [
      'rajasthan' => 'Rajasthan',
      'mp' => 'MP',
      'up' => 'UP',
      'delhi' => 'Delhi',
      'maharashtra' => 'Maharashtra',
    ],
    'uk' => [
      'england' => 'England',
      'scotland' => 'Scotland',
      'wales' => 'wales',
      'northern_ireland' => 'Northern Ireland'
    ],
  ];

  public function __construct(CustomService $service) {
    $this->service = $service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('static_menu_item.insert_query')
      );
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    \Drupal::state()->set('submissiontime',date("h:i:sa"));
    $result=$this->service->fetch();
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#description' => $this->t('Enter your first name here.'),
      '#default_value' => $result['first_name'],
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#description' => $this->t('Enter your last name here.'),
      '#default_value' => $result['last_name'],
      '#required' => TRUE,
    ];

    $form['qualification'] = [
      '#type' => 'select',
      '#title' => $this->t('Qualification'),
      '#options' => [
        'ug' => $this->t('UG'),
        'pg' => $this->t('PG'),
        'other' => $this->t('Other'),
      ],
      '#empty_option' => $this->t('-Qualification-'),
      '#description' => $this->t('Select your degree.'),
    ];

    $form['others'] = [
      '#type' => 'textfield',
      '#description' => $this->t('If others, please specify.'),
      '#states' => [
        'visible' => [
          'select[name="qualification"]' => ['value' => 'other'],
        ],
      ],
    ];

    $form['country'] = [
      '#type' => 'select',
      '#title' => $this->t('Country'),
      '#options' => [
        'india' => $this->t('India'),
        'uk' => $this->t('UK'),
      ],
      '#empty_option' => $this->t('-Country-'),
      '#description' => $this->t('Select your country.'),
      '#ajax' => [
        'callback' => '::statesCallback',
        'wrapper' => 'states-wrapper',
      ],
    ];

    // $form['states_in_india'] = [
    //   '#type' => 'select',
    //   '#title' => $this->t('States'),
    //   '#options' => [
    //     'rajasthan' => $this->t('Rajasthan'),
    //     'mp' => $this->t('MP'),
    //     'up' => $this->t('UP'),
    //     'delhi' => $this->t('Delhi'),
    //     'maharashtra' => $this->t('Maharashtra'),
    //   ],
    //   '#empty_option' => $this->t('-States-'),
    //   '#description' => $this->t('Select your states.'),
    //   '#states' => [
    //     'visible' => [
    //       'select[name="country"]' => ['value' => 'india'],
    //     ],
    //   ],
    // ];

    // $form['states_in_uk'] = [
    //   '#type' => 'select',
    //   '#title' => $this->t('States'),
    //   '#options' => [
    //     'england' => $this->t('England'),
    //     'scotland' => $this->t('Scotland'),
    //     'wales' => $this->t('Wales'),
    //     'northern_ireland' => $this->t('Northern Ireland'),
    //   ],
    //   '#empty_option' => $this->t('-States-'),
    //   '#description' => $this->t('Select your states.'),
    //   '#states' => [
    //     'visible' => [
    //       'select[name="country"]' => ['value' => 'uk'],
    //     ],
    //   ],
    // ];


    // $form['actions'] = [
    //   '#type' => 'actions',
    // ];

    // Disable caching on this form.
    $form_state->setCached(FALSE);

    // Add a submit button that handles the submission of the form.
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    $form['states_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'states-wrapper'],
    ];

    return $form;
  }

  public function getFormId() {
    return 'dependency_injection_in_form';
  }

  public function statesCallback(array &$form, FormStateInterface $form_state) {
    $country = $form_state->getValue('country');

    $form['states_wrapper']['state'] = [
      '#type' => 'select',
      '#title' => $this->t('State'),
      '#options' => $this->states[$country],
    ];

    return $form['states_wrapper'];
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    kint(\Drupal::state()->get('submissiontime'));
    exit();
    $values = array (
      'first_name' => $form_state->getValue('first_name'),
      'last_name' => $form_state->getValue('last_name'),
      );
    $this->service->write($values);
  }
}
