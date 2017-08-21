



jQuery( document ).ready(function() {


   // toggle the display of comments on the course analysis pages

   jQuery(".show-comments").click(function(e) {
    var target = ".comments-list-"+jQuery(this).attr('rel');
    jQuery(target).toggle();
    e.preventDefault();
   });







   // For the course analysis dropdown navigation

   jQuery('#selectdept').change(function(){
     var deptid = jQuery(this).find(":selected").attr('deptid');
     var deptname = jQuery(this).find(":selected").text();
     populateCourseDropdown(deptname);
   });


   // click event on second dropdown, populate list
   // note:the click handler needs to be a little different because course-choice is dynamically generated

   jQuery( document ).on( 'change', '#selectcourse', function() {
     var courseid = jQuery(this).find(":selected").text();
     console.log(courseid);
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
        jQuery('#learning_strategies_list').append('<div><a href="'+value.guid+'">'+value.post_title+'</a> - '+value.meta.principedia_semester+'  '+value.meta.principedia_year+', '+value.meta.principedia_instructor+'</div>')
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
    //jQuery('#course-choice-dropdown').append('<label class="ca_dropdown_label">Select Course</label>');
    jQuery('#course-choice-dropdown').append('<select name="selectcourse" id="selectcourse"><option value="" disabled selected>Select Course</option></select>');

    jQuery.each(jQuery.parseJSON(remote), function(index,value) {
        jQuery('#selectcourse').append("<option class='course-choice'>"+value.course+"</option>");
    });

  }




   // learning strategy link and popup behaviors

   jQuery('.learning-strategy-link').mouseover(function(e) {

    var togglestate = jQuery('#learning-strategy-link-popup').css('display');
    if(togglestate != 'block') {

     var target_id = jQuery(this).attr('rel');
     jQuery('#learning-strategy-link-popup-content').html('');
     jQuery.ajax({
        url: principedia_data.site_url+'/wp-json/wp/v2/strategy/'+target_id,
        dataType: 'json',
        type: 'GET',
        success: function(data) {
	   console.log(data);
            var html = "<h6 style='margin:0px;'>"+data.title.rendered+"</h6>";
            html += "<div class='learning-strategy-popup-content'>"+data.content.rendered+"</div>";
            html += "<div style='width:100%;text-align:right;margin-top:10px;'><a href='"+data.link+"'>Read more</a><div>";
	    jQuery('#learning-strategy-link-popup-content').html(html);
        },
        error: function() {
            console.log('could not retrieve json data');
        }
     });
     var parentwidth = (jQuery(this).parent().width()-400)/2;
     var left = jQuery(this).parent().position().left + parentwidth;
     //var left = jQuery(this).position().left;
     var top = jQuery(this).position().top;
     
     jQuery('#learning-strategy-link-popup').css({top: top+20, left: left, position:'absolute', display: 'inline-block'});

     }  // end if toggle state
    });





    // close the learning strategy popup

   jQuery(".close").click(function(e) {
     jQuery('#learning-strategy-link-popup').toggle();
     e.preventDefault();
    });

/*
   jQuery('.learning-strategy-link').mouseout(function(e) {
     jQuery('#learning-strategy-link-popup').hide();
    });

   jQuery('#learning-strategy-link-popup').mouseout(function(e) {
     jQuery('#learning-strategy-link-popup').hide();
    });

   jQuery('#learning-strategy-link-popup').mouseover(function(e) {
     jQuery('#learning-strategy-link-popup').show();
    });
*/



});
