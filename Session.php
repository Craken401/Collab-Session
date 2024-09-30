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
 * Class Session
 *
 * This class handles the CRUD operations for collaborative sessions.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_login();

class Session {

    // Crear nueva sesión
    public static function create($data) {
        global $DB;
        $session = new stdClass();
        $session->nombre_sesion = $data->nombre_sesion;
        $session->estado_sesion = $data->estado_sesion;  // Se puede establecer como 'activa' por defecto
        $session->fecha_inicio = $data->fecha_inicio;
        $session->fecha_fin = isset($data->fecha_fin) ? $data->fecha_fin : null; // Puede ser nulo

        try {
            return $DB->insert_record('sesiones_colaborativas', $session, true);
        } catch (dml_exception $e) {
            throw new moodle_exception('inserterror', 'mod_collabsession', '', null, $e->getMessage());
        }
    }

    // Actualizar sesión
    public static function update($data) {
        global $DB;
        $session = new stdClass();
        $session->id_sesion = $data->id_sesion;
        $session->nombre_sesion = $data->nombre_sesion;
        $session->estado_sesion = $data->estado_sesion;
        $session->fecha_inicio = $data->fecha_inicio;
        $session->fecha_fin = isset($data->fecha_fin) ? $data->fecha_fin : null;

        try {
            return $DB->update_record('sesiones_colaborativas', $session);
        } catch (dml_exception $e) {
            throw new moodle_exception('updateerror', 'mod_collabsession', '', null, $e->getMessage());
        }
    }

    // Eliminar sesión
    public static function delete($id) {
        global $DB;
        try {
            return $DB->delete_records('sesiones_colaborativas', ['id_sesion' => $id]);
        } catch (dml_exception $e) {
            throw new moodle_exception('deleteerror', 'mod_collabsession', '', null, $e->getMessage());
        }
    }

    // Leer una sesión
    public static function read($id) {
        global $DB;
        return $DB->get_record('sesiones_colaborativas', ['id_sesion' => $id], '*', MUST_EXIST);
    }

    // Leer todas las sesiones
    public static function read_all() {
        global $DB;
        return $DB->get_records('sesiones_colaborativas');
    }
}