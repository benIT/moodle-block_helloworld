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
 * @subpackage  hello_world
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('hello_world:headerconfig', 'block_hello_world'),
    get_string('hello_world:descconfig', 'block_hello_world')
));

$settings->add(new admin_setting_configcheckbox(
    'hello_world/Colored_Text',
    get_string('hello_world:labelcoloredtext', 'block_hello_world'),
    get_string('hello_world:desccoloredtext', 'block_hello_world'),
    '0'
));