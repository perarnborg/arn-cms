ARN CMS
=======

ARN CMS is a simple CMS.

The application uses the Phalcon framework. Phalcon PHP is a web
framework delivered as a C extension providing high performance and
lower resource consumption.

Please contact Per Arnborg if you have any feedback.

Thank you.


Get Started
-----------

#### Requirements

To run this application on your machine, you need at least:

* >= PHP 5.3.9
* Apache Web Server with mod rewrite enabled
* Phalcon Framework extension installed/enabled
* SASS installed (in dev environment)

Then you'll need to create a database and update the credentials in the
following file, then rename the file to config.ini:

	/app/config/config_example.ini

Import this schema:

	schemas/arn-cms.sql


Start SASS watch (needed in dev)
--------------------------------

cd arn-cms
sass --watch public/css/_application.scss:public/css/application.css
