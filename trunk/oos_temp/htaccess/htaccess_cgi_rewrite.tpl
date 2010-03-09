# BEGIN OOS
DirectoryIndex {PREFIX}{indexFile}

<IfModule mod_rewrite.c>
  RewriteEngine On

# you have ERROR 403 try this...
# Options +FollowSymlinks

# Spambots

  RewriteCond %{HTTP_USER_AGENT} ^libwww [NC,OR]
  RewriteCond %{HTTP_USER_AGENT} ^lwp
  RewriteRule ^.* - [F]


#  Uncomment following line if your webserver's URL 
#  is not directly related to physival file paths.
#  Update YourShopDirectory (just / for root)

  RewriteBase {PREFIX}

#
#  Rules
#

 RewriteRule ^(.*)-p-(.*).html$ {indexFile}?page=product_info&products_id=$2&rewrite=true& [L,NC,QSA]
 RewriteRule ^(.*)-c-(.*).html$ {indexFile}?page=shop&categories=$2&rewrite=true& [L,NC,QSA]
 RewriteRule ^(.*)-m-(.*).html$ {indexFile}?page=shop&manufacturers_id=$2&rewrite=true& [L,NC,QSA]
 RewriteRule (.*\.html?) index.php?page=$1 [L,QSA]

</IfModule>

# Apache file caching and expiration.
<FilesMatch "\.(jpg|jpeg|png|gif|ico|swf|css|js|txt|xd|xt)$">
    <IfModule mod_expires.c>
        # Enable expirations.
        ExpiresActive On
        # Cache all files for 35 days after access (A).
        ExpiresDefault "access plus 35 days"
    </IfModule>
    <IfModule mod_headers.c>
        Header unset ETag
        FileETag None
    </IfModule>
</FilesMatch>

# Customizable error response
#
ErrorDocument 404 {PREFIX}{errorFile}

# END OOS
