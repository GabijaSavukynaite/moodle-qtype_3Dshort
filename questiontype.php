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
 * Question type class for the model3d question type.
 *
 * @package    qtype
 * @subpackage model3d
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
 /*https://docs.moodle.org/dev/Question_types#Question_type_and_question_definition_classes*/


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/model3d/question.php');


/**
 * The model3d question type.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3d extends question_type {

      /* ties additional table fields to the database */
    // public function extra_question_fields() {
    //     return array('qtype_model3d', 'somefieldname','anotherfieldname');
    // }

    
    public function move_files($questionid, $oldcontextid, $newcontextid) {
        $fs = get_file_storage();

        parent::move_files($questionid, $oldcontextid, $newcontextid);
        $fs->move_area_files_to_new_context($oldcontextid,
                                    $newcontextid, 'qtype_model3d', 'model', $questionid);

        $this->move_files_in_combined_feedback($questionid, $oldcontextid, $newcontextid);
        $this->move_files_in_hints($questionid, $oldcontextid, $newcontextid);
    }

    protected function delete_files($questionid, $contextid) {
        parent::delete_files($questionid, $contextid);
        $this->delete_files_in_hints($questionid, $contextid);
    }
     /**
     * @param stdClass $question
     * @param array $form
     * @return object
     */
    public function save_question($question, $form) {
        return parent::save_question($question, $form);
    }

    public function save_question_options($question) {
        global $DB;
        $options = $DB->get_record('qtype_model3d', array('questionid' => $question->id));
        
        if (!$options) {
            $options = new stdClass();
            $options->questionid = $question->id;
            $options->correctfeedback = '';
            $options->partiallycorrectfeedback = '';
            $options->incorrectfeedback = '';
            $options->id = $DB->insert_record('qtype_model3d', $options);
        }
        $options = $this->save_combined_feedback_helper($options, $question, $question->context, true);

        // $entry = file_postupdate_standard_filemanager($question, 'model', $attachmentoptions, $context,
        //                                       'mod_glossary', 'model', $question->id);
        $DB->update_record('qtype_model3d', $options);
        $this->save_hints($question);



        file_save_draft_area_files($question->model, $question->context->id,
            'qtype_model3d', 'model', $question->id,
            array('subdirs' => 0, 'maxbytes' => 0));
            // array('subdirs' => 0, 'maxbytes' => 0, 'maxfiles' => 1));
    }

 /* 
 * populates fields such as combined feedback 
 * also make $DB calls to get data from other tables
 */
   public function get_question_options($question) {
     //TODO
       parent::get_question_options($question);
    }

 /**
 * executed at runtime (e.g. in a quiz or preview 
 **/
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);
        $this->initialise_question_answers($question, $questiondata);
        parent::initialise_combined_feedback($question, $questiondata);
    }
    
   public function initialise_question_answers(question_definition $question, $questiondata,$forceplaintextanswers = true){ 
     //TODO
    }
    
    public function import_from_xml($data, $question, qformat_xml $format, $extra = null) {
        if (!isset($data['@']['type']) || $data['@']['type'] != 'qtype_model3d') {
            return false;
        }
        $question = parent::import_from_xml($data, $question, $format, null);
        $format->import_combined_feedback($question, $data, true);
        $format->import_hints($question, $data, true, false, $format->get_format($question->questiontextformat));
        return $question;
    }
    public function export_to_xml($question, qformat_xml $format, $extra = null) {
        global $CFG;
        $pluginmanager = core_plugin_manager::instance();
        $gapfillinfo = $pluginmanager->get_plugin_info('qtype_model3d');
        $output = parent::export_to_xml($question, $format);
        //TODO
        $output .= $format->write_combined_feedback($question->options, $question->id, $question->contextid);
        return $output;
    }


    public function get_random_guess_score($questiondata) {
        // TODO.
        return 0;
    }

    public function get_possible_responses($questiondata) {
        // TODO.
        return array();
    }

       public function make_question($questiondata) {
        $question = $this->make_question_instance($questiondata);
        $this->initialise_question_instance($question, $questiondata);
        return $question;
    }
}
