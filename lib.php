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

function block_helloworld_print_page($helloworld, $return = false)
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
        $display .= clean_text($helloworld->description);
        $display .= html_writer::end_tag('p');
        $display .= $OUTPUT->box_end();
    }

    //close the box
    $display .= $OUTPUT->box_end();
    if ($return) {
        return $display;
    } else {
        echo $display;
    }

}