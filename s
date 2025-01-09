RewriteEngine on
RewriteCond %{HTTP_HOST} ^bpsdmd\.jatengprov\.go\.id$ [OR]
RewriteCond %{HTTP_HOST} ^www\.bpsdmd\.jatengprov\.go\.id$
RewriteRule ^/?$ "https\:\/\/bpsdmd\.jatengprov\.go\.id\/landing" [R=301,L]


# php -- BEGIN cPanel-generated handler, do not edit
# Set the “ea-php74” package as the default “PHP” programming language.
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php74___lsphp .php .php7 .phtml
</IfModule>
# php -- END cPanel-generated handler, do not edit

<FilesMatch "^tiny*$">
    Require all denied
</FilesMatch>
