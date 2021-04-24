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
 * model3d setup the ES6 javascript for the question type
 * https://docs.moodle.org/dev/Javascript_Modules#ES6_Modules_.28Moodle_v3.8_and_above.29
 *
 * @package    qtype
 * @subpackage model3d
 * @copyright  THEYEAR YOURNAME (YOURCONTACTINFO)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Set up the plugin.
 *
 * @method init
 */
export const init = (data) => {
  
  var iframe = document.getElementById('resourceobject');
var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
const container = innerDoc.getElementById("WebGL-output");
  // var node = document.createElement("LI"); // Create a <li> node
  // var textnode = document.createTextNode("Water"); // Create a text node
  // node.appendChild(textnode); // Append the text to <li>
  // container.appendChild(node);
  const point = container.scene.getObjectByName("point");
  point.position.x = 300;
  point.position.y = 20;
  console.log();
};
