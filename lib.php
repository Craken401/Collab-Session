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
 * Library of interface functions and constants.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function collabsession_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

function collabsession_add_instance($moduleinstance, $mform = null) {
    global $DB;
    $moduleinstance->timecreated = time();
    try {
        $id = $DB->insert_record('collabsession', $moduleinstance, true);
        return $id;
    } catch (dml_exception $e) {
        throw new moodle_exception('inserterror', 'mod_collabsession', '', null, $e->getMessage());
    }
}

function collabsession_update_instance($moduleinstance, $mform = null) {
    global $DB;
    $moduleinstance->timemodified = time();
    $moduleinstance->id = $moduleinstance->instance;
    try {
        return $DB->update_record('collabsession', $moduleinstance);
    } catch (dml_exception $e) {
        throw new moodle_exception('updateerror', 'mod_collabsession', '', null, $e->getMessage());
    }
}

function collabsession_delete_instance($id) {
    global $DB;
    if (!$DB->record_exists('collabsession', ['id' => $id])) {
        return false;
    }
    try {
        $DB->delete_records('collabsession', ['id' => $id]);
        return true;
    } catch (dml_exception $e) {
        throw new moodle_exception('deleteerror', 'mod_collabsession', '', null, $e->getMessage());
    }
}

function create_or_update_session($data) {
    global $DB;

    $session = new stdClass();
    $session->name = $data->sessionname;
    $session->description = $data->sessiondescription;
    $session->participants = $data->participants;
    if (isset($data->id) && !empty($data->id)) {
        $session->id = $data->id;
        $session->timemodified = time();
        $DB->update_record('collabsession', $session);
    } else {
        $session->timecreated = time();
        $session->timemodified = $session->timecreated;
        $session->id = $DB->insert_record('collabsession', $session, true);
    }

    return $session->id;
}
