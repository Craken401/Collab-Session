<?php
// Este archivo forma parte de Moodle
//
// Moodle es software libre: puedes redistribuirlo y/o modificarlo bajo los términos de la
// GNU General Public License tal como lo publica la Free Software Foundation,
// ya sea la versión 3 de la Licencia, o cualquier versión posterior.
//
// Moodle se distribuye con la esperanza de que sea útil, pero sin ninguna garantía;
// incluso sin la garantía implícita de COMERCIABILIDAD o IDONEIDAD PARA UN PROPÓSITO PARTICULAR.
// Mira la GNU General Public License para más detalles.
//
// Deberías haber recibido una copia de la GNU General Public License junto con Moodle.
// Si no, mira <http://www.gnu.org/licenses/>.

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/collabsession/classes/Session.php');
require_login();

global $DB;

try {
    // Obtener los últimos datos guardados.
    $lastsession = $DB->get_record_sql('SELECT * FROM {sesiones_colaborativas} ORDER BY id_sesion DESC LIMIT 1');
    
    if ($lastsession) {
        // Devolver respuesta en formato JSON con los datos.
        echo json_encode([
            'success' => true,
            'tituloReunion' => $lastsession->nombre_sesion,
            'fechaSesion' => $lastsession->fecha_inicio,
        ]);
    } else {
        // Caso donde no se encuentra ninguna sesión en la base de datos.
        echo json_encode(['success' => false, 'message' => 'No se encontró configuración guardada.']);
    }
} catch (dml_exception $e) {
    // Capturar cualquier excepción de base de datos y devolver error en formato JSON.
    echo json_encode(['success' => false, 'message' => 'Error en la consulta a la base de datos: ' . $e->getMessage()]);
}
