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

 RewriteRule ^(.*)-p-(.*).html$ {indexFile}?mp=products&file=info&products_id=$2&rewrite=true& [L,NC,QSA]
 RewriteRule ^(.*)-c-(.*).html$ {indexFile}?mp=main&file=shop&categories=$2&rewrite=true& [L,NC,QSA]
 RewriteRule ^(.*)-m-(.*).html$ {indexFile}?mp=main&file=shop&manufacturers_id=$2&rewrite=true& [L,NC,QSA]
 RewriteRule (.*\.html?) index.php?mp=info&file=$1 [L,QSA]
</IfModule>

# Fix certain PHP values
# (commented out by default to prevent errors occuring on certain
# servers)

<IfModule mod_php5.c>
  php_flag register_globals off
  php_value memory_limit 64M
  php_value max_execution_time 18000
  php_value session.use_trans_sid 0
  php_value magic_quotes_gpc 1
  php_value allow_call_time_pass_reference 1
  php_value error_repoting 2039
  php_value display_errors 0
  php_value log_errors 1
  php_value error_log {logFile}
</IfModule>


# Customizable error response
#
ErrorDocument 404 {PREFIX}{errorFile}

# END OOS
