// JavaScript Document
$(document).ready(function(){function i(t){return"#"+t.map(function(t){return("0"+t.toString(16)).slice(-2)}).join("")}$(".installer_colorpicker").each(function(){
//
// Dear reader, it's actually very easy to initialize MiniColors. For example:
//
//  $(selector).minicolors();
//
// The way I've done it below is just for the demo, so don't get confused
// by it. Also, data- attributes aren't supported at this time...they're
// only used for this demo.
//
$(this).minicolors({control:$(this).attr("data-control")||"hue",defaultValue:$(this).attr("data-defaultValue")||"",format:$(this).attr("data-format")||"hex",keywords:$(this).attr("data-keywords")||"",inline:"true"===$(this).attr("data-inline"),letterCase:$(this).attr("data-letterCase")||"lowercase",opacity:$(this).attr("data-opacity"),position:$(this).attr("data-position")||"bottom",swatches:$(this).attr("data-swatches")?$(this).attr("data-swatches").split("|"):[],change:function(t,a){t&&(a&&(t+=", "+a),"object"==typeof console&&console.log(t))},theme:"bootstrap"})}),$(".installer_colorpicker").change(function(){var t=$(this).attr("data-target"),a=$(this).attr("data-attr"),o=$(this).next(".minicolors-input-swatch").children(".minicolors-swatch-color").css("background-color");$("#"+t).css(a,o),console.log(t+i(o))})});