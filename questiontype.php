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
 * Question type class for the model3dshort question type.
 *
 * @package    qtype
 * @subpackage model3dshort
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/*https://docs.moodle.org/dev/Question_types#Question_type_and_question_definition_classes*/


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/model3dshort/question.php');


/**
 * The model3dshort question type.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3dshort extends question_type
{
    public function move_files($questionid, $oldcontextid, $newcontextid)
    {
        $fs = get_file_storage();

        parent::move_files($questionid, $oldcontextid, $newcontextid);
        $fs->move_area_files_to_new_context(
            $oldcontextid,
            $newcontextid,
            'qtype_model3dshort',
            'model',
            $questionid
        );

        $this->move_files_in_combined_feedback($questionid, $oldcontextid, $newcontextid);
        $this->move_files_in_hints($questionid, $oldcontextid, $newcontextid);
    }

    protected function delete_files($questionid, $contextid)
    {
        parent::delete_files($questionid, $contextid);
        $this->delete_files_in_hints($questionid, $contextid);
    }
    /**
     * @param stdClass $question
     * @param array $form
     * @return object
     */
    public function save_question($question, $form)
    {
        return parent::save_question($question, $form);
    }

    public function save_question_options($question)
    {
        global $DB;

        $fs = get_file_storage();
        foreach ($oldanswers as $oldanswer) {
            $fs->delete_area_files($context->id, 'question', 'answerfeedback', $oldanswer->id);
            $DB->delete_records('question_answers', array('id' => $oldanswer->id));
        }


        $oldoptions = $DB->get_record('qtype_model3dshort', array('questionid' => $question->id));

        $options = new stdClass();

        $options->questionid = $question->id;
        $options->correctfeedback = '';
        $options->partiallycorrectfeedback = '';
        $options->incorrectfeedback = '';
        $options->answer = $question->answer;

        if (isset($oldoptions->id)) {
            $options->id = $oldoptions->id;
            $DB->update_record('qtype_model3dshort', $options);
        } else {
            $DB->insert_record('qtype_model3dshort', $options);
        }


        // foreach (array_keys($formdata->drops) as $dropno) {
        //     $drop = new stdClass();
        //     $drop->questionid = $formdata->id;
        //     $drop->no = $dropno + 1;
        //     $drop->xleft = $formdata->drops[$dropno]['xleft'];
        //     $drop->ytop = $formdata->drops[$dropno]['ytop'];
        //     $drop->choice = $formdata->drops[$dropno]['choice'];
        //     $drop->label = $formdata->drops[$dropno]['droplabel'];

        //     $DB->insert_record('qtype_ddimageortext_drops', $drop);
        // }


        // $options->id = $DB->insert_record('qtype_model3dshort', $options);
        // $DB->update_record('qtype_model3dshort', $options);
        // $oldmodel = $DB->get_record('qtype_model3dshort_model', array('questionid' => $question->id));

        // $model = new stdClass();
        // if (!$oldmodel->id) {
        //     $model->id = $oldmodel->id;
        // } 

        // $model->questionid = $question->id;
        // $model->canvasid = $question->canvasid;
        // $model->width = $question->modelwidth;
        // $model->height = $question->modelheight;

        // if (isset($oldmodel->id)) {
        //     $model->id = $oldmodel->id;
        //     $DB->update_record('qtype_model3dshort_model', $model);
        // } else {
        //     $DB->insert_record('qtype_model3dshort_model', $model);
        // }

        file_save_draft_area_files(
            $question->model,
            $question->context->id,
            'qtype_model3dshort',
            'model',
            $question->id,
            array('subdirs' => true),
        );
    }

    /* 
 * populates fields such as combined feedback 
 * also make $DB calls to get data from other tables
 */
    public function get_question_options($question)
    {
        global $DB;

        if (!$question->options = $DB->get_record(
            'qtype_model3dshort',
            array('questionid' => $question->id)
        )) {
            echo $OUTPUT->notification('Error: Missing question options!');
            return false;
        }

        // if (!$question->options->answers = $DB->get_records(
        //     'question_answers',
        //     array('question' =>  $question->id),
        //     'id ASC'
        // )) {
        //     echo $OUTPUT->notification('Error: Missing question answers for question ' .
        //         $question->id . '!');
        //     return false;
        // }
        parent::get_question_options($question);
    }

    // protected function create_default_options($question) {
    //     // Create a default question options record.
    //     $options = new stdClass();
    //     $options->questionid = $question->id;

    //     // Get the default strings and just set the format.
    //     $options->correctfeedback = get_string('correctfeedbackdefault', 'question');
    //     $options->correctfeedbackformat = FORMAT_HTML;
    //     $options->partiallycorrectfeedback = get_string('partiallycorrectfeedbackdefault', 'question');;
    //     $options->partiallycorrectfeedbackformat = FORMAT_HTML;
    //     $options->incorrectfeedback = get_string('incorrectfeedbackdefault', 'question');
    //     $options->incorrectfeedbackformat = FORMAT_HTML;
    //     $options->shownumcorrect = 1;

    //     return $options;
    // }


    /**
     * executed at runtime (e.g. in a quiz or preview 
     **/
    protected function initialise_question_instance(question_definition $question, $questiondata)
    {
        parent::initialise_question_instance($question, $questiondata);
        $question->correctanswer = true;
        $questiondata->options->correctfeedback = get_string('correctfeedbackdefault', 'question');
        $questiondata->options->correctfeedbackformat = FORMAT_HTML;
        $questiondata->options->partiallycorrectfeedback = get_string('partiallycorrectfeedbackdefault', 'question');;
        $questiondata->options->partiallycorrectfeedbackformat = FORMAT_HTML;
        $questiondata->options->incorrectfeedback = get_string('incorrectfeedbackdefault', 'question');
        $questiondata->options->incorrectfeedbackformat = FORMAT_HTML;
        $questiondata->options->shownumcorrect = 1;
        $question->answers = explode(";", $questiondata->options->answer);
        // print_object($questiondata);
        $this->initialise_combined_feedback($question, $questiondata, true);
    }

    public function import_from_xml($data, $question, qformat_xml $format, $extra = null)
    {
        if (!isset($data['@']['type']) || $data['@']['type'] != 'qtype_model3dshort') {
            return false;
        }
        $question = parent::import_from_xml($data, $question, $format, null);
        $format->import_combined_feedback($question, $data, true);
        $format->import_hints($question, $data, true, false, $format->get_format($question->questiontextformat));
        return $question;
    }
    public function export_to_xml($question, qformat_xml $format, $extra = null)
    {
        global $CFG;
        $pluginmanager = core_plugin_manager::instance();
        $gapfillinfo = $pluginmanager->get_plugin_info('qtype_model3dshort');
        $output = parent::export_to_xml($question, $format);
        //TODO
        $output .= $format->write_combined_feedback($question->options, $question->id, $question->contextid);
        return $output;
    }


    public function get_random_guess_score($questiondata)
    {
        // TODO.
        return 0;
    }

    public function get_possible_responses($questiondata)
    {
        // TODO.
        return array();
    }

    public function make_question($questiondata)
    {
        $question = $this->make_question_instance($questiondata);
        $this->initialise_question_instance($question, $questiondata);
        return $question;
    }

    public function delete_question($questionid, $contextid)
    {
        global $DB;
        $DB->delete_records('qtype_' . $this->name(), array('questionid' => $questionid));
        $DB->delete_records('qtype_' . $this->name() . '_model', array('questionid' => $questionid));
        return parent::delete_question($questionid, $contextid);
    }
}
