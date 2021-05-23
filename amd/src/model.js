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

import Ajax from "core/ajax";

export const init = (id, resourceobject, inputname) => {
  console.log("test" + resourceobject )
  var node = document.createElement("LI");                 // Create a <li> node
var textnode = document.createTextNode("Water");   
console.log(textnode)      // Create a text node
node.appendChild(textnode);   
 const button = document.getElementById(id)

  window.addEventListener("load", (event) => {
    const iframe = document.getElementById(resourceobject);
    const innerDoc = iframe.contentDocument || iframe.contentWindow.document;
    const container = innerDoc.getElementById("rendererCanvas");


//     const button = document.getElementById("saveGrade");
//     buttonShort.style.width = '200px'; // setting the width to 200px
// buttonShort.style.height = '200px'; // setting the height to 200px
// buttonShort.style.background = 'teal'; // setting the background color to teal
// modelContainer



    button.setAttribute(
      "style",
      "display:inline-block; padding:0.3em 1.2em; margin:0 0.3em 0.3em 0;border-radius:2em;box-sizing: border-box;text-decoration:none;font-family:'Roboto',sans-serif;font-weight:300;color:#FFFFFF;background-color:#4eb5f1;text-align:center;transition: all 0.2s;"
    );

    button.addEventListener("click", (e) => {
      console.log("test")
          
    const getAnswers = container.getAnswers;
    const answers = getAnswers();
      // e.prenventDefault();
      // const answers = [];
      // scene.traverse(function (child) {
      //   if (child.name === "draggable") {
      //     child.material.color.set("#fff");
      //     answers.push({
      //       id: child.id,
      //       position: {
      //         x: child.position.x.toFixed(2),
      //         y: child.position.y.toFixed(2),
      //         z: child.position.z.toFixed(2),
      //       },
      //     });
      //   }
      // });

      const answersInput = document.getElementById(inputname);
      answersInput.value = answers;
    
    });
  });



  // export const displayCorrectAnswers = (answers) => {};

  //   var promises = Ajax.call(
  //     [
  //       {
  //         methodname: "qtype_model3d_get_grade",
  //         args: { edugameid: 1, score: 2 },
  //       },
  //     ],
  //     true
  //   );
  //   promises[0]
  //     .done(function (test) {
  //       console.log(test);
  //       console.log("success");
  //     })
  //     .fail(function (response) {
  //       console.log(response);
  //     });
  // });

  // export const init = () => {
  //     var promises = Ajax.call([{
  //         methodname: 'qtype_model3d_get_grade',
  //         args: { edugameid: 1, score: 2 },
  //     }], true);
  //     promises[0]
  //         .done(function() {
  //             console.log("success")
  //         })
  //         .fail(function(response) {
  //             console.log("fail")
  //         });
  // }
};

  export const val = (canvasId) => {console.log("val") }
