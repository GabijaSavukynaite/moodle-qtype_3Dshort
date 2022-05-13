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
 * model3dshort question type  capability definition
 *
 * @package    qtype_model3dshort
 * @copyright  20XX Author Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');
require_once($CFG->libdir . '/questionlib.php');
class qtype_model3dshort_external extends external_api
{
    /**
     * Describes the parameters for get_grade webservice.
     *
     * @return external_function_parameters
     */
    // public static function get_grade_parameters() {
    //     return new external_function_parameters([
    //             'grade' => new external_value(PARAM_INT, 'The question id'),
    //             'response' => new external_value(PARAM_TEXT, 'The response'),
    //     ]);
    // }

    // /**
    //  * Describes the return value for get_grade webservice.
    //  *
    //  * @return external_single_structure
    //  */

    public static function get_grade_parameters()
    {
        return new external_function_parameters(
            array(
                'edugameid' => new external_value(PARAM_INT, 'edugame instance ID'),
                'score' => new external_value(PARAM_INT, 'Player final score'),
            )
        );
    }
    /**
     * Check response for create pattern match test response.
     *
     * @param int $questionid The question id
     * @param int $response The response to check
     * @return array The status and message after checked the response.
     */
    public static function get_grade($edugameid, $score)
    {
        $result = [];
        $result['status'] = $edugameid;
        $result['message'] = $score;

        // $params = self::validate_parameters(self::get_grade_parameters(), [
        //         'questionid' => $questionid,
        //         'response' => $response]);
        // $duplicated = \qtype_pmatch\testquestion_responses::check_duplicate_response($params['questionid'], $params['response']);
        // if ($duplicated) {
        //     $result['status'] = 'error';
        //     $result['message'] = get_string('testquestionformduplicateresponse', 'qtype_pmatch');
        // }
        return "test";
    }

    public static function get_grade_returns()
    {
        return new external_value(PARAM_TEXT, 'The welcome message + user first name');
    }
}
