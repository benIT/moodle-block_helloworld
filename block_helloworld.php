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
        if ($this->content !== NULL) {
            return $this->content;
        }
        $this->content = new stdClass;
        $this->content->text = $this->config->text ? $this->config->text : '<h4>Hello world default text</h4>';
        $this->content->footer = '<p><i>hello world footer</i></p>';
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


}
