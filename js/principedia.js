



jQuery( document ).ready(function() {


   jQuery('#selectdept').change(function(){
     var deptid = jQuery(this).find(":selected").attr('deptid');
     var deptname = jQuery(this).find(":selected").text();
     populateCourseDropdown(deptname);
   });




   // click event on second dropdown, populate list
   // note:the click handler needs to be a little different because course-choice is dynamically generated

   jQuery( document ).on( 'click', '#selectcourse', function() {
     var courseid = jQuery(this).find(":selected").text();
     console.log(courseid);
     populatelist(courseid);
   });

/*
   jQuery( document ).on( 'click', '.course-choice', function() {
     var courseid = jQuery(this).text();
     populatelist(courseid);
   });
*/

  function populatelist(courseid){
    var remote;
    jQuery.ajax({
        type: "GET",
        url: '?json=analyses&courseid='+courseid,
        async: false,
        success : function(data) {
            remote = data;
        }
    });
    jQuery('#learning_strategies_list').html('');

    jQuery.each(jQuery.parseJSON(remote), function(index,value) {
        jQuery('#learning_strategies_list').append('<div><a href="'+value.guid+'">'+value.post_title+'</a> '+value.meta.principedia_course+'  '+value.meta.principedia_semester+'  '+value.meta.principedia_year+' '+value.meta.principedia_instructor+'</div>')
    });
  }




  function populateCourseDropdown(deptname) {
    var remote;
    jQuery.ajax({
        type: "GET",
        url: '?json=courses&dept='+deptname,
        async: false,
        success : function(data) {
            remote = data;
        }
    });
    jQuery('#course-choice-dropdown').html('');
    jQuery('#course-choice-dropdown').append('<label class="ca_dropdown_label">Select Course</label>');
    jQuery('#course-choice-dropdown').append('<select name="selectcourse" id="selectcourse"><option></option></select>');

    jQuery.each(jQuery.parseJSON(remote), function(index,value) {
        jQuery('#selectcourse').append("<option class='course-choice'>"+value.course+"</option>");
    });

  }



});
