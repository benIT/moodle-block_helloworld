<?php
defined('MOODLE_INTERNAL') || die();

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
 * a basic hello world block plugin
 * @package     block
 * @subpackage  helloworld
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_helloworld extends block_base
{
    /**
     * block initializations
     */
    public function init()
    {
        $this->title = get_string('pluginname', 'block_helloworld');
    }

    /**
     * set up the block content.
     * This variable holds all the actual content that is displayed inside each block. Valid values for it are either NULL or an object of class stdClass, which must have specific member variables set as explained below. Normally, it begins life with a value of NULL and it becomes fully constructed (i.e., an object) when get_content() is called.
     * @link https://docs.moodle.org/dev/Blocks/Appendix_A#.24this-.3Econtent
     * @return stdObject
     */
    public function get_content()
    {
        global $COURSE, $DB, $PAGE;
        $context = context_course::instance($COURSE->id);
        // Check to see if we are in editing mode and that we can manage pages.
        $canmanage = has_capability('block/helloworld:managepages', $context) && $PAGE->user_is_editing($this->instance->id);
        $canview = has_capability('block/helloworld:viewpages', $context);
        if ($this->content !== NULL) {
            return $this->content;
        }
        $this->content = new stdClass;
        $helloworldpages = $DB->get_records('block_helloworld', array('blockid' => $this->instance->id));
        $helloworldpage = $helloworldpages[array_rand($helloworldpages)];

        $url = new moodle_url('/blocks/helloworld/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));

        $this->content->text .= html_writer::start_tag('h2');
        $this->content->text .= $helloworldpage->title;
        $this->content->text .= html_writer::end_tag('h2');

        $this->content->text .= html_writer::start_tag('p');
        $this->content->text .= $helloworldpage->text;
        $this->content->text .= $helloworldpage->filename;
        $this->content->text .= html_writer::end_tag('p');
        $this->content->text .= html_writer::start_tag('p');
        $this->content->text .= userdate($helloworldpage->date);
        $this->content->text .= html_writer::end_tag('p');


        $fs = get_file_storage();
//        $fs->get_file_by_id(27);
//        $fs->get_file_by_id(716737728);


        if (has_capability('block/helloworld:managepages', $context)) {
            $url = new moodle_url('/blocks/helloworld/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
            $add = new moodle_url('/pix/t/add.png');
            $this->content->footer = html_writer::link($url, html_writer::tag('img', '', array('src' => $add, 'alt' => get_string('add'))));
            $pageparam = array('blockid' => $this->instance->id,
                'courseid' => $COURSE->id,
                'id' => $helloworldpage->id);
            $editurl = new moodle_url('/blocks/helloworld/view.php', $pageparam);
            $editpicurl = new moodle_url('/pix/t/edit.png');
            $edit = html_writer::link($editurl, html_writer::tag('img', '', array('src' => $editpicurl, 'alt' => get_string('edit'))));

            //delete
            $deleteparam = array('id' => $helloworldpage->id, 'courseid' => $COURSE->id);
            $deleteurl = new moodle_url('/blocks/helloworld/delete.php', $deleteparam);
            $deletepicurl = new moodle_url('/pix/t/delete.png');
            $delete = html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => get_string('delete'))));
            $this->content->footer .= $edit;
            $this->content->footer .= $delete;
        } else {
            $this->content->footer = '';
        }

        return $this->content;
    }

    public function specialization()
    {
        if ($this->config) {
            //let's set up the block title
            $this->title = $this->config->title ? $this->config->title : get_string('helloworld:defaultblocktitle', 'block_helloworld');
        }
    }

    public function html_attributes()
    {
        $attributes = parent::html_attributes();
        if (get_config('helloworld', 'Colored_Text')) {
            $attributes['class'] .= ' colored-text';
        }
        return $attributes;
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }

    public function instance_delete()
    {
        global $DB;
        $DB->delete_records('block_helloworld', array('blockid' => $this->instance->id));
    }

}
