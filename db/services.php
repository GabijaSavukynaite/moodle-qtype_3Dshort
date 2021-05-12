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
 * model3d question type  capability definition
 *
 * @package    qtype_model3d
 * @copyright  20XX Author Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$functions = [
    'qtype_model3d_get_grade' => [
        'classname' => 'qtype_model3d_external',
        'classpath' => 'question/type/model3d/externallib.php',
        'methodname' => 'get_grade',
        'description' => 'Returns error or success of when insert new response',
        'type' => 'read',
        'ajax' => true
    ]
];