<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Block listallcourses is defined here.
 *
 * @package     block_listallcourses
 * @copyright   2024 Your Name <you@example.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_listallcourses extends block_base
{

    /**
     * Initializes class member variables.
     */
    public function init()
    {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_listallcourses');

    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content()
    {

        global $DB, $USER, $CFG, $PAGE;

        $PAGE->requires->js('/blocks/listallcourses/js/jquery-3.6.3.min.js');
        $PAGE->requires->js('/blocks/listallcourses/js/main.js');
        $PAGE->requires->css('/blocks/listallcourses/css/styles.css');


        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = array();
        $this->content->icons = array();
        $this->content->footer = '';

        if (!empty($this->config->text)) {
            $this->content->text = "Hello Pedro";
        } else {
            // $text = "<h6>". get_string('pluginname_display', 'block_listallcourses') ."</h6>";

            $sql = "SELECT * FROM {course} WHERE id !=?";
            $result = $DB->get_records_sql($sql, array(1));




            $table = "<table> <tbody>";
            $table .= "<tr class='header'> 
            <th>" . get_string('srn', 'block_listallcourses') . "</th>
            <th>" . get_string('course_name', 'block_listallcourses') . "</th>
            <th>" . get_string('course_id', 'block_listallcourses') . "</th>
            </tr>";

            $counter = 1;
            foreach ($result as $course) {
                $table .= "<tr> 
                <td>" . $counter++ . "</td>
                <td>" . $course->fullname . "</td>
                <td>" . $course->idnumber . "</td>
                </tr>";
            }

            $table .= "</tbody></table>";

            $filter1 = '
            <div class="filter" >
            <span class="header2" > Course Status: </span>
            <select name="status" id="status">
            <option value="-1">All</option>
            <option value="1">Active</option>
            <option value="0">Deactive</option>
            </select>
            </div>';




            $text  = $filter1;
            $text .= "<div class='resultset'>";
            $text .= $table;
            $text .= "</div>";
            $this->content->text = $text;
        }

        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediately after init().
     */
    public function specialization()
    {

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_listallcourses');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Enables global configuration of the block in settings.php.
     *
     * @return bool True if the global configuration is enabled.
     */
    public function has_config()
    {
        return true;
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats()
    {
        return array(
            'all' => true
        );
    }

    function instance_allow_multiple() {
        return true;
}

    function _self_test()
    {
        return true;
    }
}

// how to send email in pph? 

// generate select option filter in html?
