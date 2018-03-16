What and why
============

Well, i tend to be a lazy and needed a lot of random issues created for
plugin testing and this was the result ...

Good to know
============

* Run it using `vendor/bin/redmineIssueGenerator` (first parameter is used to specify config file path)
* By default script looks for a config file `redmine.config.php` in current folder. 
* Get API Token is found on `http://redmine.example.org/my/account` in the right panel click on show
* Currently only issues are created. This does not create Journals and such ...
* Based on [kbsali/redmine-api](https://packagist.org/packages/kbsali/redmine-api)

Minimum config
==============

```php
// Init Class
$generate = new Redmine\IssueGenerator();

// Account details
$generate->setUrl('http://redmine.example.org');
$generate->setToken("REDMINE_API_TOKEN");

// Create issues for these projects
$generate->setProjects(["project1","project2"]);

// Create issues for these users
$generate->setUsers(["admin","guest"]);

// Run it
$generate->createIssues();
```

Advanced config
===============

```php
// Init Class
$generate = new Redmine\IssueGenerator();

// Account details
$generate->setUrl('http://redmine.example.org');
$generate->setToken("REDMINE_API_TOKEN");

// Create issues for these projects
$generate->setProjects(["project1","project2"]);

// Create issues for these users
$generate->setUsers(["admin","guest"]);

// Issues to create: Project * Users * IssueCount
$generate->setIssueCount(2);

// Set text (if npt set baconipsum is used)
$generate->setSubject("I'm a subject with random length");
$generate->setText("I'm a nice descriton with a random length");

// Set description length range
$generate->setSubjectLengthRange([256,512]);

// Set description length range
$generate->setTextLengthRange([256,512]);

// Set random number range in days to subtract from custom date: [min,max]
$generate->setDateLowhRange([3,10]);

// Set random number range in days to add to custom date: [min,max]
$generate->setDateHighRange([3,10]);

// Run it
$generate->createIssues();
```