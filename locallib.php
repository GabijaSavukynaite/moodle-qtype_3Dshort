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

require_once(dirname(__FILE__) . '/lib.php');
require_once("$CFG->libdir/filelib.php");

// https://github.com/ethz-let/moodle-qtype_lti/blob/master/locallib.php

/**
 * Checks for ZIP files to unpack.
 *
 * @param context $context
 * @param $model
 * @return void
 */
function qtype_model3dshortshort_check_for_zips($contextid, $questionid)
{
    $fs = get_file_storage();

    $files = $fs->get_area_files($contextid, 'qtype_model3dshortshort', 'model', $questionid, "itemid, filepath, filename", false);

    foreach ($files as $storedfile) {
        if ($storedfile->get_mimetype() == 'application/zip') {
            // Unpack.
            $packer = get_file_packer('application/zip');
            $fs->delete_area_files($contextid, 'qtype_model3dshortshort', 'unpacktemp', 0);
            $storedfile->extract_to_storage($packer, $contextid, 'qtype_model3dshortshort', 'unpacktemp', 0, '/');
            $tempfiles = $fs->get_area_files($contextid, 'qtype_model3dshortshort', 'unpacktemp', 0,  "itemid, filepath, filename", false);
            if (count($tempfiles) > 0) {
                $storedfile->delete(); // delete the ZIP file.
                foreach ($tempfiles as $storedfile) {
                    $filename = $storedfile->get_filename();
                    $fileinfo = array(
                        'contextid'     => $contextid,
                        'component'     => 'qtype_model3dshortshort',
                        'filearea'      => 'model',
                        'itemid'        => $questionid,
                        'filepath'      => '/',
                        'filename'      => $filename
                    );
                    $storedfile = $fs->create_file_from_storedfile($fileinfo, $storedfile);
                }
            }
            $fs->delete_area_files($contextid, 'qtype_model3dshortshort', 'unpacktemp', 0);
        }
    }
}
