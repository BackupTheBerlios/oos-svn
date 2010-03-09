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

# Customizable error response
#
ErrorDocument 404 {PREFIX}{errorFile}

# END OOS
