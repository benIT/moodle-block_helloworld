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
 * configuration form of hello world block
 * @package     block
 * @subpackage  helloworld
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_helloworld_edit_form extends block_edit_form
{

    protected function specific_definition($mform)
    {

        // Section header title according to language file.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // A sample string variable with a default value.
        $mform->addElement('text', 'config_text', get_string('helloworld:contentinputlabel', 'block_helloworld'));
        $mform->setDefault('config_text', get_string('helloworld:typeatext', 'block_helloworld'));
        $mform->setType('config_text', PARAM_RAW);

        $mform->addElement('text', 'config_title', get_string('helloworld:titleinputlabel', 'block_helloworld'));
        $mform->setDefault('config_title', get_string('helloworld:typeatext', 'block_helloworld'));
        $mform->setType('config_title', PARAM_TEXT);

    }
}