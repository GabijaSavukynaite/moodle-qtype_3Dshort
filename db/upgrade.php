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
 * Multi-answer question type upgrade code.
 *
 * @package    qtype
 * @subpackage model3dshort
 * @copyright  2912 Marcus Green 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Upgrade code for the model3dshort question type.
 * A selection of things you might want to do when upgrading
 * to a new version. This file is generally not needed for 
 * the first release of a question type.
 * @param int $oldversion the version we are upgrading from.
 */
function xmldb_qtype_model3dshort_upgrade($oldversion = 0)
{
    global $CFG, $DB;

    $dbman = $DB->get_manager();


    if ($oldversion < 2022051204) {

        // Define table qtype_model3dshort_answer to be created.
        $table = new xmldb_table('qtype_model3dshort_answer');

        // Adding fields to table qtype_model3dshort_answer.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('answer', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);

        // Adding keys to table qtype_model3dshort_answer.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for qtype_model3dshort_answer.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Model3dshort savepoint reached.
        upgrade_plugin_savepoint(true, 2022051204, 'qtype', 'model3dshort');
    }


    return true;
}