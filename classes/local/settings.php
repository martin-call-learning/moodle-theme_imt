<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme settings. In one place.
 *
 * @package   theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_imt\local;

use admin_setting_configcheckbox;
use admin_setting_confightmleditor;
use admin_setting_configstoredfile;
use admin_setting_configtext;
use admin_settingpage;
use theme_imt\setup;

/**
 * Theme settings. In one place.
 *
 * @package   theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings extends \theme_clboost\local\settings {

    /**
     * Default content for Footer
     */
    const DEFAULT_FOOTER_CONTENT = '
    <div class="footer__stores">
        <a href="#">
            <img src="/theme/imt/pix/logos/logo-appstore.png" alt="Disponible sur app store">
          </a>
        <a href="#">
            <img src="/theme/imt/pix/logos/logo-googleplay.png" alt="Disponible sur google play">
        </a>
    </div>
    ';
    /**
     * Default rules
     */
    const DEFAULT_RULES = "
        <h3>Règles de participation</h3>
        <p><strong>Respect</strong> : les utilisateurs doivent s’adresser aux autres utilisateurs, à la modération et à
        l'administration du Mur pédagogique avec respect, en évitant les commentaires irritants, irrespectueux, faux ou pouvant
        porter préjudice à un utilisateur ou une entité.</p>
        <p><strong>Spams</strong> : tout message doit rester en lien avec la thématique du groupe et sans intention
        promotionnelle ou commerciale.
        <p><strong>Responsabilité des auteurs</strong>: les auteurs de messages sont seuls responsables de leur propos
        et des contenus qu’ils y joignent. Ceux-ci ne sont, par ailleurs, pas nécessairement approuvés par
        l’administration de la Pédagothèque numérique ou la Direction de l’IMT.</p>
        <p><strong>Visibilité des messages</strong> : les messages ne sont visibles que par les utilisateurs
        authentifiés sur la Pédagothèque numérique, membres du groupe concerné.L’équipe de modération se réserve le
        droit de supprimer, avec ou sans avertissement, à sa discrétion, tout message qui ne respectent pas ces
        règles. Si, en tant qu'utilisateur, vous jugez qu'une contribution ne respecte pas ces règles, merci de le signaler
        à l’adresse pedagotheque@imt.fr.</p>
        <p>Il est néanmoins possible que nous commettions des erreurs d’interprétation : si vous pensez qu’une contribution
        a été supprimée par erreur, merci de le signaler à l’adresse pedagotheque@imt.fr.</p>
    ";

    /**
     * Additional settings
     *
     * This is intended to be overriden in the subtheme to add new pages for example.
     *
     * @param admin_settingpage $settings
     * @param string $currentthemename
     */
    protected static function additional_settings(admin_settingpage &$settings, $currentthemename = 'clboost') {
        // Advanced settings.
        $page = new admin_settingpage('footer',
            static::get_string('footer', 'theme_imt'));

        $setting = new admin_setting_confightmleditor('theme_imt/footercontent',
            static::get_string('footercontent', 'theme_imt'),
            static::get_string('footercontent_desc', 'theme_imt'),
            self::DEFAULT_FOOTER_CONTENT,
            PARAM_RAW);
        $page->add($setting);

        $settings->add($page);

        $settings->add($page);

        // Profile page.
        $page = new admin_settingpage('profilepage',
            static::get_string('profilepage', 'theme_imt'));

        $setting = new admin_setting_configcheckbox('theme_imt/simplifiedprofilepage',
            static::get_string('simplifiedprofilepage', 'theme_imt'),
            static::get_string('simplifiedprofilepage_desc', 'theme_imt'),
            true);
        $page->add($setting);

        $setting = new admin_setting_configtext('theme_imt/profilecomponentsexclusion',
            static::get_string('profilecomponentsexclusion', 'theme_imt'),
            static::get_string('profilecomponentsexclusion_desc', 'theme_imt'),
            'report,tool,gradereport,loginactivity,badges,miscellaneous,notes');
        $page->add($setting);

        $setting = new admin_setting_configtext('theme_imt/profilemodulessexclusion',
            static::get_string('profilemodulesexclusion', 'theme_imt'),
            static::get_string('profilemodulesexclusion_desc', 'theme_imt'),
            'tool_mobile,mod_forum');
        $page->add($setting);

        $settings->add($page);

        // Advanced settings.
        $page = new admin_settingpage('othersettings',
            static::get_string('othersettings', 'theme_imt'));

        $setting = new admin_setting_configstoredfile('theme_imt/profilebgimage',
            static::get_string('profilebgimage', 'theme_imt'),
            static::get_string('profilebgimage_desc', 'theme_imt'),
            utils::PROFILE_IMAGE_FILE_AREA);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);
        if ($currentthemename === 'imt') {
            $setting = new \admin_setting_configtextarea('theme_imt/emailvstheme',
                static::get_string('emailvstheme', 'theme_imt'),
                static::get_string('emailvstheme_desc', 'theme_imt'),
                json_encode(setup::DEFAULT_THEME_MATCH, JSON_PRETTY_PRINT));
            $page->add($setting);
        }

        $page->add($setting);
        $settings->add($page);

    }
}
