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
require_once('../../config.php');
require_once('helloworld_form.php');


global $DB, $OUTPUT, $PAGE;
// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);

//breadcrumb
$blockid = required_param('blockid', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$viewpage = optional_param('viewpage', false, PARAM_BOOL);


$settingsnode = $PAGE->settingsnav->add(get_string('helloworldsettings', 'block_helloworld'));
$editurl = new moodle_url('/blocks/helloworld/view.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));
$editnode = $settingsnode->add(get_string('editpage', 'block_helloworld'), $editurl);
$editnode->make_active();

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_helloworld', $courseid);
}
require_login($course);
$PAGE->set_url('/blocks/helloworld/view.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('edithtml', 'block_helloworld'));

$helloworld = new helloworld_form();
$toform['blockid'] = $blockid;
$toform['courseid'] = $courseid;
$toform['id'] = $id;

$helloworld->set_data($toform);
if ($helloworld->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url('/course/view.php', array('id' => $id));
    redirect($courseurl);
} else if ($fromform = $helloworld->get_data()) {
    // We need to add code to appropriately act on and store the submitted data
    if ($fromform->id != 0) {
        if (!$DB->update_record('block_helloworld', $fromform)) {
            print_error('updateerror', 'block_helloworld');
        }
    } else {
        if (!$DB->insert_record('block_helloworld', $fromform)) {
            print_error('inserterror', 'block_helloworld');
        }
    }
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else {
    // form didn't validate or this is the first display
    $site = get_site();
    echo $OUTPUT->header();
    if ($id) {
        $helloworldpage = $DB->get_record('block_helloworld', array('id' => $id));
        if ($viewpage) { //read only mode
            block_helloworld_print_page($helloworldpage);
        } else {
            $helloworld->set_data($helloworldpage);
            $helloworld->display();
        }
    } else {
        $helloworld->display();
    }
    echo $OUTPUT->footer();


}