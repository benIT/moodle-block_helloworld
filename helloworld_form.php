<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * enter a description of the component
 * @package     block
 * @subpackage  hello_world
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once("{$CFG->libdir}/formslib.php");

class helloworld_form extends moodleform
{

    function definition()
    {
        $mform =& $this->_form;
        $mform->addElement('header', 'displayinfo', get_string('textfields', 'block_helloworld'));

        $mform->addElement('text', 'title', get_string('title', 'block_helloworld'));
        $mform->setType('title', PARAM_RAW);
        $mform->addRule('title', null, 'required', null, 'client');

        $mform->addElement('htmleditor', 'text', get_string('displayedhtml', 'block_helloworld'));
        $mform->setType('text', PARAM_RAW);
        $mform->addRule('text', null, 'required', null, 'client');
        $mform->addElement('filepicker', 'filename', get_string('file'), null, array('accepted_types' => '*'));

        $mform->addElement('header', 'optional', get_string('optional', 'form'), null, false);
        $mform->addElement('date_time_selector', 'displaydate', get_string('displaydate', 'block_helloworld'), array('optional' => true));
        $mform->setAdvanced('optional');
        $mform->addElement('hidden', 'blockid');
        $mform->addElement('hidden', 'courseid');
        $this->add_action_buttons();

    }
}