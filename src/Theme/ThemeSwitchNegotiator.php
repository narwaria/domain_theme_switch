<?php
/**
 * @file
 * Contains \Drupal\domain_theme_switch\Theme\ThemeSwitchNegotiator.
 */

namespace Drupal\domain_theme_switch\Theme;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;


class ThemeSwitchNegotiator implements ThemeNegotiatorInterface {


  /**
   * Whether this theme negotiator should be used to set the theme.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match object.
   *
   * @return bool
   *   TRUE if this negotiator should be used or FALSE to let other negotiators
   *   decide.
   */

    public function applies(RouteMatchInterface $route_match) {

        $negotiator = \Drupal::service('domain.negotiator');
        $domain = $negotiator->getActiveDomain();
        $doaminThemes = array_filter(unserialize(\Drupal::state()->get('domainthemes')));
        if ((is_array($doaminThemes)) && (count($doaminThemes)>=1) && (array_key_exists($domain->id(), $doaminThemes))) {
            return TRUE;
        }
        
    }

  /**
   * Determine the active theme for the request.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The current route match object.
   *
   * @return string|null
   *   The name of the theme, or NULL if other negotiators, like the configured
   *   default one, should be used instead.
   */

    public function determineActiveTheme(RouteMatchInterface $route_match) {
        $negotiator = \Drupal::service('domain.negotiator');
        $domain = $negotiator->getActiveDomain();
        $doaminThemes = array_filter(unserialize(\Drupal::state()->get('domainthemes')));        
        if (is_array($doaminThemes) && (count($doaminThemes)>=1) && isset($domain->id()) && (array_key_exists($domain->id(), $doaminThemes))) {            
            return $doaminThemes[$domain->id()];
        }
    }
}

