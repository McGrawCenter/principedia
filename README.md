Principedia

##Notes##

Posts are generally used for news items and announcements. Pages are used for static pages, such as 'About'
Three new custom post types are created by this plugin: 

* Course Analyses - Course analysis pages include descriptions of the specific course, reflections of learning goals, and information about course instruction. This type of page includes extra fields to record the course code, instructor, and year. Information about course goals, learning from classroom instruction, learning from assignments and external resources can be recorded.

* Courses - Course pages contain information about the course more generally (PSY101), as opposed to a specific instance of a course (PSY101 Fall 2016)

* Strategies - *Strategies are pages that contain information about general strategies for effective learning.  These can be linked to from individual course analyses.



##Documentation##

###Choosing a theme###
Principedia was built to be theme-agnostic, meaning that the functionality that Principedia adds should work in any available Wordpress theme. It should be noted however, that the plugin has really only been 'tested' while using the TwentySixteen default Wordpress theme.

##Recommended additional plugins##
  
 - Redirect After Login
 - Hide Admin Bar
 - CAS or other Authentication plugin


###Adding content###

Building a new Principedia-stype website will require some work to populate the site content with information relevant to your institution. When first installed and enabled, the Principedia plugin only creates 'sample' pages.  As mentioned above, Principedia has three main content areas: Course Analyses, Courses, and Learning Strategies. In addition to these three types of content on the website, you will most likely want to augment the website with normal pages, such as 'About' or 'Contact Us' pages, and with posts, such as for 'News' items. 

The three main types of content in Principedia are interrelated. While editing a course analysis, one may insert links to a Learning Strategy by highlighting text in the editor and selecting the 'Link to Learning Strategy' icon in the toolbar (indicated with a picture of a light bulb). There must first however be Learning Strategies created to which to link. Courses are automatically created wehn a new Course Analysis is saved. Courses are meant to represent the general notion of a course, rather than a specific offering of a course. A course page might have, for example, information about pre-requisites for the course, related departmental information, or sample readings.  In other words,  information that pertains generally to any offering of that course no matter who is teaching it. Course Analyses, on the other hand, pertain to a specific offering of a course and the teaching and learning goals of that specific offering of the course.

##Shortcodes##

[course_analysis_select]
 This inserts a navigation form that allows users to select a department and then a specific course, after which they are provided with a list of course analyses for that course.

[course_analysis_list]
  Inserts a department sorted list of course analyses

[strategy_list]
  Inserts a list of Learning Strategies

[new_course_analysis_form]
  Inserts a form allowing users to create a new course analysis

##Widgets##



  



