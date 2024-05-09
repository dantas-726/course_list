
<?php 

require_once(__DIR__ . '/../../config.php');
require_login();

global $DB, $USER;

$selected_status   = optional_param('selected_status', null, PARAM_INT); 

if ($selected_status ==-1) { 
  $sql = "SELECT id, fullname, idnumber FROM {course} WHERE id !=?";

} else { 
    $sql = "SELECT id, fullname, idnumber FROM {course} WHERE id !=1 AND VISIBLE = $selected_status";

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