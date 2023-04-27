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
 * Setup routine for theme
 *
 * @package   theme_imt
 * @copyright 2023 - CALL Learning - Laurent David <laurent@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_imt;

use coding_exception;
use context_course;
use context_module;
use context_system;
use core_user;
use dml_exception;
use moodle_page;
use moodle_url;
use theme_clboost\setup_utils;
// use const theme_imt\SITEID;

/**
 * Class setup
 *
 * Utility setup class.
 *
 * @copyright   2023 Laurent David - CALL Learning <laurent@call-learning.fr>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class setup {

    /**
     * Dashboard block definition
     */
    const DASHBOARD_BLOCK_DEFINITION = array(
        array(
            'blockname' => 'html',
            'showinsubcontexts' => '1',
            'defaultregion' => 'content',
            'defaultweight' => '0',
            'configdata' =>
                [
                    "title" => "Bienvenue !",
                    "format" => "1",
                    "classes" => "db-welcome",
                    "backgroundcolor" => "",
                    "text" => '<p>Que voulez-vous faire aujourd’hui ?</p>
<div class="bienvenue d-flex flex-wrap flex-md-nowrap justify-content-between align-items-center my-4">
    <a>
	    <img src="/theme/imt/pix/icons/book.svg" alt="Book"/>
        <span>Créer un nouveau cours</span>
    </a>
    <a>
        <img src="/theme/imt/pix/icons/hand-leaf.svg" alt="Share"/>
        <span>Partager une ressource</span>
    </a>
    <a>
        <img src="/theme/imt/pix/icons/bubbles.svg" alt="Talk"/>
        <span>Echanger avec mes collègues</span>
    </a>
</div>'],
            'capabilities' => array()
        ),
        array(
            'blockname' => 'forum_feed',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '1',
            'configdata' => array('title' => 'Les news du mur pédagogique', 'maxtextlength' => 75, 'maxfeed' => 5),
            'capabilities' => array()
        ),
        array(
            'blockname' => 'calendar_upcoming',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '2',
            'configdata' => array(),
            'capabilities' => array()
        ),
        array(
            'blockname' => 'enhanced_myoverview',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '3',
            'configdata' => array('title' => 'Les cours que j\'enseigne', 'filter' => 'iteach'),
            'capabilities' => array()
        ),
        array(
            'blockname' => 'myoverview',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '4',
            'configdata' => array(),
            'capabilities' => array()
        )
    );

    // @codingStandardsIgnoreStart
    // phpcs:disable
    /**
     * Homepage block definition
     */
    const HOMEPAGE_BLOCK_DEFINITION = array(
        array(
            'blockname' => 'html',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '1',
            'configdata' =>
                [
                    "title" => "Qu’est-ce que la Pédagothèque Numérique ?",
                    "format" => "1",
                    "classes" => "block-what-is-imt",
                    "text" => "<p>La Pédagothèque Numérique est une plateforme permettant de regrouper tout le contenu pédagogique 
            des écoles du groupe Institut Mines-Télécom. 
            Elle a pour vocation de favoriser les échanges entre écoles et d’harmoniser les enseignements. Elle met à disposition des cours en accès libre afin que tout les membres de l’IMT, étudiants comme enseignants ou membres de l’équipe adminstrative puisse bénéficier du savoir détenu dans toutes les écoles..</p>"],
            'capabilities' => array()
        ),
        array('blockname' => 'mcms',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '2',
            'configdata' => [
                "title" => "Pour les enseignants",
                "format" => "1",
                "classes" => "block-for-teachers",
                "backgroundcolor" => "",
                "text" => "<p>Parcourez les ressources mises à disposition par vos homologues des autres écoles du groupe, construisez vos cours grâce à ce contenu partagé et mettez en ligne vos prochains cours.</p>
            <p>Échangez sur votre spécialité ou vos thèmes d’affections avec vos collègues grâce au mur pédagogique.</p>
            <p>Vous pouvez également prendre le temps de suivre des cours dédiés au personnel de l’IMT ou des cours dispensés par vos collègues pour élargir vos connaissances.</p>
            <strong>Qu’est-ce que vous voulez faire ?</strong>
            <ul>
            <li><a href='#'>Transformer mes enseignements à distance <i class='fa fa-external-link'></i></a></li>
            <li><a href='#'>Échanger entre enseignants <i class='fa fa-external-link'></i></a></li>
            <li><a href='#'>Créer un dispositif de formation en ligne <i class='fa fa-external-link'></i></a></li>
            <li><a href='#'>M’inspirer et partager des pratiques innovantes <i class='fa fa-external-link'></i></a></li>
            <li><a href='#'>M’inspirer et partager des pratiques innovantes <i class='fa fa-external-link'></i></a></li>
            <li><a href='#'>Valoriser et faire reconnaitre mon parcours d’enseignement <i class='fa fa-external-link'></i></a></li>
            </ul>
            ",
                "layout" => "layout_three"
            ],
            'capabilities' => [],
            'files' => [
                'side-image.png' => [
                    'filepath' => 'theme/imt/data/files/fp/teacher.png',
                    'filearea' => 'images',
                    'itemid' => 0
                ]
            ],
        ),
        array('blockname' => 'mcms',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '3',
            'configdata' => [
                "title" => "Pour les étudiants",
                "format" => "1",
                "classes" => "block-for-students",
                "backgroundcolor" => "",
                "text" => '<p dir="ltr">Suivez les cours dispensés par vos professeurs par le biais de cette plateforme, ou explorez les cours disponibles en accès libre par thèmes afin de vous autoformer et compléter votre cursus<br></p>
<p dir="ltr"><br></p>
<p dir="ltr"><br></p>',
                "layout" => "layout_four"
            ],
            'capabilities' => [],
            'files' => [
                'side-image.png' => [
                    'filepath' => 'theme/imt/data/files/fp/student.png',
                    'filearea' => 'images',
                    'itemid' => 0
                ]
            ],
        ),
        array('blockname' => 'featured_courses',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '4',
            'configdata' => [
                "title" => "Cours à la une",
                "selectedcourses" => [2, 3, 4, 5]
            ],
            'capabilities' => array()
        ),
        array('blockname' => 'rss_thumbnails',
            'showinsubcontexts' => '0',
            'defaultregion' => 'content',
            'defaultweight' => '5',
            'configdata' => [
                "display_description" => "0",
                "title" => "Quoi de neuf?",
                "carousselspeed" => "4000",
                "show_channel_link" => "0",
                "remove_image_size_suffix" => "1",
                "rssid" => "1"
            ],
            'capabilities' => [],
        )

    );
    /**
     * The defaults settings
     */
    const DEFAULT_SETTINGS = [
        'moodle' => [
            'country' => 'FR',
            'timezone' => 'Europe/Paris',
            'block_html_allowcssclasses' => true,
            'defaulthomepage' => HOMEPAGE_MY,
        ]
    ];

    /**
     * Install updates
     */
    public static function install_update() {
        global $PAGE, $CFG, $DB, $OUTPUT;

        static::setup_config_values();
        if (!$DB->record_exists('block_rss_thumbnails', ['url' => 'https://www.imt.fr/feed/'])) {
            $id = $DB->insert_record(
                'block_rss_thumbnails',
                array('userid' => get_admin()->id,
                    'title' => 'IMT',
                    'preferredtitle' => '',
                    'description' =>
                        'Premier groupe de grandes écoles d\'ingénieurs et managers en France',
                    'shared' => '0',
                    'url' => 'https://www.imt.fr/feed/',
                    'skiptime' => '0',
                    'skipuntil' => '0')
            );
        }
        require_once($CFG->dirroot . '/my/lib.php');
        // Get the default Dashboard block.
        $defaultmy = my_get_page(null, MY_PAGE_PRIVATE);

        $page = new moodle_page();
        $page->set_pagetype('my-index');
        $page->set_subpage($defaultmy->id);
        $page->set_url(new moodle_url('/'));
        $page->set_context(context_system::instance());

        $oldpage = $PAGE;
        $PAGE = $page;
        $dashboarddef = self::DASHBOARD_BLOCK_DEFINITION;
        setup_utils::setup_page_blocks($page, $dashboarddef);
        my_reset_page_for_all_users();
        // Setup Home page.
        $page = new moodle_page();
        $page->set_pagetype('site-index');
        $page->set_docs_path('');
        $page->set_context(context_course::instance(SITEID));
        $PAGE = $page;
        setup_utils::setup_page_blocks($page, self::HOMEPAGE_BLOCK_DEFINITION);
        $PAGE = $oldpage;

        // Setup sharing cart
        if ($DB->record_exists('block', array('name' => 'sharing_cart'))) {
            // Setup Ressource library activities.
            $page = new moodle_page();
            $page->set_pagetype('resource-library-activities');
            $page->set_docs_path('');
            $page->set_context(context_system::instance());
            $PAGE = $page;
            setup_utils::setup_page_blocks($page, array(
                    array(
                        'blockname' => 'sharing_cart',
                        'showinsubcontexts' => '1',
                        'defaultregion' => 'side-right',
                        'defaultweight' => '0',
                        'configdata' => [],
                        'capabilities' => array()
                    ),
                )
            );
            $PAGE = $oldpage;

        }
        // Rebuild the OUTPUT variable as if not $OUPUT->page is set to the last set page.
        // This will avoid an error message when the renderer is used later
        // and does not point the right page.
        $target = null;
        if ($PAGE->pagelayout === 'maintenance') {
            // If the page is using the maintenance layout then we're going to force target to maintenance.
            // This leads to a special core renderer that is designed to block access to API's that are likely unavailable for this
            // page layout.
            $target = RENDERER_TARGET_MAINTENANCE;
        }
        $OUTPUT = $PAGE->get_renderer('core', null, $target);
    }


    // @codingStandardsIgnoreStart
    // phpcs:disable

    /**
     * Setup config values
     */
    public static function setup_config_values() {
        foreach (self::DEFAULT_SETTINGS as $pluginname => $plugindefs) {
            $plugin = $pluginname;
            if ($pluginname === 'moodle') {
                $plugin = null;
            }
            foreach ($plugindefs as $key => $value) {
                $configvalue = get_config($plugin, $key);
                if ($configvalue != $value) {
                    set_config($key, $value, $plugin);
                }
            }
        }
    }

    /**
     * Default value for theme match.
     */
    const DEFAULT_THEME_MATCH = [
        'imt-nord-europe.fr' => 'imt_lille',
        'imt-atlantique.fr' => 'imt_atlantique',
        'mines-albi.fr' => 'imt_albi_carmaux',
    ];

    /**
     * Set user theme for user
     *
     * @param int $userid
     * @return void
     * @throws dml_exception
     */
    public static function setup_user_theme($userid) {
        global $DB, $PAGE, $USER;
        $user = core_user::get_user($userid);
        if ($user) {
            $themelist = get_list_of_themes();
            $emailvstheme = get_config('theme_imt', 'emailvstheme');
            if ($emailvstheme && ($themematch = json_decode($emailvstheme))) {
                foreach ((array) $themematch as $domainname => $themename) {
                    if (strstr($user->email, $domainname)) {
                        if (in_array($themename, array_keys($themelist))) {
                            $currenttheme = $DB->get_field('user', 'theme', ['id' => $user->id]);
                            if ($currenttheme != $themename) {
                                $DB->set_field('user', 'theme', $themename, ['id' => $user->id]);
                                $USER->theme = $themename;
                                if ($PAGE) {
                                    $PAGE->initialise_theme_and_output();
                                    $PAGE->reload_theme();
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
