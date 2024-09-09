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

require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

$id = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
require_course_login($course);
$coursecontext = context_course::instance($course->id);

//Iniciar visualización de la página
echo $OUTPUT->header();

//Mensaje de bienvenida y botón para iniciar sesión colaborativa
echo html_writer::tag('h2', get_string('welcome', 'mod_collabsession'));
echo html_writer::tag('p', get_string('introduction_text', 'mod_collabsession'));
echo $OUTPUT->single_button(new moodle_url('/mod/collabsession/startsession.php', array('id' => $id)), get_string('startsession', 'mod_collabsession'), 'get');

//Encabezado para las sesiones existentes
$modulenameplural = get_string('modulenameplural', 'mod_collabsession');
echo $OUTPUT->heading($modulenameplural);

//Listado de sesiones existentes
$collabsessions = get_all_instances_in_course('collabsession', $course);
if (empty($collabsessions)) {
    notice(get_string('nocollabsessioninstances', 'mod_collabsession'), new moodle_url('/course/view.php', array('id' => $course->id)));
}

//Construcción y visualización de la tabla de sesiones
$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';
$table->head = ($course->format == 'weeks' || $course->format == 'topics') ? array(get_string($course->format), get_string('name')) : array(get_string('name'));
$table->align = array('center', 'left');

foreach ($collabsessions as $collabsession) {
    $link = html_writer::link(new moodle_url('/mod/collabsession/view.php', array('id' => $collabsession->coursemodule)), format_string($collabsession->name, true), array('class' => $collabsession->visible ? '' : 'dimmed'));
    $row = ($course->format == 'weeks' || $course->format == 'topics') ? array($collabsession->section, $link) : array($link);
    $table->data[] = $row;
}

echo html_writer::table($table);
echo $OUTPUT->footer();
