<?php

namespace Sober\Intervention\Module;

use Sober\Intervention\Instance;
use Sober\Intervention\Util;

/**
 * Module: add-acf-page
 *
 * Uses Advanced Custom Fields function acf_add_options_page to add an options page.
 *
 * @example intervention('add-acf-page', $config(string|array), $roles(string|array));
 *
 * @link https://www.advancedcustomfields.com/resources/acf_add_options_page/
 *
 * @package WordPress
 * @subpackage Intervention
 * @since 1.0.0
 */
class AddAcfPage extends Instance
{
    public function run()
    {
        $this->setup();
        $this->setupStrToAcf();
        $this->addAcfPage();
    }

    protected function setup()
    {
        $this->setDefaultConfig([]);
        $this->setDefaultRoles(['admin', 'editor']);
        $this->roles = $this->aliasUserRoles($this->roles);
    }

    protected function setupStrToAcf()
    {
        if (Util::isArrayValueSet(0, $this->config)) {
            $this->config = Util::escArray($this->config);
            $this->config = [
                'page_title' => $this->config,
                'menu_title' => $this->config,
                'menu_slug'  => strtolower(str_replace(' ', '_', $this->config))
            ];
        }
    }

    public function addAcfPage()
    {
        foreach ($this->roles as $role) {
            if (current_user_can($role)) {
                if (function_exists('acf_add_options_page')) {
                    acf_add_options_page($this->config);
                }
            }
        }
    }
}
