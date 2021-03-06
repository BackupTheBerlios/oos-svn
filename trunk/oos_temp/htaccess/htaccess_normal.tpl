# BEGIN OOS
DirectoryIndex {PREFIX}{indexFile}

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


# Fix certain PHP values
# (commented out by default to prevent errors occuring on certain
# servers)

<IfModule mod_php5.c>
  php_flag register_globals off
  php_flag magic_quotes_gpc off
  php_value memory_limit 64M
  php_value max_execution_time 18000
  php_value session.use_trans_sid 0
  php_value allow_call_time_pass_reference 1
  php_value error_repoting 2039
  php_value display_errors 0
  php_value log_errors 1
  php_value error_log {logFile}
</IfModule>

# END OOS
