# After Action Review Report

This document is about the overall project experience.

**Table of Contents:**

- [What was Expected to Happen](#what-was-expected-to-happen)
    - [Purpose](#purpose)
    - [Objective](#objective)
    - [Timeline](#timeline)
    - [People Involved](#people-involved)
    - [Open Sources Utilized](#open-sources-utilized)
    - [Intented Outcomes](#intented-outcomes)
    - [Expected Barriers](#expected-barriers)

- [What Actually Occurred](#what-actually-occurred)
    - [Real Timeline](#real-timeline)
    - [The Good Part](#the-good-part)
        - [User Needs Identification](#user-needs-identification)
        - [Team Communication](#team-communication)
        - [Backup Plan](#backup-plan)
    - [The Bad Part](#the-bad-part)
        - [Poor Admin Management System](poor-admin-management-system)
        - [UI Design](#ui-design)
        - [Work Distribution](#work-distribution)

- [What Went Well and Why](#what-went-well-and-why)
    - [Backup Database Plan](#backup-database-plan)
    - [Prerequisites Pending Algorithm](#prerequisites-pending-algorithm)
    - [Integrate Jenkins](#integrate-jenkins)

- [What Can be Improved and Why](#what-can-be-improved-and-why)

- [What Did I learn](#what-did-i-learn)
    - [Software Development Cycle](#software-development-cycle)
    - [Compromises](#compromises)
    - [LAMP and Full Stack Development](#lamp-and-full-stack-development)
    - [Technologies](#technologies)

## What was Expected to Happen

### Purpose

The purpose of this project is to optimize students' course registration experience so that students can graduate smoothly without any unnecessary courses. In addition, students can easily and quickly find out the names of courses that have topics of interest to them.

### Objective

The purpose of this project is to create an enhanced/plus version of the currently used Visual Schedule Builder, which integrates course search and academic builders into it.

### Timeline

The initial timeline was:

1. <b>First Half of Fall 2020 :</b> The project design (LoFi, HiFi).
2. <b>Second Half of Fall2020 :</b> Basic project documentation.
3. <b>Christmas Break:</b> Most front-end structures develop and create databases or obtain database support.
4. <b>First Half of Winter 2020:</b> Complete the coding part.
5. <b>Second Half of Winter 2020:</b> Rest of the documentation.

### People Involved

Team member and role responsibility: 

1. Xinyu Liu, 200362878, Scrum Master
2. Jingkang Yang, 200362586, Developer
3. Xia Hua, 200368746, Developer
4. Priscilla Chua, 200363504, Business Analysis

Project Instructor: <b>Timothy Maciag</b>

Project Mentor: <b>Mohamed El-Darieby</b>

### Open Sources Utilized

1. Chart.js (2.9.4). (2013). [Open source HTML5 Charts for website]. GitHub. https://www.chartjs.org/
2. FullCalendar (5.5.1). (2009). [JavaScript Event Calendar]. GitHub. https://fullcalendar.io/
3. Jenkins (2.263.3). (2011). [The leading open source automation server]. GitHub. https://www.jenkins.io/
4. ThinkPHP (6.0.6). (2006). [Web application development framework based on PHP]. http://www.thinkphp.cn/

### Intented Outcomes

The original plan of the project was to give each course several tags or labels to indicate course attributes. And, based on the tags, users can search for courses by filtering different categories, or get more personalized recommendations for elective courses.

However, due to the complexity of the design, this idea was abandoned at the project design stage. After that, the team decided to manage the course in the normal way.

It is expected that the course database will be shared by the IT support staff of the university, so we can focus on data analysis and application instead of data parsing.

The expected result is to create a website with a variety of academic builder functions to help students build an ideal academic life. Through this website, students should be able to establish a personal study schedule without having to consult advisors or waste a lot of time searching online.


### Expected Barriers

The expected barriers include: obtaining course database support from IT support; lack of design experience, resulting in the user interface meeting only the minimum requirements; and setting up the server and database from the bottom.

## What Actually Occurred

### Real Timeline

The real timeline was:

1. <b>First Half of Fall 2020 :</b> The project design (LoFi, HiFi) and basic project documentation.
2. <b>Second Half of Fall2020 :</b> Most front-end architecture development.
3. <b>Christmas Break:</b> Create a database or get database support.
4. <b>First Half of Winter 2020:</b> Complete front-end and most back-end development work.
5. <b>Second Half of Winter 2020:</b> Complete the coding part and the rest of the documentation.

### The Good Part

#### User Needs Identification

The purpose of this project is to help users, especially students and consultants, get the most needed course registration information in one place without having to search the official website of the entire university. By holding a meeting and discussing in depth what users really need, we decided on the three main functions of the project, including two builders and a course searcher.

Through continuous discussion and understanding of user needs, we repeatedly redesigned some details, including the overall layout and content size. We think this is a better way to achieve user-friendly design, because the first version can never be the best.

![User Sequence Diagram](Images%20%26%20Design/Sequence-diagram%20(user).png)
*User Sequence Diagram*

![User Case Diagram](Images%20%26%20Design/User-case-diagram.png)
*User Case Diagram*

#### Team Communication

We continue to communicate with the team, because this is the key to the success of teamwork. 

Ordinary teamwork is to assign the work to everyone at the beginning of each sprint, and there will be a weekly or bi-weekly Scrum meeting. This kind of teamwork is very effective for a large team with experienced developers who know what they are doing. 

But for a student who has four students who hardly know what to do and how to do their own things, this method does not work well. In the first meeting, we discussed how to work in a team. The conclusion is that we have increased the frequency of meetings to twice a week. This helps us achieve better teamwork. This greatly increases the frequency of our communication and also ensures that we all know each other's progress. If someone is behind or ahead of schedule or encounters a problem, we can find out and solve it in advance. This avoids delays in the construction schedule because the problem is only discovered at the end of the sprint.

![Team Communication Plan](Images%20%26%20Design/team_communication_plan.PNG)
*Team Communication Plan*

#### Backup Plan

When designing a project (including user interface and structural design), in order to prevent accidents from happening, we will always develop a backup plan. For example, we initially expected to be supported by the course database supported by university IT, but after communication, we learned that they could not provide us with this support. Therefore, we activated Plan B and created a course database by ourselves by using python to parse the course information disclosed on the university's official website, which took us nearly a week. A backup plan can ensure that we can keep up with the schedule when any unexpected situation occurs, so that we will not spend a lot of time on a single problem that may not be completed as planned in the end.

![Database v1](Images%20%26%20Design/Database/database%20v1.0/database_v1.PNG)
*Database v1*

![Database v2](Images%20%26%20Design/Database/database%20v2.0/database_v2.PNG)
*Database v2*

### The Bad Part

#### Poor Admin Management System

We get the basic admin management system for the web because we only get a few times to quickly build up the system. Originally, the admin system is not in our project plan. At the very end of the capstone project, we get feedback and suggestions from the professor, then we realize that we need an admin system for course management. Then, we rushed did an admin system to make sure it worked well before the due day. So, it does not have many features and lacks testing for now. But, in the future version, we will focus on the admin system and adding more features as we need.

#### UI Design

UI design is a very important factor in our project because we are doing the visual project and trying to help users to build their course schedule. In the process, the users will have lots of interaction with the web page. If users have no idea what they should operate on the web, this will greatly reduce the useability of websites. In the future version, improving the UI design makes it more usable could be an important task. 

#### Work Distribution

At the beginning of the project, we separated the work based on the web page, so that makes the work distribution fair for each one, but it means each group member needs to do care front and back end. It might waste time to do repeat work that other group members have already done. It is an inefficient way to work as a group.

## What Went Well and Why

### Backup Database Plan

The most important step to achieve this goal is to change from seeking university database support to creating a database on your own. There is nothing wrong with the original plan. The plan requires the database support of the hosting organization and writes the data path based on the database structure. This can make the project more reusable and dynamic. However, the university did not provide support. The compromise plan is to use Python to parse the data to build our own database.

### Prerequisites Pending Algorithm

Since we did not pay enough attention to the prerequisite pending algorithm, this algorithm was not considered in the early development. After being corrected by the instructor, we focused all our energy on the development of the algorithm.

We implemented the algorithm prototype through the following general steps:
1. Convert all the prerequisite sentences into regular expressions understandable by the computer.
2. According to the pattern of the assigned regular expression, a for loop with multiple if-else conditions is used to complete the algorithm.
3. Return a true or false status and the reason for the false status.

Our pending algorithm can handle most of the elements in the course prerequisites:
1. Course Requirement
2. Course Grade Requirement
3. Credit Requirement
4. Semester Availability

Even though this algorithm is hard-coded by the pattern of regular expressions, we still think this prototype is a good method. However, this is not an ideal solution to this problem. The ideal solution is to use machine learning to learn and understand the logic in the prerequisite sentences of the course, and to determine the course status based on the given course history.

### Integrate Jenkins

Although Jenkins is not in the scope of the project, we still think this is a good move. Because Jenkins did all the automation work for us. Jenkins fetches and compiles every new commit pushed to GitHub. Jenkins is triggered by the new push from GitHub. No manual intervention is required to make the automated pipeline work normally. In addition, since Jenkins is hosted on our AWS EC2 server, every time Jenkins fetches and compiles, all new changes are automatically stored in our server.

## What Can be Improved and Why

- Adding more features and details for the admin management system, because the system is not perfect to use. 

- Improving the UI design makes the web page better to use and look good. (Consider the UI Component like BootStrap)

- We can consider the role responsibility based on the task content like one person code the front end, one person code the back end, one does testing parts and one writes documents.  Trying to work more efficiently as a group.

- Refactoring the code, we can consider using one web framework which makes the code easy to maintain.

## What Did I learn

### Software Development Cycle

Project definitions and requirements cannot be skipped or completed in a hurry. We ran into trouble finding functional weaknesses and defining functional priorities. If we can sit down and think carefully, maybe we can write code faster instead of wasting time on feature addition and refactoring. We may also have a better understanding of the project so that the user interface is better designed.

Example: Course prerequisites are one of the most important functions required by our project definition. But we didn't start writing it until the end, because we didn't consider how important it is.

### Compromises

We also learned that there are many compromises in the software development cycle. We had to give up some functions to complete the project on time. If we have more time, we can definitely design a better and more user-friendly interface.

### LAMP and Full Stack Development

We did not separate the team by role but decided to allocate it by page so that everyone can understand the LAMP development cycle. We don't want anyone to do all the documentation, resulting in no chance to practice coding.

### Technologies

Of course, we have learned and practiced skills and techniques, including but not limited to, Python data parsing, Jenkins, Open source citation, HTTP, MySQL, GitHub, AWS EC2, Fullcalendar, Chart.js, etc.