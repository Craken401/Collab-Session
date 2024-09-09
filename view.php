<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Prints an instance of mod_collabsession.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

$id = optional_param('id', 0, PARAM_INT); // Course module ID

if (!$id) {
    print_error('missingparam', 'error', '', 'id');
}

$cm = get_coursemodule_from_id('collabsession', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$moduleinstance = $DB->get_record('collabsession', array('id' => $cm->instance), '*', MUST_EXIST);

require_login($course, true, $cm);

$context = context_module::instance($cm->id);

$PAGE->set_url('/mod/collabsession/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($moduleinstance->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

$event = \mod_collabsession\event\course_module_viewed::create(array(
    'objectid' => $moduleinstance->id,
    'context' => $context
));
$event->add_record_snapshot('course', $course);
$event->add_record_snapshot('collabsession', $moduleinstance);
$event->trigger();

echo $OUTPUT->header();
$url = new moodle_url('/mod/collabsession/collaborate.php', ['id' => $cm->id]); // Asegúrate de que la URL es correcta según tu estructura de archivos
$buttonlabel = get_string('startcollab', 'mod_collabsession'); // Asegúrate de haber definido esta cadena en tu archivo de idioma
echo $OUTPUT->single_button($url, $buttonlabel, 'get');
echo $OUTPUT->footer();

