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
        if ($this->content !== NULL) {
            return $this->content->text;
        }
        //here I choose to not filter on block blockid' => $this->instance->id, to display all informations to users
        $helloworldpages = $DB->get_records('block_helloworld');
        $this->content = new stdClass();
        $this->content->text = '';
        if (count($helloworldpages)) {
            foreach ($helloworldpages as $helloworldpage) {
                $this->content->text .= html_writer::start_tag('h2') . $helloworldpage->title . html_writer::end_tag('h2');
                $this->content->text .= html_writer::start_tag('p') . $helloworldpage->text . html_writer::end_tag('p');
                $context = context_course::instance($COURSE->id);
                $fs = get_file_storage();
//                var_dump($context); die ;
                if ($files = $fs->get_area_files($context->id, 'block_helloworld', 'attachment', $helloworldpage->attachment, 'sortorder', false)) {
                    foreach ($files as $file) {
                        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $file->get_filename());
                        $download_url = $fileurl->get_port() ? $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path() . ':' . $fileurl->get_port() : $fileurl->get_scheme() . '://' . $fileurl->get_host() . $fileurl->get_path();
                        $this->content->text .= '<a href="' . $download_url . '">' . $file->get_filename() . '</a><br/>';
                    }
                }
                $this->content->text .= $helloworldpage->date ? '<p><i>'. userdate($helloworldpage->date) .'</p></i>' : null;

                if (has_capability('block/helloworld:managepages', $context)) {
                    $pageparam = array('blockid' => $this->instance->id,
                        'courseid' => $COURSE->id,
                        'id' => $helloworldpage->id);
                    $editurl = new moodle_url('/blocks/helloworld/edit.php', $pageparam);
                    $editpicurl = new moodle_url('/pix/t/edit.png');
                    $edit = html_writer::link($editurl, html_writer::tag('img', '', array('src' => $editpicurl, 'alt' => get_string('edit'))));
                    //delete
                    $deleteparam = array('id' => $helloworldpage->id, 'courseid' => $COURSE->id);
                    $deleteurl = new moodle_url('/blocks/helloworld/delete.php', $deleteparam);
                    $deletepicurl = new moodle_url('/pix/t/delete.png');
                    $delete = html_writer::link($deleteurl, html_writer::tag('img', '', array('src' => $deletepicurl, 'alt' => get_string('delete'))));
                    $this->content->text .= $edit;
                    $this->content->text .= $delete;
                }
            }
        } else {
            $this->content->text .= html_writer::start_tag('p') . 'nothing to display yet' . html_writer::end_tag('p');
        }
        if (has_capability('block/helloworld:managepages', $context)) {
            $url = new moodle_url('/blocks/helloworld/edit.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
            $add = new moodle_url('/pix/t/add.png');
            $this->content->text .= '<br/><br/>' . html_writer::link($url, html_writer::tag('img', '', array('src' => $add, 'alt' => get_string('add'))));
        }

        return $this->content->text;
    }

    public function specialization()
    {
        //let's set up the block title
        $this->title = get_config('helloworld', 'title') ? get_config('helloworld', 'title') : get_string('defaultblocktitle', 'block_helloworld');
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
        return false;
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
