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
function xmldb_qtype_model3dshortshort_upgrade($oldversion = 0)
{
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2021042002) {
        $table = new xmldb_table('question_model3dshort');

        $dbman->rename_table($table, "qtype_model3dshortshort", $continue = true, $feedback = true);
        upgrade_plugin_savepoint(true, 2021042002, 'qtype', 'model3dshort');
    }

    if ($oldversion < 2021042400) {

        // Define table qtype_model3dshortshort_model to be created.
        $table = new xmldb_table('qtype_model3dshortshort_model');

        // Adding fields to table qtype_model3dshortshort_model.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('questionid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('canvasid', XMLDB_TYPE_CHAR, '20', null, null, null, null);
        $table->add_field('width', XMLDB_TYPE_INTEGER, '5', null, null, null, null);
        $table->add_field('height', XMLDB_TYPE_INTEGER, '5', null, null, null, null);

        // Adding keys to table qtype_model3dshortshort_model.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('questionid', XMLDB_KEY_UNIQUE, ['questionid']);

        // Conditionally launch create table for qtype_model3dshortshort_model.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // model3dshort savepoint reached.
        upgrade_plugin_savepoint(true, 2021042400, 'qtype', 'model3dshort');
    }

    if ($oldversion < 2022050903) {

        // Define field initialpoints to be added to qtype_model3dshortshort.
        $table = new xmldb_table('qtype_model3dshortshort');
        $field = new xmldb_field('initialpoints', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, 'A=1;B=1;C=1;E=1;E_1=1;E_2=1;F=1;F_1=1;F_2=1', 'incorrectfeedbackformat');

        // Conditionally launch add field initialpoints.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // model3dshort savepoint reached.
        upgrade_plugin_savepoint(true, 2022050903, 'qtype', 'model3dshort');
    }

    if ($oldversion < 2022050904) {

        // Rename field initialpoints on table qtype_model3dshortshort to answer.
        $table = new xmldb_table('qtype_model3dshortshort');
        $field = new xmldb_field('initialpoints', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, 'A=1;B=1;C=1;E=1;E_1=1;E_2=1;F=1;F_1=1;F_2=1', 'incorrectfeedbackformat');

        // Launch rename field initialpoints.
        $dbman->rename_field($table, $field, 'answer');

        // model3dshort savepoint reached.
        upgrade_plugin_savepoint(true, 2022050904, 'qtype', 'model3dshort');
    }




    return true;
}
