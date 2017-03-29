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
 * webservice definition
 * @package     block
 * @subpackage  helloworld
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/externallib.php");


class block_helloworld_external extends external_api
{

    /**
     * Returns description of method parameters
     *
     * @return external_function_parameters
     * @since Moodle 3.0
     */
    public static function greetings_parameters()
    {
        return new external_function_parameters(
            array(
                'useremail' => new external_value(PARAM_TEXT, 'user email')
            )
        );
    }

    /**
     * Print a greetings statment for the user identified by email.
     * @param $useremail
     * @return array
     * @throws Exception
     */
    public static function greetings($useremail)
    {
        global $DB;
        $context = context_system::instance();
        self::validate_context($context);
        require_capability('block/helloworld:viewpages', $context);

        $user = $DB->get_record('user', array('email' => $useremail));
        if ($user) {
            $greeting_message = sprintf('Welcome %s %s! You join the plateform on %s!', $user->firstname, $user->lastname, date('d-m-Y', $user->timecreated));
            return ["greetings" => $greeting_message];
        } else {
            throw new \Exception(sprintf('user with email `%s` not found', $useremail));
        }
    }

    /**
     * Returns description of method result value
     *
     * @return external_description
     * @since Moodle 3.0
     */
    public static function greetings_returns()
    {
        return new external_single_structure(
            array(
                'greetings' => new external_value(PARAM_RAW, 'greetings result'),
            )
        );
    }

}
