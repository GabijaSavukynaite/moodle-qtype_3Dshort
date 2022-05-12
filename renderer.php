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
 * model3dshort question renderer class.
 *
 * @package    qtype
 * @subpackage model3dshort
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/mod/resource/lib.php');

/**
 * Generates the output for model3dshort questions.
 *
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)

 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_model3dshortshort_renderer extends qtype_renderer
{
    public function formulation_and_controls(
        question_attempt $qa,
        question_display_options $options
    ) {
        global $DB, $PAGE;

        $question = $qa->get_question();
        $componentname = $question->qtype->plugin_name();
        $model = $DB->get_record('qtype_model3dshortshort_model', array('questionid' => $question->id));

        $fs = get_file_storage();

        $files = $fs->get_area_files($question->contextid, $componentname, 'model', $question->id, 'sortorder DESC, id ASC', false);
        $result = html_writer::start_tag("div", array('class' => 'qtext', 'id' => '3dquestion'));
        $code = html_writer::empty_tag("div", null);

        $feedbackclass = '';
        $feedbackimage = '';

        $response = $qa->get_last_qt_data();

        if ($options->correctness && $response["answer"]) {
            $fraction = 0.0;
            if ($response["answer"] == $question->answer) {
                $fraction = 1.0;
            }
            $feedbackclass = $this->feedback_class($fraction);
            $feedbackimage = $this->feedback_image($fraction);
        }

        $result .= html_writer::tag(
            'div',
            $question->format_questiontext($qa),
            array('class' => 'qtext')
        );
        $inputname = $qa->get_qt_field_name('answer');
        $inputname1 = $qa->get_qt_field_name('answer');
        $resourceobject = "resourceobject" . $question->id;

        $trueattributes = array(
            'type' => 'hidden',
            'name' => $inputname,
            'id' => $inputname
        );

        $result .= html_writer::empty_tag('input', $trueattributes);
        // $result .= <<<EOT
        // <div class="qtext">
        //   <div class="task"></div>
        // </div>
        // EOT;

        // $resource->mainfile = $file->get_filename();

        if (count($files) < 1) {
            // resource_print_filenotfound($resource, $cm, $course);
            die;
        } else {
            $file = reset($files);
            $qubaid = $qa->get_usage_id();
            $slot = $qa->get_slot();

            $filepath = $file->get_filepath();
            unset($files);
            $url = moodle_url::make_pluginfile_url(
                $question->contextid,
                $componentname,
                'model',
                "$qubaid/$slot/$question->id",
                "$filepath",
                $file->get_filename()
            );

            $iframename = $qa->get_qt_field_name('iframe');
            $field_prefix = explode("_", $iframename)[0];
            $splited_prefix = explode(":", $field_prefix);
            $url_with_params = $url->out(true, array("qid" => $splited_prefix[0], "a" => $splited_prefix[1]));

            $ext = strtolower(pathinfo($file->get_filename(), PATHINFO_EXTENSION));
            if ($ext == "html") {
                $result .= <<<EOT
                <div class="qtext">
                    <iframe id="$iframename" name="$iframename" width="100%" height="350px" scrolling="no" src="$url_with_params" frameBorder="0">
                    </iframe>
                </div>
                EOT;
            }



            // $PAGE->requires->js($url);
            // https://subscription.packtpub.com/book/hardware-&-creative/9781849511902/1/ch01lvl1sec03/loading-a-javascript-file
        }


        $result .= html_writer::tag('div', $feedbackimage);
        $result .= html_writer::end_tag("div");
        return $result;
    }

    public function specific_feedback(question_attempt $qa)
    {
        $table = $this->build_results_table();
        return $table;
    }

    // public function correct_response(question_attempt $qa) {
    //     // TODO.
    //     return 'correct_response';
    // }

    protected function build_results_table()
    {

        $testresults = array(
            array('test', "expacted", "got", 0.0),
            array('test', "expacted", "got", 0.2),
            array('test', "expacted", "got", 1.0)
        );

        // if(is_array($testresults) && count($testresults) > 1) {
        $table = new html_table();
        // $table->attributes['class'] = '';
        // $headers = $testresults[0];
        $headers = array("Test", "Expected", "Got", "iscorrect");
        foreach ($headers as $header) {
            if (strtolower($header) != 'ishidden') {
                $table->head[] = strtolower($header) === 'iscorrect' ? '' : $header;
            }
        }

        $rowclasses = array();
        $tablerows = array();

        for ($i = 0; $i < count($testresults); $i++) {

            $cells = $testresults[$i];
            // $rowclass = $i % 2 == 0 ? 'r0' : 'r1';
            $tablerow = array();
            $j = 0;

            foreach ($cells as $cell) {
                if (strtolower($headers[$j]) === 'iscorrect') {
                    $markfrac = (float) $cell;
                    $tablerow[] = $this->feedback_image($markfrac);
                } else {
                    $tablerow[] = $this->format_cell($cell);
                }

                $j++;
            }
            $tablerows[] = $tablerow;
            // $tablerows[] = $cells;
            // $rosclasses[] = $rowclass;
        }
        $table->data = $tablerows;
        // $table->rowclasses = $rowclasses;
        // }

        return html_writer::table($table);
    }

    public static function format_cell($cell)
    {
        if (substr($cell, 0, 1) === "\n") {
            $cell = "\n" . $cell;  // Fix <pre> quirk that ignores leading \n.
        }
        return '<pre class="tablecell">' . s($cell) . '</pre>';
    }
}
