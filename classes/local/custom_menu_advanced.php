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
 * Custom menu with additional icons
 *
 * @package   theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_imt\local;

use custom_menu;
use theme_imt\local\custom_menu_advanced_trait;

/**
 * Custom menu class with icons
 *
 * @package   theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning.fr>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class custom_menu_advanced extends custom_menu {
    use custom_menu_advanced_trait;
}
