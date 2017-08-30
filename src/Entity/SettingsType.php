<?php

namespace Drupal\ref_settings\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Settings Type
 *
 * @ConfigEntityType(
 *   id = "settings_type",
 *   label = @Translation("Settings Type"),
 *   bundle_of = "settings",
 *   config_prefix = "settings_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "settings_type",
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   handlers = {
 *     "list_builder" =
 *   "Drupal\ref_settings\Controller\SettingsTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\ref_settings\Form\SettingsTypeForm",
 *       "add" = "Drupal\ref_settings\Form\SettingsTypeForm",
 *       "edit" = "Drupal\ref_settings\Form\SettingsTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer site configuration",
 *   links = {
 *     "canonical" = "/admin/structure/settings_type/{settings_type}",
 *     "add-form" = "/admin/structure/settings_type/add",
 *     "edit-form" = "/admin/structure/settings_type/{settings_type}/edit",
 *     "delete-form" = "/admin/structure/settings_type/{settings_type}/delete",
 *     "collection" = "/admin/structure/settings_type",
 *   }
 * )
 */
class SettingsType extends ConfigEntityBundleBase {

  /**
   * The machine name of this settings type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the settings type.
   *
   * @var string
   */
  protected $label;

  /**
   * A brief description of this settings type.
   *
   * @var string
   */
  protected $description;

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function save() {
    $return = parent::save();
    $this->updateContentEntity();
    return $return;
  }

  /**
   * Create the content entity for this settings type.
   */
  private function updateContentEntity() {
    $id = $this->id();
    $setting = Settings::loadByName($id);
    if ($setting) {
      return TRUE;
    }

    $setting = Settings::create([
      'name' => $id,
      'type' => $this->id(),
    ]);

    $setting->save();
  }
}