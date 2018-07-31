SIMPLE TODO LIST FROM RUBY GARAGE

For test APP:

1) Check test site in header

2)Login with

    login: test
    Password: test

#SQL Task:

All queries were tested in the MySql database.

#Given tables:

    Tasks ( id,name,status,project_id,deadline)
   Projects (id, name,owner)

#Queries:

    1) Get all statuses, not repeating, alphabetically ordered.

SELECT DISTINCT status FROM Tasks ORDER BY status

    2) Get the count of all tasks in each project, order by tasks count descending.

SELECT t1.name as project_name, count(t2.id) as count_tasks FROM Projects as t1 LEFT JOIN Tasks as t2 ON t2.project_id = t1.id GROUP BY project_name ORDER BY count_tasks DESC 

    3) Get the count of all tasks in each project, order by project names.


Select count(t1.id),t2.name From Tasks as t1 JOIN Projects as t2 ON t2.id = t1.project_id GROUP BY project_id ORDER BY t2.name

  4) Get the tasks for all projects having the name beginning with “N” letter.

SELECT t1.name as task, t2.name as project FROM Tasks as t1, Projects as t2 WHERE t2.name LIKE "N%" AND t1.project_id = t2.id

 5)     Get the list of all projects containing the “a” letter in the middle of the name, and show the tasks count near each project. Mention that there can exist projects without tasks and tasks with project_id=NULL.

SELECT t2.name as project, count(t1.id) as count_tasks FROM Projects as t2 LEFT JOIN Tasks  as t1 on t1.project_id = t2.id WHERE t2.name LIKE "%a%" AND t2.name NOT LIKE "a%" AND t2.name NOT LIKE "%a" GROUP BY project

  6) Get the list of tasks with duplicate names. Order alphabetically.

SELECT name FROM Tasks GROUP BY name HAVING count(*)>1 ORDER BY name

    7) Get the list of tasks having several exact matches of both name and status, from the project Garage. Order by matches count.

SELECT t1.name, t1.status, COUNT(*) as task_count FROM Tasks as t1, Projects as t2 WHERE t2.name="Garage" AND t1.project_id = t2.id GROUP BY t1.name, t1.status HAVING count(*)>1 ORDER BY task_count

   8) Get the list of project names having more than 10 tasks in status completed. Order by project_id.

SELECT t1.name FROM Projects as t1 Where t1.id IN (Select t2.project_id From Tasks as t2 Where t2.status = 0 HAVING count(*)>10) ORDER BY t1.id

 9) Get the number of completed tasks:

SELECT t1.name, count(*) FROM Projects as  t1, Tasks as t2 WHERE t2.project_id=t1.id AND t2.status= 0 GROUP BY t1.name HAVING count(*)>10 ORDER BY t1.id


