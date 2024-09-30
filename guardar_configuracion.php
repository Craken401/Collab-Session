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

require_once('../../config.php');
require_once('Session.php');

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre_sesion = required_param('nombre_sesion', PARAM_TEXT);
    $fecha_inicio = required_param('fecha_inicio', PARAM_TEXT);

    // Convertir la fecha al formato adecuado (de 'd/m/Y H:i' a 'Y-m-d H:i:s')
    $fecha_inicio_formateada = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $fecha_inicio)));

    // Si el campo 'estado_sesion' no está en el formulario, asignar un valor por defecto
    $estado_sesion = 'activa';

    // Preparar el objeto para la sesión
    $sessiondata = new stdClass();
    $sessiondata->nombre_sesion = $nombre_sesion;
    $sessiondata->fecha_inicio = $fecha_inicio_formateada;
    $sessiondata->estado_sesion = $estado_sesion;

    // Intentar crear la sesión
    try {
        $sessionid = Session::create($sessiondata);
        if ($sessionid && $DB->record_exists('sesiones_colaborativas', array('id_sesion' => $sessionid))) {
            redirect(new moodle_url('/mod/collabsession/view.php', ['id' => $sessionid]), 'Sesión creada correctamente');
        } else {
            echo 'Error al crear o encontrar la sesión';
        }
    } catch (dml_exception $e) {
        // Capturar el error de base de datos y mostrarlo
        echo 'Error al insertar la sesión: ' . $e->getMessage();
    }
} else {
    echo 'Método no permitido';
}



