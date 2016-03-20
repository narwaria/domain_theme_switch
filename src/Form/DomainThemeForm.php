<?php

/**
 * @file
 * Contains \Drupal\domain_theme_switch\Form\DictionaryForm.
 */

namespace Drupal\domain_theme_switch\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DomainThemeForm extends FormBase {

    /**
     *  {@inheritdoc}
     */
    public function getFormId() {
        return 'domain_theme_switch_form';
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The request object.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Use the Form API to define form elements.
	
        $doaminThemes= unserialize(\Drupal::state()->get('domainthemes'));
        $themes = \Drupal::service('theme_handler')->listInfo();
        $themeNames = array(''=>'--Select--');
        foreach ($themes as $key => $value) {
            $themeNames[$key] = $key;
        }
        $AllDomain = \Drupal::service('domain.loader')->loadOptionsList();
        foreach ($AllDomain as $key => $value) {
            $form['domain'.$key] = array(
                '#type' => 'fieldset',
                '#title' => $value,
                
            );
            $form['domain'.$key][$key] = [
                '#type' => 'select',
                '#title' => t('Select Theme'),
                '#options' => $themeNames,
                '#default_value'=>$doaminThemes[$key],
               
            ];
        }

        $form['submit'] = array(
            '#type' => 'submit',
            '#value' => t('Save configuration'),
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        // Validate the form values.
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $AllDomain = \Drupal::service('domain.loader')->loadOptionsList();
        $domainTheme= array();
        foreach ($AllDomain as $key => $value) {
            $domainTheme[$key]=$form_state->getValue($key);
        } 
        \Drupal::state()->set('domainthemes',serialize($domainTheme));
        drupal_set_message("Domain theme configuration saved succefully");
    }

}

