# TIME Action Tracking System
## Introduction

TIME is an action tracking system aims to help people build their own schedule. Essentially, it's a Wordpress plugin developed by PHP, Javascript, CSS and HTML5.  

## Environment
Nothing more is needed except a Wordpress environment.


# What TIME can do now?
## Action Tracking
This system is able to handle four kinds of entries now, action, project, meeting and calendar. All of them support to be Created, Updated, Deleted and Retrieved with different property.  

## Generate Report
There's sub-system known as Report which used to generate various of report based on filters. There are different kinds of filters:
* **Based on parameters**: begin,end,create,end time, risk level and progress of an action, create time of a project, create time of a meeting and calendar entry.
*  **Based on time scale**: time scale is the unit to partition x-axis. Year, quarter, month are supported.
*  **Based on chart type**: Line, Bar, Area, column and Pie chart are supported.
*  **Based on time range**: determine the minimum and maximum of time you would like to display on the chart. 
*  If progress is chosen as the parameter, then a filter **based on progress scale** can be used to determine how to partition the progress. 

Try it in "menu"->"report".


## Custom Configuration
I intended to provide users a highly custom environment to make them comfortable, there would be different configurations for each individual user stored on the server side. For now, only one configuration is supported, which is they way to display **risk type**. 

Try in "menu"->"setting"->"Risk Type".


## Import/Export Process
Import and Export process are supported based on a well formatted XML file. Try it in "menu"->"setting"->"Template".



# What's next?

## Bug Tracing
The current version will have bugs after being tested by users (mostly my friends). All bugs will be recorded in [bug](https://github.com/wfgydbu/timeistime/blob/master/trace/bug.md).


## Keep Optimizing
Except bugs, there are also details need to be improved. Without these details will not fault the system, but they make the system more user-friendly and easier to use. A list here:
* A new button in reregistration form to verify if the current user name has been used by others.
* All information will be reset after the submit button is clicked. Even if some information is incorrect and users have to re-type all information once more.
* Filters for table views
* After user CRUDing, auto-refreshing the father window. 
* In calendar view, contents aren't displayed completely.
* See more in [optimize](https://github.com/wfgydbu/timeistime/blob/master/trace/optimize.md).


## New Features

I do have some new ideas on this project. Since a new semester is coming, I may not have enough time to do it. I will list them here in case that I get time in the future.
* Group/Team features, to provide service for a team including more than one user. They share their actions to cooperate with each other. 
* Special calendar or meeting entries. E.g. Users want to add a new meeting entry for every Monday in the next 6 weeks.
* See more in [new](https://github.com/wfgydbu/timeistime/blob/master/trace/new.md).


# Run my own TIME
Four simple steps are needed if you want to build TIME on your own Wordpress site.

* Step 1: Build a pure wordpress site and make it work.
* Step 2: Choose **Twenty fifteen**(I used version 1.5, updated version should be fine as well) as your theme.
* Step 3: Install another simple plugin and activate it, then add the content of this [file](https://github.com/wfgydbu/timeistime/blob/eb85357d82e0122aee3d9ad929fcdbe4f6283f11/resource/overwrite_css.txt) to overwirte the orginial style of the theme. 
* Step 4: Install TIME, activate it and enjoy it.

I learned later that child theme can be used to overwrite the style of default theme, but I don't have time to rewrite it.

# About this project
## The Origin
The whole thing origins from the Spring of 2016 on a course of database. Students are required by their professor to build this action tracking system based on Wordpress(MySQL as the backend database). However, the project failed in the end for some reasons. Later, I felt it's a pity to abandon this half-finished project. So I tried to restart it by myself in the summer.

## The Author
* [Ethan Huang](http://journal.ethanshub.com ), a master student in George Washington University.

## Thanks
* Thanks to Professor David for providing the server to me so I can release the site on the Internet.
* Thanks to Adam Yang and Zhe Yang for testing work during my development.


# Support

If you are having problems, send a mail to [huangyitian@gwu.edu](huangyitian@gwu.edu).

# License

All contents of this package are licensed under the [MIT license](https://github.com/wfgydbu/timeistime/blob/eb85357d82e0122aee3d9ad929fcdbe4f6283f11/LICENSE.md).

**Ethan Huang**

**August 29th, 2016**