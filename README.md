Dropbox Uploader
================

Dropbox Uploader is a PHP class which can be used to upload files to [Dropbox](http://www.getdropbox.com/), an online
file synchronization and backup service.

Its development was started before Dropbox released their API, and to work, it scrapes their website. So
you can and probably should use their API now as it is much more stable.

You can use it to create a file upload form for your website, which uploads files to your dropbox. The `example.php` is
a good start; just remove the email/password/destination fields and insert the respective values.

If you have too much time on your hands, you can even create a service to offer the above to non-technical persons.

Usage
-----

    require 'DropboxUploader.php';

    $uploader = new DropboxUploader('email@address.com', 'password');
    $uploader->upload('path/to/a/file.txt');

For a more complete usage example, see `example.php`.

License
-------

Dropbox Uploader is licensed under the [MIT License (`MIT`)](http://spdx.org/licenses/MIT).

Troubleshooting
---------------

**I'm getting the following error:**

    Error: Cannot execute request: SSL certificate problem, verify that the CA cert is OK.⤦
    ⤥ Details: error:14090086:SSL routines:SSL3_GET_SERVER_CERTIFICATE:certificate verify failed

This means that the certificate of the Certification Authority (CA) that Dropbox uses for their SSL certificates is not
installed on your system or PHP/cURL is not configured correctly to find it.

**If you ARE the system administrator**, try installing the CA certificates bundle to a system-wide location. If you
use a package management system, this will ensure that they are kept up to date automatically. On Debian Linux for
example, you can install the package ca-certificates.

**If you are NOT the system administrator**, you can download just [the needed certificate][cert] and point
DropboxUploader to it (before calling the *upload()* method):

    $uploader->setCaCertificateFile("path/to/the/certificate.cer");

[cert]: http://curl.haxx.se/ca/cacert.pem

Developing
----------

Dropbox Uploader is developed both under Unixoide and Windows systems. If you are developing under Windows I recommend
you install [Git][git], keep it updated and use the *git bash*.

[git]: http://git-scm.com/downloads

## Branching

Development is done against [hakre/DropboxUploader][development], the *development*
branch. Create yourself a new branch tracking from it and name it for every non-trivial changes you want to introduce.

Changes are then taken from feature branches into *development* and then into *master*.

[development]: https://github.com/hakre/DropboxUploader

## Testsuite

Dropbox Uploader comes with a Phpunit testsuite located in the `tests` folder.

To get the testsuite configured, copy `phpunit.xml.dist` to `phpunit.xml` and modify the Dropbox email and password
credentials and other configuration if needed.

If you want to use any of these settings from the commandline, set an environment variable with
the same name. Environment variables have a higher priority than the the XML configuration;

    $ export Dropbox_Credential_Password=your-password-goes-here

You can then invoke the testsuite from the projects root directory:

    $ vendor/bin/phpunit tests
