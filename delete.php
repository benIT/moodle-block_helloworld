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
 * delete instance page
 * @package     block
 * @subpackage  hello_world
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
global $PAGE;
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$courseid = required_param('courseid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$confirm = optional_param('confirm', 0, PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_helloworld', $courseid);
}

require_login($course);
require_capability('block/helloworld:managepages', context_course::instance($courseid));
if (!$helloworldpage = $DB->get_record('block_helloworld', array('id' => $id))) {
    print_error('nopage', 'block_helloworld', '', $id);
}
$site = get_site();
$PAGE->set_url('/blocks/helloworld/delete.php', array('id' => $id, 'courseid' => $courseid));
$PAGE->set_heading($site->fullname . ' :: ' . $course->shortname . ' :: ' . $helloworldpage->title);
echo $OUTPUT->header();
if (!$confirm) {
    $optionsno = new moodle_url('/course/view.php', array('id' => $courseid));
    $optionsyes = new moodle_url('/blocks/helloworld/delete.php', array('id' => $id, 'courseid' => $courseid, 'confirm' => 1, 'sesskey' => sesskey()));
    echo $OUTPUT->confirm(get_string('deleteitem', 'block_helloworld', $helloworldpage->title, true), $optionsyes, $optionsno);
} else {
    if (confirm_sesskey()) {
        $helloworldpage = $DB->get_record('block_helloworld', array('id' => $id));
        $fs = get_file_storage();
        $fileinfo = array(
            'component' => 'block_helloworld',
            'filearea' => 'attachment',     // usually = table name
            'itemid' => $helloworldpage->attachment,               // usually = ID of row in table
            'contextid' => $context->id, // ID of context
            'filepath' => '/',           // any path beginning and ending in /
            'filename' => ''); // any filename

        // Get file
        $file = $fs->get_file($fileinfo['contextid'], $fileinfo['component'], $fileinfo['filearea'], $fileinfo['itemid'], $fileinfo['filepath'], $fileinfo['filename']);
        if ($file) {
            $file->delete();
        }
        if (!$DB->delete_records('block_helloworld', array('id' => $id))) {
            print_error('deleteerror', 'block_helloworld');
        }
    } else {
        print_error('sessionerror', 'block_helloworld');
    }
    $url = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($url);
}
echo $OUTPUT->footer();

