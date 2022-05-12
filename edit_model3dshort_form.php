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
 * Defines the editing form for the model3dshort question type.
 *
 * @package    qtype
 * @subpackage model3dshort
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once('locallib.php');


/**
 * model3dshort question editing form definition.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3dshortshort_edit_form extends question_edit_form
{

    protected function definition_inner($mform)
    {
        $this->add_combined_feedback_fields(true);

        $mform->addElement('header', 'modeloptions', get_string('modelheading', 'qtype_model3dshortshort'));
        $mform->addElement('filemanager', 'model', get_string('modelfiles', 'qtype_model3dshortshort'), null, $this->getFilemanagerOptions());
        $mform->addHelpButton('model', 'modelfiles', 'qtype_model3dshortshort');
        $mform->addRule('model', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'canvasid', get_string('canvasid', 'qtype_model3dshortshort'), 'maxlength="20"');
        $mform->setType('canvasid', PARAM_TEXT);

        $mform->addElement('text', 'modelwidth', get_string('modelwidth', 'qtype_model3dshortshort'), 'maxlength="5" size="5"');
        $mform->setType('modelwidth', PARAM_INT);

        $mform->addElement('text', 'modelheight', get_string('modelheight', 'qtype_model3dshortshort'), 'maxlength="5" size="5"');
        $mform->setType('modelheight', PARAM_INT);

        // Answers
        $mform->addElement('header', 'answersheader', get_string('anwersheading', 'qtype_model3dshortshort'));
        // $mform->addElement('textarea', 'answer', get_string("answer", "qtype_model3dshortshort"),'wrap="virtual" rows="10" cols="70"');
        $mform->addElement(
            'text',
            'answer',
            get_string('answer', 'qtype_model3dshortshort'),
            array('size' => 80)
        );
    }

    public function set_data($question)
    {
        global $DB;
        $model = $DB->get_record('qtype_model3dshortshort_model', array('questionid' => $question->id));

        if ($model->id) {
            $question->canvasid = $model->canvasid;
            $question->modelwidth = $model->width;
            $question->modelheight = $model->height;
        }

        parent::set_data($question);
    }

    protected function data_preprocessing($question)
    {
        $question = parent::data_preprocessing($question);
        // $question = $this->data_preprocessing_hints($question);

        // $options = $this->fileoptions;
        // $options['subdirs'] = true;

        // $filemanager_options = array();
        // $filemanager_options['accepted_types'] = '*';
        // $filemanager_options['maxbytes'] = 0;
        // $filemanager_options['maxfiles'] = -1;
        // $filemanager_options['mainfile'] = true;

        qtype_model3dshortshort_check_for_zips($this->context->id,  empty($question->id) ? null : (int) $question->id);


        // file_prepare_draft_area(
        //     $draftid,
        //     $this->context->id,
        //     'qtype_model3dshortshort',
        //     'model',
        //     empty($question->id) ? null : (int) $question->id,
        //     $this->getFilemanagerOptions()
        // );
        // $question->model = $draftid;

        return $question;
    }

    protected function getFilemanagerOptions()
    {
        $filemanager_options = array();
        $filemanager_options['accepted_types'] = '*';
        // $filemanager_options['maxbytes'] = 0;
        // $filemanager_options['maxfiles'] = -1;
        $filemanager_options['mainfile'] = true;

        return $filemanager_options;
    }

    public function qtype()
    {
        return 'model3dshort';
    }
}
