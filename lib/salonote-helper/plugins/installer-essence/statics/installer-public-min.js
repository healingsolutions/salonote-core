// JavaScript Document
$(document).ready(function(o){function r(t){return"#"+t.map(function(t){return("0"+t.toString(16)).slice(-2)}).join("")}o(".installer_colorpicker").each(function(){
//
// Dear reader, it's actually very easy to initialize MiniColors. For example:
//
//  $(selector).minicolors();
//
// The way I've done it below is just for the demo, so don't get confused
// by it. Also, data- attributes aren't supported at this time...they're
// only used for this demo.
//
o(this).minicolors({control:o(this).attr("data-control")||"hue",defaultValue:o(this).attr("data-defaultValue")||"",format:o(this).attr("data-format")||"hex",keywords:o(this).attr("data-keywords")||"",inline:"true"===o(this).attr("data-inline"),letterCase:o(this).attr("data-letterCase")||"lowercase",opacity:o(this).attr("data-opacity"),position:o(this).attr("data-position")||"bottom",swatches:o(this).attr("data-swatches")?o(this).attr("data-swatches").split("|"):[],change:function(t,a){t&&(a&&(t+=", "+a),"object"==typeof console&&console.log(t))},theme:"bootstrap"})}),o(".installer_colorpicker").change(function(){var t=o(this).attr("data-target"),a=o(this).attr("data-attr"),e=o(this).next(".minicolors-input-swatch").children(".minicolors-swatch-color").css("background-color");o("#"+t).css(a,e),console.log(t+r(e))}),o("#installer_essence_form-radio input:radio").change(function(){var t=o(this).val();o("#installer_essence_form-target").removeClass(),o("#installer_essence_form-target").addClass("font-"+t)}),o(".installer_essence_form_block textarea").each(function(){var t=o(this).val().replace(/<br \/>/g,"");o(this).val(t)})});