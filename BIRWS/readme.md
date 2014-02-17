<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/rest/web
    ServerName paddyrest.localhost
    ServerAlias paddyrest.localhost
    DirectoryIndex index.php
   <Directory /var/www/rest/web>
      Order allow,deny
      Allow from all
      RewriteEngine On
      RewriteCond %{REQUEST_FILENAME} !-f
      RewriteCond %{REQUEST_FILENAME} !-d
      RewriteRule ^(.*)$ index.php?/$1 [L,QSA]
   </Directory>
</VirtualHost>

https://github.com/bojanz/musicbox/blob/master/src/app.php
