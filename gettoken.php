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
 * countdownpage
 * @package     block
 * @subpackage  hello_world
 * @copyright   2017 benIT
 * @author      benIT <benoit.works@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

// Set up the page.
$context = context_system::instance();
$PAGE->set_context( $context );
$title = get_string('pluginname', 'block_helloworld');
$PAGE->requires->js('/blocks/helloworld/js/jquery-3.2.0.min.js', true); //loaded in begining
$PAGE->requires->js('/blocks/helloworld/js/gettoken.js', false); //loaded at the end
$PAGE->set_pagelayout("standard");
$pagetitle = $title;
$url = new moodle_url("/blocks/helloworld/countdown.php");
$PAGE->set_url($url);
$PAGE->set_title($title);

$output = $PAGE->get_renderer('block_helloworld');
echo $output->header();
echo $output->heading("");
$data = new stdClass();
$data->heading = 'Webservice - Get token page';
$data->descriptive = 'Use this form to get a webservice token.';
$renderable = new gettoken_page($data);
echo $output->render($renderable);
echo $output->footer();