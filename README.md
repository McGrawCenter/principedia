
# Principedia

## Description

Principedia is a Wordpress plugin that provides a basic framework for the creation of a website styled after the Principedia project at Princeton University.

## Posts, Pages, and other Content Types


Posts are generally used for news items and announcements. Pages are used for static pages, such as 'About' Three new custom post types are created by this plugin:

* Course Analyses - Course analysis pages include descriptions of the specific course, reflections of learning goals, and information about course instruction. This type of page includes extra fields to record the course code, instructor, and year. Information about course goals, learning from classroom instruction, learning from assignments and external resources can be recorded.

* Courses - Course pages contain information about the course more generally (PSY101), as opposed to a specific instance of a course (PSY101 Fall 2016)

* Strategies - Strategies are pages that contain information about general strategies for effective learning. These can be linked to from individual course analyses.


## Choosing a theme

Principedia was built to be theme-agnostic, meaning that the functionality that Principedia adds should work in any available Wordpress theme. It should be noted however, that the plugin has really only been 'tested' while using the TwentySixteen default Wordpress theme.

## Recommended additional plugins

- Redirect After Login
- Hide Admin Bar
- CAS or other Authentication plugin
- Akismet

## Adding content

Building a new Principedia-style website will require some work to populate the site content with information relevant to your institution. When first installed and enabled, the Principedia plugin only creates 'sample' pages. As mentioned above, Principedia has three main content areas: Course Analyses, Courses, and Learning Strategies. In addition to these three types of content on the website, you will most likely want to augment the website with normal pages, such as 'About' or 'Contact Us' pages, and with posts, such as for 'News' items.

The three main types of content in Principedia are interrelated. While editing a course analysis, one may insert links to a Learning Strategy by highlighting text in the editor and selecting the 'Link to Learning Strategy' icon in the toolbar (indicated with a picture of a light bulb). There must first however be Learning Strategies created to which to link. Courses are automatically created wehn a new Course Analysis is saved. Courses are meant to represent the general notion of a course, rather than a specific offering of a course. A course page might have, for example, information about pre-requisites for the course, related departmental information, or sample readings. In other words, information that pertains generally to any offering of that course no matter who is teaching it. Course Analyses, on the other hand, pertain to a specific offering of a course and the teaching and learning goals of that specific offering of the course.

## Step By Step Installation

- Install Wordpress if you don’t already have an installation. 
- Download and install a theme.
- Download, install, and activate the Principedia plugin. 
- Create a page titled “Course Analysis List” and add the shortcode [course_analysis_list] in the text field. Click Publish.  (Nothing will appear on this page UNTIL a Course Analysis is created).
- Create a page titled “Learning Strategies” and add the shortcode [strategy_list] in the text field. Click Publish.  (Nothing will appear on this page UNTIL a Learning Strategy is created).
- Create a page titled “Course Analysis Entry” and add the shortcode [new_course_analysis_form] in the text field. Click Publish. This shortcode will insert a form allowing logged-in users to add new course analyses to the site.

## Suggestions

Create a few learning strategies first and apply categories to them such as time management, note taking or problem solving.  Any new learning strategies will automatically be applied to the Learning Strategies page. You can add new categories from the Categories widget on the right side of the entry form. 

You don't have to create new departments as departments and courses will be automatically generated anytime someone creates a Course Analysis. Considering most (all?) colleges and universities have English and Mathematics departments, you can create these ahead of time. Select "Courses" from the left dashboard and then "Departments". You can add new departments here. Name = English, Slug = ENG (or the designation given by the registrar’s office).  Some Programs may have a Parent Department. The department must be created prior to the program. 

## Shortcodes

[course_analysis_select] This inserts a navigation form that allows users to select a department and then a specific course, after which they are provided with a list of course analyses for that course.

[course_analysis_list] Inserts a department sorted list of course analyses

[strategy_list] Inserts a list of Learning Strategies

[new_course_analysis_form] Inserts a form allowing users to create a new course analysis

## Widgets
The plugin installs a widget called ‘Course Analysis Navigation’. This is a copy of the course_analysis_select shortcode above, but in widget form. The widget allows users to select a course analysis by first selecting the department from a dropdown menu and then selecting a course offering from that department.

## License and disclaimer
This software is offered free for use and "as-is" under a Creative Commons Attribution Share Alike 4.0 license. No support will be provided by the software developer or by Princeton University and Princeton University is not responsible for any issues that may arise from the use of this software.
