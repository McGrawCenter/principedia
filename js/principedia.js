



jQuery( document ).ready(function() {
    

   jQuery('.dept-choice').click(function(){
     var deptid = jQuery(this).attr('deptid');
     var deptname = jQuery(this).text();
     populateCourseDropdown(deptname);
   });

   // click event on second dropdown, populate list
   // note:the click handler needs to be a little different becase course-choice is dynamically generated
   jQuery( document ).on( 'click', '.course-choice', function() {
     var courseid = jQuery(this).text();
     populatelist(courseid);
   });


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
         //jQuery( "<option>"+value.course+"</option>" ).appendTo( '#course-select' );
        console.log(value);
        jQuery('#learning_strategies_list').append('<div><a href="'+value.guid+'">'+value.post_title+'</a> '+value.meta.principedia_course+'  '+value.meta.principedia_year+' '+value.meta.principedia_instructor+'</div>')
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
    jQuery('#course-choice-dropdown').append('<label>Select Course</label>');
    jQuery('#course-choice-dropdown').append('<select name="course-select" id="course-select"></select>');

    jQuery.each(jQuery.parseJSON(remote), function(index,value) {
         //jQuery( "<option>"+value.course+"</option>" ).appendTo( '#course-select' );
        jQuery('#course-select').append("<option class='course-choice'>"+value.course+"</option>");
    });

  }



});
