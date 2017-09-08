<?php

namespace Drupal\ref_settings;

use Drupal\Core\Routing\UrlGeneratorTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\Entity\NodeType;
use Drupal\ref_settings\Entity\SettingsType;

/**
 * Provides dynamic permissions for settings of different types.
 */
class SettingsPermissions {

  /**
   * Returns an array of settings type permissions.
   *
   * @return array
   *   The settings type permissions.
   *   @see \Drupal\user\PermissionHandlerInterface::getPermissions()
   */
  public function settingsTypePermissions() {
    $perms = [];
    // Generate node permissions for all node types.
    foreach (SettingsType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }

    return $perms;
  }

  /**
   * Returns a list of settings permissions for a given settings type.
   *
   *
   * @param \Drupal\ref_settings\Entity\SettingsType $type
   *
   * @return array An associative array of permission names and descriptions.
   * An associative array of permission names and descriptions.
   */
  protected function buildPermissions(SettingsType $type) {
    $type_id = $type->id();
    $type_params = ['%type_name' => $type->label()];

    return [
      "edit settings in $type_id" => [
        'title' => $this->t('%type_name: Edit settings', $type_params),
      ],
    ];
  }

}
