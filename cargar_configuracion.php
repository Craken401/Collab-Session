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
require_once($CFG->dirroot . '/mod/collabsession/classes/Session.php');
require_login();

global $DB;

// Obtener los últimos datos guardados
$lastsession = $DB->get_record_sql('SELECT * FROM {sesiones_colaborativas} ORDER BY id_sesion DESC LIMIT 1');

// Devolver respuesta en formato JSON
if ($lastsession) {
    echo json_encode([
        'success' => true,
        'tituloReunion' => $lastsession->nombre_sesion,
        'fechaSesion' => $lastsession->fecha_inicio
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró configuración guardada']);
}
