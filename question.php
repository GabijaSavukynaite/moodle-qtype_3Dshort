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
 * model3dshort question definition class.
 *
 * @package    qtype
 * @subpackage model3dshort
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/** 
 *This holds the definition of a particular question of this type. 
 *If you load three questions from the question bank, then you will get three instances of 
 *that class. This class is not just the question definition, it can also track the current
 *state of a question as a student attempts it through a question_attempt instance. 
 */


/**
 * Represents a model3dshort question.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3dshort_question extends question_graded_automatically_with_countback
{
    public $answer1;
    /* it may make more sense to think of this as get expected data types */

    public function part_get_expected_data()
    {
        $expected = array();
        $i = 0;
        // foreach ($this->answers as $answer) {
        //     $expected["${i}_answer"] = PARAM_RAW;
        //     $i++;
        // }
        // foreach ($this->answers as $answer) {
        $expected["0_answer"] = PARAM_RAW;
        $expected["1_answer"] = PARAM_RAW;
        $expected["2_answer"] = PARAM_RAW;

        return $expected;
    }

    // public function get_expected_data()
    // {
    //     return array('answer1' => PARAM_RAW);
    // }


    public function part_summarise_response(array $response)
    {
        $summary = array();
        foreach ($this->part_get_expected_data() as $name => $type) {
            if (array_key_exists($name, $response)) {
                $summary[] = $response[$name];
            } else {
                $summary[] = '';
            }
        }
        $summary = implode(', ', $summary);
        return $summary;
    }

    // --------------------------------------

    public function get_expected_data()
    {
        return $this->part_get_expected_data();
    }

    public function start_attempt(question_attempt_step $step, $variant)
    {
        //TODO
        /* there are 9 occurrances of this method defined in files called question.php a new install of Moodle
        so you are probably going to have to define it */
    }

    /**
     * @return summary a string that summarises how the user responded. This 
     * is used in the quiz responses report
     * */

    public function summarise_response(array $response)
    {
        $summary = $this->part_summarise_response($response);
        $summary = implode(', ', $summary);
        return $summary;
    }

    public function is_complete_response(array $response)
    {
        // TODO.
        /* You might want to check that the user has done something
            before returning true, e.g. clicked a radio button or entered some 
            text 
            */
        return true;
    }

    public function get_validation_error(array $response)
    {
        // TODO.
        return '';
    }

    /** 
     * if you are moving from viewing one question to another this will
     * discard the processing if the answer has not changed. If you don't
     * use this method it will constantantly generate new question steps and
     * the question will be repeatedly set to incomplete. This is a comparison of
     * the equality of two arrays.
     * Comment from base class:
     * 
     * Use by many of the behaviours to determine whether the student's
     * response has changed. This is normally used to determine that a new set
     * of responses can safely be discarded.
     *
     * @param array $prevresponse the responses previously recorded for this question,
     *      as returned by {@link question_attempt_step::get_qt_data()}
     * @param array $newresponse the new responses, in the same format.
     * @return bool whether the two sets of responses are the same - that is
     *      whether the new set of responses can safely be discarded.
     */

    public function is_same_response(array $prevresponse, array $newresponse)
    {

        foreach ($this->get_expected_data() as $name => $notused) {
            if (!question_utils::arrays_same_at_key_missing_is_blank(
                $prevresponse,
                $newresponse,
                $name
            )) {
                return false;
            }
        }
        return true;

        // // TODO.
        // return question_utils::arrays_same_at_key_missing_is_blank(
        //     $prevresponse,
        //     $newresponse,
        //     'answer1'
        // );
    }

    /**
     * @return question_answer an answer that
     * contains the a response that would get full marks.
     * used in preview mode. If this doesn't return a 
     * correct value the button labeled "Fill in correct response"
     * in the preview form will not work. This value gets written
     * into the rightanswer field of the question_attempts table
     * when a quiz containing this question starts.
     */
    public function get_correct_response()
    {
        // return array('answer' => $this->correctanswer);
        // $responses = array();

        // $i = 0;
        // foreach ($this->answers as $answer) {
        //     $expected["${i}_answer"] = PARAM_RAW;
        //     $i++;
        // }

        // $response = parent::get_correct_response();
        if ($response) {
            $response['answer'] = $this->clean_response($response['answer']);
        }
        return $response;
    }
    /**
     * Given a response, reset the parts that are wrong. Relevent in
     * interactive with multiple tries
     * @param array $response a response
     * @return array a cleaned up response with the wrong bits reset.
     */
    public function clear_wrong_from_response(array $response)
    {
        foreach ($response as $key => $value) {
            /*clear the wrong response/s*/
        }
        return $response;
    }

    public function check_file_access(
        $qa,
        $options,
        $component,
        $filearea,
        $args,
        $forcedownload
    ) {

        if ($component == 'qtype_model3dshort' && $filearea == 'model') {
            $question = $qa->get_question(false);
            $itemid = reset($args);
            return $itemid == $question->id;
        } else {
            return parent::check_file_access(
                $qa,
                $options,
                $component,
                $filearea,
                $args,
                $forcedownload
            );
        }
    }

    public function calculate_grade($response, $answers)
    {
        $i = 0;
        $fraction = 1;

        foreach ($answers as $answer) {
            $fieldname = "${i}_answer";

            if ($response[$fieldname] != $answer) {
                $fraction = 0;
                break;
            }
            $i++;
        }

        return $fraction;
    }

    /**
     * @param array $response responses, as returned by
     *      {@link question_attempt_step::get_qt_data()}.
     * @return array (number, integer) the fraction, and the state.
     */
    public function grade_response(array $response)
    {
        $fraction = $this->calculate_grade($response, $this->answers);

        return array($fraction, question_state::graded_state_for_fraction($fraction));
    }

    /**
     * Work out a final grade for this attempt, taking into account all the
     * tries the student made. Used in interactive behaviour once all
     * hints have been used.     * 
     * @param array $responses an array of arrays of the response for each try. 
     * Each element of this array is a response array, as would be 
     * passed to {@link grade_response()}. There may be between 1 and 
     * $totaltries responses. 
     * @param int $totaltries is the maximum number of tries allowed. Generally 
     * not used in the implementation.
     * @return numeric the fraction that should be awarded for this
     * sequence of response. 
     * 
     */
    public function compute_final_grade($responses, $totaltries)
    {
        /*This method is typically where penalty is used. 
        When questions are run using the 'Interactive with multiple 
        tries or 'Adaptive mode' behaviour, so that the student will 
        have several tries to get the question right, then this option 
        controls how much they are penalised for each incorrect try.
        The penalty is a proportion of the total question grade, so if 
        the question is worth three marks, and the penalty is 0.3333333, 
        then the student will score 3 if they get the question right first 
        time, 2 if they get it right second try, and 1 of they get it right 
        on the third try.*/
        //TODO
        return 0;
    }
}