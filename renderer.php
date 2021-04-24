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
 * model3d question renderer class.
 *
 * @package    qtype
 * @subpackage model3d
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot.'/mod/resource/lib.php');

/**
 * Generates the output for model3d questions.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3d_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {

        $question = $qa->get_question();
        $componentname = $question->qtype->plugin_name();

        // $model = file_prepare_standard_editor($model, 'description', $descriptionoptions, $context, 'mod_wavefront', 'description', $model->id);
        // $model = file_prepare_standard_filemanager($model, 'model', $modeloptions, $context, 'mod_wavefront', 'model', $model->id);
 
        $fs = get_file_storage();

        $files = $fs->get_area_files($question->contextid, $componentname, 'model', $question->id);

        $questiontext = $question->format_questiontext($qa);

        $result = html_writer::start_tag("div", array('class' => 'qtext'));
       
        // $result .= html_writer::tag('div', $questiontext, null);

        

        // $file = reset($files); 
 

            //  foreach ($files as $file) {
            //       print_object( $file);
            //  }

        // //---------------------------------------------------------------------------
        // if (count($files) < 1) {
        //     resource_print_filenotfound($resource, $cm, $course);
        //     die;
        // } else {
        //     $file = reset($files);
        //     unset($files);
        // }
        $code = html_writer::empty_tag("div", null);;



        foreach ($files as $file) {
            // $f is an instance of stored_file
            $pathname = $file->get_filepath();
            $filename = $file->get_filename();
                  $qubaid = $qa->get_usage_id();
        $slot = $qa->get_slot();
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            // what type of file is this?
            if($ext === "html") {
 
                $pathname = $file->get_filepath();

                // $url = moodle_url::make_pluginfile_url($question->contextid, $componentname,
                //                             'model', 0, $pathname,
                //                             $file->get_filename());
                
                $url = moodle_url::make_pluginfile_url($question->contextid, $componentname,
                                           'model', "$qubaid/$slot/$question->id", '/',
                                            $file->get_filename());

                

                $url->out();

                $attributes = [];
                $attributes['id'] = "contentframe";
                $attributes['src'] = $url;
                $attributes['width'] = "100%";
                $attributes['height'] = '350px';
                $attributes['scrolling'] = "no";

                $result .= html_writer::empty_tag('iframe', $attributes);

    //                      $code = <<<EOT
    // <div class="qtext">
    // <iframe id="resourceobject" src="$url">
       
    // </iframe>
    // </div>
    // EOT;
    
                                            
            } 
        }
    
        // $resource->mainfile = $file->get_filename();
        // $displaytype = resource_get_final_display_type($resource);
        // if ($displaytype == RESOURCELIB_DISPLAY_OPEN || $displaytype == RESOURCELIB_DISPLAY_DOWNLOAD) {
        //     $redirect = true;
        // }

        // //---------------------------------------------------------------------------

        // $file = moodle_url::make_pluginfile_url($question->contextid, $componentname,
        //                                     "model", "$qubaid/$slot/{$itemid}", '/',
        //                                     $file->get_filename());

        $result .= html_writer::end_tag("div");
        $this->page->requires->js_call_amd('qtype_model3d/model', 'init',
                array($questiontext));



        // $result .= html_writer::empty_tag('div', array('id' => 'modelContainer'));
        /* Some code to restore the state of the question as you move back and forth
        from one question to another in a quiz and some code to disable the input fields
        once a quesiton is submitted/marked */

        /* if ($qa->get_state() == question_state::$invalid) {
            $result .= html_writer::nonempty_tag('div',
                    $question->get_validation_error(array('answer' => $currentanswer)),
                    array('class' => 'validationerror'));
        }*/

 

    // the size is hardcoded in the boject obove intentionally because it is adjusted by the following function on-the-fly
    // $this->page->requires->js_init_call('M.util.init_maximised_embed', array('resourceobject'), true);
        return $result;
    }

    // public function specific_feedback(question_attempt $qa) {
    //     // TODO.
    //     return '';
    // }

    // public function correct_response(question_attempt $qa) {
    //     // TODO.
    //     return '';
    // }
}
