# microFramework

When I worked on a new project based on Symfony, I started to like Symfony.  
Not too long and I ported one of my projects to Symfony, just to see how my code would look like then.  
There were just two problems:

* First, it's big with around 7.000 files
* I couldn't get it running in a subdirectory on my (free, shared) server

The first point isn't that crucial, it just takes a good amount of time
uploading or even deleting (via FTP) the files from the server - but well,
that's a one time job, normally.
IMO the sheer amount of files just didn't fit with my small project.

So I thought about throwing frameworks overboard (never heard of micro frameworks before).
But then it came to my mind that I had time and could create my *own* basic (micro) framework.

And here I am. :D


## Features

* Routing for cleaner URLs
* Autoloader
* View class
* Request class


## Structure

- **Classes**  
  Here the class files for your project should be placed.  
  The `Example.class.php` is such
  
- **Classes/Base**  
  This is the place for the internal classes of the framework.  
  Eg. the `Router.class.php`
  
- **templates**  
  This is the default location it searches for templates.  
  More info at [View usage](#custom-tpl-dir)

- **config.yml**  
  This is the config file for the Framework.


## Usage

### Routing

Routes are defined in the config file.  
Everything should be explained in there.

### View

To render/include a template you can use the `render()` method of the View class.

Similar to Symfony, the first parameter is the file name and the second parameter
can be an associative array with variables to pass to the template.
Look at the `Example.class.php` for an example.

<a name="custom-tpl-dir"></a> **Tip:** If you want to use another folder name for your templates,
edit the `Base` class by passing the folder name to the initialization of the View class.

*You need to extend your class with the `Base` class to have this class available.*

### Database

For connecting to a database you just need to set the connection parameters in the config file.
Like the View class, you access it via `$this->DB`.
This framework uses [PDO](http://php.net/manual/de/book.pdo.php) by default.
You may need to take a look at a [tutorial](https://phpdelusions.net/pdo) first.

*You need to extend your class with the `Base` class to have this class available.*

### Request

This framework also contains a `Request` class for getting info about an Request/URL.  
By default, without parameters, it takes the current page.

The info that can be get by the `get()` method is the same as in the
[manual of parse_url()](http://php.net/manual/en/function.parse-url.php#refsect1-function.parse-url-returnvalues),  
including the alias *'protocol'* for *'scheme'*.

Examples:
```php
$request = new Request('https://www.google.de/?q=search');

$path  = $request->get('path');
$https = ($request->get('protocol') == 'https');
$hasId = $request->query->has('q');
$id    = $request->query->q;
$query = $request->getFullQuery();
```
