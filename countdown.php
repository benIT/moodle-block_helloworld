<?php
// Standard GPL and phpdocs
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
//admin_externalpage_setup('tooldemo');
// Set up the page.
$title = get_string('pluginname', 'block_helloworld');
$pagetitle = $title;
$url = new moodle_url("/blocks/helloworld/countdown.php");
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading("Welcome to a page using a template");
$output = $PAGE->get_renderer('block_helloworld');
echo $output->header();
echo $output->heading();
$renderable = new countdown_page('Hello guys !');
echo $output->render($renderable);
echo $output->footer();