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
 require_once($CFG->dirroot . '/mod/collabsession/classes/Session.php');

 require_login();
 
 $titulo = required_param('tituloReunion', PARAM_TEXT);
 $fecha = required_param('fechaSesion', PARAM_TEXT);
 
 $sessiondata = new stdClass();
 $sessiondata->sessionname = $titulo;
 $sessiondata->sessiondescription = '';  // Añade descripción si tienes
 $sessiondata->participants = '';  // Añade participantes si tienes
 
 $sessionid = Session::create($sessiondata);
 
 if ($sessionid) {
     echo json_encode(['success' => true]);
 } else {
     echo json_encode(['success' => false, 'message' => 'Error al guardar la configuración']);
 }
 



