README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "C:/xampp/htdocs/tennis-management/public"
   ServerName .local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "C:/xampp/htdocs/tennis-management/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

</VirtualHost>


On a server where you can't create VirtualHost configuration use:

http://forums.zend.com/viewtopic.php?t=84838#p166908

it says:
create a .htaccess file in the root directory (parent folder of public) and put this code in:

RewriteEngine On 
RewriteRule ^\.htaccess$ - [F] 
RewriteCond %{REQUEST_URI} =""
RewriteRule ^.*$ /public/index.php [NC,L] 
RewriteCond %{REQUEST_URI} !^/public/.*$
RewriteRule ^(.*)$ /public/$1 
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule ^.*$ - [NC,L] 
RewriteRule ^public/.*$ /public/index.php [NC,L]

