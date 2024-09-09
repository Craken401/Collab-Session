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
 * The main mod_collabsession configuration form.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form.
 *
 * @package     mod_collabsession
 * @copyright   2024 Victor <victornolsa@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_collabsession_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        // Adding the "general" fieldset, where all the common settings are shown.
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field.
        $mform->addElement('text', 'name', get_string('collabsessionname', 'mod_collabsession'), array('size' => '64'));

        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }

        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'collabsessionname', 'mod_collabsession');

        // Adding the standard "intro" and "introformat" fields.
        if ($CFG->branch >= 29) {
            $this->standard_intro_elements();
        } else {
            $this->add_intro_editor();
        }

        // Adding the rest of mod_collabsession settings, spreading all them into this fieldset
        // ... or adding more fieldsets ('header' elements) if needed for better logic.
        $mform->addElement('static', 'label1', 'collabsessionsettings', get_string('collabsessionsettings', 'mod_collabsession'));
        $mform->addElement('header', 'collabsessionfieldset', get_string('collabsessionfieldset', 'mod_collabsession'));

        // Add standard elements.
        $this->standard_coursemodule_elements();

        // Add standard buttons.
        $this->add_action_buttons();

        // campo para que el usuario pueda especificar la duración de la sesión.
        $mform->addElement('duration', 'duration', get_string('sessionduration', 'mod_collabsession'));
        $mform->setDefault('duration', 3600); // default a 1 hour
        $mform->addHelpButton('duration', 'sessionduration', 'mod_collabsession');


        $options = array(
            'chat' => get_string('tool_chat', 'mod_collabsession'),
            'whiteboard' => get_string('tool_whiteboard', 'mod_collabsession'),
            'filesharing' => get_string('tool_filesharing', 'mod_collabsession')
        );
        $mform->addElement('select', 'availabletools', get_string('availabletools', 'mod_collabsession'), $options);
        $mform->setDefault('availabletools', 'chat');
        $mform->addHelpButton('availabletools', 'availabletools', 'mod_collabsession');


    }
}
