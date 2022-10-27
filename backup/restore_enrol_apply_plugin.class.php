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
 * Defines the restore_enrol_lti_plugin class.
 *
 * @package   enrol_lti
 * @copyright 2016 Mark Nelson <markn@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/enrol/apply/lib.php');

/**
 * Provides the information to restore test enrol instances
 */
class restore_enrol_apply_plugin extends restore_enrol_plugin {

    /**
     * TODO finish PHPDOC.
     *
     * @return restore_path_element[]
     */
    public function define_enrol_plugin_structure() {
        return array(
                new restore_path_element('applymap', $this->get_pathfor('/applymaps/applymap')),
        );
    }

    /**
     * Process the termmap element.
     *
     * @return void
     */
    public function process_applymap($data) {
        global $DB;

        $data = (object)$data;
        $enrolid = $this->get_new_parentid('enrol');

        if (!$enrolid) {
            return; // Enrol instance was not restored.
        }
        $type = $DB->get_field('enrol', 'enrol', array('id' => $enrolid));
        if ($type !== 'apply') {
            return; // Enrol was likely converted to manual.
        }
        $data->enrolid = $enrolid;
        $data->courseid = $this->task->get_courseid();
    }

}
