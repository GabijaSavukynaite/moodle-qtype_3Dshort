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
        $filemanager_options = array();
        $filemanager_options['accepted_types'] = array('.html', ".js");
        // $filemanager_options['maxbytes'] = 0;
        // $filemanager_options['maxfiles'] = -1;

        $mform->addElement('header', 'modeloptions', get_string('modelheading', 'qtype_model3d'));
        $mform->addElement('filemanager', 'model', get_string('modelfiles', 'qtype_model3d'), null, $filemanager_options);
        $mform->addHelpButton('model', 'modelfiles', 'qtype_model3d');

        // Stage
        $mform->addElement('header', 'stageoptions', get_string('stageheading', 'qtype_model3d'));

        $mform->addElement('text', 'stagewidth', get_string('stagewidth', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('stagewidth', 400);
        $mform->setType('stagewidth', PARAM_INT);
        
        $mform->addElement('text', 'stageheight', get_string('stageheight', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('stageheight', 400);
        $mform->setType('stageheight', PARAM_INT);
        
        // Camera
        $mform->addElement('header', 'cameraoptions', get_string('cameraheading', 'qtype_model3d'));
        
        $mform->addElement('text', 'cameraangle', get_string('cameraangle', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('cameraangle', 45);
        $mform->setType('cameraangle', PARAM_INT);
        
        $mform->addElement('text', 'camerafar', get_string('camerafar', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('camerafar', 1000);
        $mform->setType('camerafar', PARAM_INT);
        
        $mform->addElement('text', 'camerax', get_string('camerax', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('camerax', 0);
        $mform->setType('camerax', PARAM_INT);
        
        $mform->addElement('text', 'cameray', get_string('cameray', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('cameray', 1);
        $mform->setType('cameray', PARAM_INT);
        
        $mform->addElement('text', 'cameraz', get_string('cameraz', 'qtype_model3d'), 'maxlength="5" size="5"');
        $mform->setDefault('cameraz', 200);
        $mform->setType('cameraz', PARAM_INT);
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $question = $this->data_preprocessing_hints($question);

        $options = $this->fileoptions;
        $options['subdirs'] = false;

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
