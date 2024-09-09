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
 * Display information about all the mod_collabsession modules in the requested course.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/collabsession/lib.php');
require_once($CFG->dirroot . '/mod/collabsession/mod_form.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('collabsession', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
require_login($course, true, $cm);

$PAGE->set_url(new moodle_url('/mod/collabsession/collaborate.php', ['id' => $id]));
$PAGE->set_title(format_string($course->fullname));
$PAGE->set_heading(format_string($course->fullname));

$context = context_module::instance($cm->id);
$customdata = ['context' => $context];
$mform = new mod_collabsession_mod_form(new moodle_url('/mod/collabsession/collaborate.php', ['id' => $id]), $customdata, 'post', '', null, true);

echo $OUTPUT->header();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/course/view.php', ['id' => $course->id]));
} elseif ($fromform = $mform->get_data()) {
    $sessionid = create_or_update_session($fromform); // Make sure this function is correctly defined
    $event = \mod_collabsession\event\session_created::create([
        'context' => $context,
        'objectid' => $sessionid,
    ]);
    $event->trigger();
    redirect(new moodle_url('/mod/collabsession/view.php', ['id' => $cm->id]), get_string('sessionsuccess', 'mod_collabsession'), null, \core\output\notification::NOTIFY_SUCCESS);
} else {
    $mform->display();
}

echo $OUTPUT->footer();

