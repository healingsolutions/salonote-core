/*
 Form To Wizard https://github.com/artoodetoo/formToWizard
 Free to use under MIT license.

 Originally created by Janko.
 Featured by iFadey.
 Polishing by artoodetoo.

 */
!function(f){f.fn.formToWizard=function(n,t){
/******************** Command Methods ********************/
function e(){
//restore options object from form element
n=f(a).data("options"),d={GotoStep:function(t){var e="step"+--t;if(void 0===f("#"+e)[0])throw"Step No "+t+" not found!";"none"===f("#"+e).css("display")&&(f(a).find(".stepDetails").hide(),f("#"+e).show(),o(t))},NextStep:function(){f(".stepDetails:visible").find("a.next").click()},PreviousStep:function(){f(".stepDetails:visible").find("a.prev").click()}}}
/******************** End Command Methods ********************/
/******************** Private Methods ********************/function s(e){var s="step"+e;f("#"+s+"commands").append("<"+n.buttonTag+' href="#" id="'+s+'Prev" class="'+n.prevBtnClass+'">'+n.prevBtnName+"</"+n.buttonTag+">"),f("#"+s+"Prev").bind("click",function(t){return f("#"+s).hide(),f("#step"+(e-1)).show(),f("html,body").animate({scrollTop:0},"fast"),o(e-1),!1})}function i(e){var s="step"+e;f("#"+s+"commands").append("<"+n.buttonTag+' href="#" id="'+s+'Next" class="'+n.nextBtnClass+'">'+n.nextBtnName+"</"+n.buttonTag+">"),f("#"+s+"Next").bind("click",function(t){return!0===n.validateBeforeNext(a,f("#"+s))&&(f("#"+s).hide(),f("#step"+(e+1)).show(),f("html,body").animate({scrollTop:0},"fast"),
//if (i + 2 == count)
o(e+1)),!1})}function o(t){"function"==typeof n.progress?n.progress(t,r):n.showProgress&&(f("#steps li").removeClass("current"),f("#stepDesc"+t).addClass("current")),n.select&&n.select(a,f("#step"+t))}
/******************** End Private Methods ********************/
// Stop when selector found nothing!
if(0==this.length)return this;"string"!=typeof n&&(n=f.extend({submitButton:"",showProgress:!0,showStepNo:!0,validateBeforeNext:null,select:null,progress:null,nextBtnName:"Next &gt;",prevBtnName:"&lt; Back",buttonTag:"a",nextBtnClass:"btn next",prevBtnClass:"btn prev"},n));var a=this,p=f(a).find("fieldset"),r=p.length,l="#"+n.submitButton,d=null;if("string"!=typeof n)
//assign options to current/selected form (element)
f(a).data("options",n),
/**************** Validate Options ********************/
"function"!=typeof n.validateBeforeNext&&(n.validateBeforeNext=function(){return!0}),n.showProgress&&"function"!=typeof n.progress&&(n.showStepNo?f(a).before("<ul id='steps' class='steps'></ul>"):f(a).before("<ul id='steps' class='steps breadcrumb'></ul>"))
/************** End Validate Options ******************/,p.each(function(t){f(this).wrap('<div id="step'+t+'" class="stepDetails"></div>'),f(this).append('<p id="step'+t+'commands" class="commands"></p>'),n.showProgress&&"function"!=typeof n.progress&&(n.showStepNo?f("#steps").append("<li id='stepDesc"+t+"'>Step "+(t+1)+"<span>"+f(this).find("legend").html()+"</span></li>"):f("#steps").append("<li id='stepDesc"+t+"'>"+f(this).find("legend").html()+"</li>")),0==t?(i(t),o(t)):t==r-1?(f("#step"+t).hide(),s(t),
// move submit button to the last step
f(l).addClass("next").detach().appendTo("#step"+t+"commands")):(f("#step"+t).hide(),s(t),i(t))});else if("string"==typeof n){var c=n;if(e(),"function"!=typeof d[c])throw c+" is invalid command!";d[c](t)}return this}}(jQuery);