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

        global $DB;

        

        $question = $qa->get_question();
        $componentname = $question->qtype->plugin_name();
        $model = $DB->get_record('qtype_model3d_model', array('questionid' => $question->id));

        

        // $model = file_prepare_standard_editor($model, 'description', $descriptionoptions, $context, 'mod_wavefront', 'description', $model->id);
        // $model = file_prepare_standard_filemanager($model, 'model', $modeloptions, $context, 'mod_wavefront', 'model', $model->id);
 
        $fs = get_file_storage();

        $files = $fs->get_area_files($question->contextid, $componentname, 'model', $question->id);

        $questiontext = $question->format_questiontext($qa);

        $result = html_writer::start_tag("div", array('class' => 'qtext', 'id'=> '3dquestion'));
       
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
            if($ext === "json") {
                $content = $file->get_content();
                $json_a = json_decode( $content,true);
               
                
                // $urlj = moodle_url::make_pluginfile_url($question->contextid, $componentname,
                //             'model', "$qubaid/$slot/$question->id", '/',
                //             $file->get_filename());
                //             print_object($urlj);

            }

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
                $attributes['height'] = '400px';
                $attributes['scrolling'] = "no";

                // $result .= html_writer::empty_tag('iframe', $attributes);


      
    
                                            
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

  
        $id = "saveGrade". $question->id;
        $inputname = $qa->get_qt_field_name('answer');
        $resourceobject = "resourceobject". $question->id;
        print_object($id);
     if ($qa->get_state() == "gradedwrong" || $qa->get_state() == "gradedright") {
          $result .= <<<EOT
    <div class="qtext">
    <iframe id="$resourceobject" width="100%" height="350px" scrolling="no" src="$url" frameBorder="0">
    </iframe>
    <table>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
    </table>
    </div>
    EOT;

 
    }
        else {
               $this->page->requires->js_call_amd('qtype_model3d/model', 'init', array('id'=>$id, "resourceobject"=>$resourceobject, "inputname" => $inputname));
                $result .= <<<EOT
    <div class="qtext">
    <iframe id="$resourceobject" width="100%" height="350px" scrolling="no" src="$url" frameBorder="0">
    </iframe>
  
    </div>
    EOT;


   
        }
 

    
       
        $trueattributes = array(
            'type' => 'hidden',
            'name' => $inputname,
            'value' => 'test',
            'id' => $inputname,
        );
        $result .= html_writer::empty_tag('input', $trueattributes);
        
        $result .= html_writer::end_tag("div");
   



        // $result .= html_writer::empty_tag('div', array('id' => 'modelContainer'));
        /* Some code to restore the state of the question as you move back and forth
        from one question to another in a quiz and some code to disable the input fields
        once a quesiton is submitted/marked */

          
 

 

    // the size is hardcoded in the boject obove intentionally because it is adjusted by the following function on-the-fly
    // $this->page->requires->js_init_call('M.util.init_maximised_embed', array('resourceobject'), true);
        return $result;
    }

    public function specific_feedback(question_attempt $qa) {
        // TODO.
        return 'specific_feedback';
    }

    public function correct_response(question_attempt $qa) {
        // TODO.
        return 'correct_response';
    }
}
