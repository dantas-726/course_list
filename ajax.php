<?php

/**
 * This file keeps track of upgrades to the listallcourses block
 *
 * @since 3.8
 * @package block_listallcourses
 * @copyright 2024 Pedro <pedro@pedro.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_login();

global $DB, $USER;

$selectedstatus = optional_param('selectedstatus', null, PARAM_INT);

if ($selectedstatus == -1) {
    $sql = "SELECT id, fullname, idnumber FROM {course} WHERE id != -1";
} else {
    $sql = "SELECT id, fullname, idnumber FROM {course} WHERE id != 1 AND visible = $selectedstatus";
}

$records = $DB->get_records_sql($sql);

$table = "<table> <tbody>";
$table .= "<tr class='header'>
<th>" . get_string('srn', 'block_listallcourses') . "</th>
<th>" . get_string('course_name', 'block_listallcourses') . "</th>
<th>" . get_string('course_id', 'block_listallcourses') . "</th>
</tr>";

$counter = 1;
foreach ($records as $course) {
    $table .= "<tr>
    <td>" . $counter++ . "</td>
    <td>" . $course->fullname . "</td>
    <td>" . $course->idnumber . "</td>
    </tr>";
}

$table .= "</tbody></table>";
echo $table;


