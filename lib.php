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
 * library file
 * @package     block
 * @subpackage  hello_world
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function block_helloworld_images()
{
    return array(html_writer::tag('img', '', array('alt' => get_string('red', 'block_helloworld'), 'src' => "pix/picture0.gif")),
        html_writer::tag('img', '', array('alt' => get_string('blue', 'block_helloworld'), 'src' => "pix/picture1.gif")),
        html_writer::tag('img', '', array('alt' => get_string('green', 'block_helloworld'), 'src' => "pix/picture2.gif")));
}

function block_helloworld_print_page($helloworld, $context, $return = false)
{
//    todo :enhance rendering
    global $OUTPUT, $COURSE;
    $display = $OUTPUT->heading($helloworld->title);
    $display .= $OUTPUT->box_start();
    if ($helloworld->date) {
        $display .= html_writer::start_tag('div', array('class' => 'helloworld date'));
        $display .= userdate($helloworld->date);
        $display .= html_writer::end_tag('div');
    }
    $display .= clean_text($helloworld->text);
    if ($helloworld->filename) {
        $display .= $OUTPUT->box_start();
//        $images = block_helloworld_images();
//        $display .= $images[$helloworld->filename];
        $display .= $helloworld->filename;
        $display .= html_writer::start_tag('p');
        $display .= clean_text($helloworld->text);
        $display .= html_writer::end_tag('p');
        $display .= $OUTPUT->box_end();
    }
    $fs = get_file_storage();
    if ($files = $fs->get_area_files($context->id, 'block_helloworld', 'attachment', '0', 'sortorder', false)) {
        // Look through each file being managed
        foreach ($files as $file) {
            // Build the File URL. Long process! But extremely accurate.
            $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
            // Display the image
            $download_url = $fileurl->get_port() ? $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path() . ':' . $fileurl->get_port() : $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path();
            echo '<a href="' . $download_url . '">' . $file->get_filename() . '</a><br/>';
        }
    } else {
        echo '<p>Please upload an image first</p>';
    }


    //close the box
    $display .= $OUTPUT->box_end();
    if ($return) {
        return $display;
    } else {
        echo $display;
    }

}

/**
 * This function is called when a file url from FS API is served to user
 * @see https://docs.moodle.org/dev/File_API#Serving_files_to_users
 * @param $course
 * @param $cm
 * @param $context
 * @param $filearea
 * @param $args
 * @param $forcedownload
 * @param array $options
 * @return bool
 */
function block_helloworld_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_MODULE) {
//        return false;
    }
    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'attachment') {
        return false;
    }
    require_login($course, true, $cm);

    if (!has_capability('block/helloworld:viewpages', $context)) {
        return false;
    }
    // Leave this line out if you set the itemid to null in make_pluginfile_url (set $itemid to 0 instead).
    $itemid = array_shift($args); // The first item in the $args array.

    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.

    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/' . implode('/', $args) . '/'; // $args contains elements of the filepath
    }

    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'block_helloworld', $filearea, $itemid, $filepath, $filename);
    if (!$file) {
        return false; // The file does not exist.
    }
    send_stored_file($file, 0, 0, true, $options); // download MUST be forced - security!
}