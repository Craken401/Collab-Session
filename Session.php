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

 class Session {
    public static function create($data) {
        global $DB;
        $session = new stdClass();
        $session->name = $data->sessionname;
        $session->description = $data->sessiondescription;
        $session->participants = $data->participants;
        $session->timecreated = time();
        $session->timemodified = $session->timecreated;
        return $DB->insert_record('collabsession', $session, true);
    }

    public static function update($data) {
        global $DB;
        $session = new stdClass();
        $session->id = $data->id;
        $session->name = $data->sessionname;
        $session->description = $data->sessiondescription;
        $session->participants = $data->participants;
        $session->timemodified = time();
        return $DB->update_record('collabsession', $session);
    }

    public static function delete($id) {
        global $DB;
        return $DB->delete_records('collabsession', ['id' => $id]);
    }
}