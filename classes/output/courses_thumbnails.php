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
 * Theme IMT Courses thumbnails
 *
 * @package    theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_imt\output;

use coding_exception;
use context_course;
use context_helper;
use dml_exception;
use renderable;
use renderer_base;
use templatable;

/**
 * Class containing data for featured_courses block.
 *
 * @package    theme_imt
 * @copyright 2023 - CALL Learning - Martin CORNU-MANSUY <martin@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class courses_thumbnails implements renderable, templatable {

    /**
     * @var array course
     */
    public $courses = [];

    /**
     * featured_courses constructor.
     * Retrieve matchin courses
     *
     * @param int $coursesid
     * @throws coding_exception
     * @throws dml_exception
     */
    public function __construct($coursesid) {
        global $DB;
        list($sql, $params) = $DB->get_in_or_equal($coursesid, SQL_PARAMS_NAMED);
        $this->courses = $DB->get_records_select('course', 'id ' . $sql, $params);
    }

    /**
     * Export featured course data
     *
     * @param renderer_base $renderer
     * @return array
     * @throws coding_exception
     */
    public function export_for_template(renderer_base $renderer): array {
        $formattedcourses = array_map(function($course) use ($renderer) {
            context_helper::preload_from_record($course);
            $context = context_course::instance($course->id);
            $exporter = new mini_course_summary_exporter($course, ['context' => $context]);
            return (array) $exporter->export($renderer);
        }, $this->courses);
        return [
            'courses' => array_values((array) $formattedcourses),
        ];
    }
}
