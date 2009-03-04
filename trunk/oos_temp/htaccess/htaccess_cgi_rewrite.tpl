# BEGIN OOS
DirectoryIndex {PREFIX}{indexFile}

<IfModule mod_rewrite.c>
  RewriteEngine On

# you have ERROR 403 try this...
# Options +FollowSymlinks

# Spambots

  RewriteCond %{HTTP_USER_AGENT} ^BlackWidow [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Bot mailto:craftbot@yahoo.com [OR]
  RewriteCond %{HTTP_USER_AGENT} ^ChinaClaw [OR]
  RewriteCond %{HTTP_USER_AGENT} ^DISCo [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Download Demon [OR]
  RewriteCond %{HTTP_USER_AGENT} ^eCatch [OR]
  RewriteCond %{HTTP_USER_AGENT} ^EirGrabber [OR]
  RewriteCond %{HTTP_USER_AGENT} ^EmailSiphon [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Express WebPictures [OR]
  RewriteCond %{HTTP_USER_AGENT} ^ExtractorPro [OR]
  RewriteCond %{HTTP_USER_AGENT} ^EyeNetIE [OR]
  RewriteCond %{HTTP_USER_AGENT} ^FlashGet [OR]
  RewriteCond %{HTTP_USER_AGENT} ^GetRight [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Go!Zilla [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Go-Ahead-Got-It [OR]
  RewriteCond %{HTTP_USER_AGENT} ^GrabNet [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Grafula [OR]
  RewriteCond %{HTTP_USER_AGENT} ^JOC Web Spider [OR]
  RewriteCond %{HTTP_USER_AGENT} ^larbin [OR]
  RewriteCond %{HTTP_USER_AGENT} ^LeechFTP [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Mass Downloader [OR]
  RewriteCond %{HTTP_USER_AGENT} ^NetAnts [OR]
  RewriteCond %{HTTP_USER_AGENT} ^NetSpider [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Net Vampire [OR]
  RewriteCond %{HTTP_USER_AGENT} ^NetZIP [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Octopus [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Offline Explorer [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Offline Navigator [OR]
  RewriteCond %{HTTP_USER_AGENT} ^WebStripper [OR]
  RewriteCond %{HTTP_USER_AGENT} ^WebWhacker [OR]
  RewriteCond %{HTTP_USER_AGENT} ^WebZIP [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Wget [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Widow [OR]
  RewriteCond %{HTTP_USER_AGENT} ^Xaldon WebSpider [OR]
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
</IfModule>


# Customizable error response
#
ErrorDocument 404 {PREFIX}{errorFile}

# END OOS
