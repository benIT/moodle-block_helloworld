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
 * global settings for admin of hello world block plugin
 * @package     block
 * @subpackage  helloworld
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('helloworld:headerconfig', 'block_helloworld'),
    get_string('helloworld:descconfig', 'block_helloworld')
));

$settings->add(new admin_setting_configcheckbox(
    'helloworld/Colored_Text',
    get_string('helloworld:labelcoloredtext', 'block_helloworld'),
    get_string('helloworld:desccoloredtext', 'block_helloworld'),
    '0'
));