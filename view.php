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

 require(__DIR__ . '/../../config.php');
 require_once(__DIR__ . '/lib.php');
 
 $id = optional_param('id', 0, PARAM_INT); // ID del módulo del curso
 
 // Validar si existe el parámetro 'id'
 if (!$id) {
     print_error('missingparam', 'error', '', 'id');
 }
 
 // Obtener el curso y la instancia del módulo
 $cm = get_coursemodule_from_id('collabsession', $id, 0, false, MUST_EXIST);
 $course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
 $moduleinstance = $DB->get_record('collabsession', ['id' => $cm->instance], '*', MUST_EXIST);
 
 // Requerir autenticación para acceder a la sesión colaborativa
 require_login($course, true, $cm);
 
 $context = context_module::instance($cm->id);
 
 $PAGE->set_url('/mod/collabsession/view.php', ['id' => $cm->id]);
 $PAGE->set_title(format_string($moduleinstance->name));
 $PAGE->set_heading(format_string($course->fullname));
 $PAGE->set_context($context);
 
 // Renderizar la página
 echo $OUTPUT->header();

 // Contexto para renderizar el template del navbar.
 $templatecontext = [
     'config' => $CFG, // Añade variables necesarias para el template
     'sitename' => format_string($SITE->fullname),
 ];

 // Renderizar el template del navbar.
 echo $OUTPUT->render_from_template('mod_collabsession/navbar', $templatecontext);

 // Pie de página
 echo $OUTPUT->footer();
