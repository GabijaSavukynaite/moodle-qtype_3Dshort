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
 * Defines the editing form for the model3d question type.
 *
 * @package    qtype
 * @subpackage model3d
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * model3d question editing form definition.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3d_edit_form extends question_edit_form {

    protected function definition_inner($mform) {
        //Add fields specific to this question type
        //remove any that come with the parent class you don't want
        
        // To add combined feedback (correct, partial and incorrect).
        $this->add_combined_feedback_fields(true);

        // Adds hinting features.
        // $this->add_interactive_settings(true, true);

        // Model
        // $filemanager_options['maxbytes'] = 0;
        // $filemanager_options['maxfiles'] = -1;
        $mform->addElement('header', 'modeloptions', get_string('modelheading', 'qtype_model3d'));
        $mform->addElement('filemanager', 'model', get_string('modelfiles', 'qtype_model3d'), null, array('accepted_types' => array('.html', ".js", ".css")));
        $mform->addHelpButton('model', 'modelfiles', 'qtype_model3d');
        $mform->addRule('model', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'canvasid', get_string('canvasid', 'qtype_model3d'), 'maxlength="20"');
        $mform->setType('canvasid', PARAM_TEXT);

        $mform->addElement('text', 'modelwidth', get_string('modelwidth', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setType('modelwidth', PARAM_INT);

        $mform->addElement('text', 'modelheight', get_string('modelheight', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setType('modelheight', PARAM_INT);

        // Answers
        $mform->addElement('header', 'answersheader', get_string('anwersheading', 'qtype_model3d'));
        // $mform->addElement('textarea', 'answer', get_string("answer", "qtype_model3d"),'wrap="virtual" rows="10" cols="70"');
        $mform->addElement('text', 'answer', get_string('answer', 'qtype_formulas'),
            array('size' => 80));
    }

    public function set_data($question) {
        global $DB;
        $model = $DB->get_record('qtype_model3d_model', array('questionid' => $question->id));

        if ($model->id) {
            $question->canvasid = $model->canvasid;
            $question->modelwidth = $model->width;
            $question->modelheight = $model->height;
        } 

        parent::set_data($question);
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        // $question = $this->data_preprocessing_hints($question);

        $options = $this->fileoptions;
        $options['subdirs'] = true;

        file_prepare_draft_area($draftid, $this->context->id,
                'qtype_model3d', 'model',
                empty($question->id) ? null : (int) $question->id,
                $options);
        $question->model = $draftid; 

        return $question;
    }

    public function qtype() {
        return 'model3d';
    }
}
