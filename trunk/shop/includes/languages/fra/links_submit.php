<?php
/* ----------------------------------------------------------------------
   $Id: links_submit.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: links_submit.php,v 1.00 2003/10/03 
   ----------------------------------------------------------------------
   Links Manager
   
   Contribution based on:
   
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Liens';
$aLang['navbar_title_2'] = 'Soumettre un lien';

$aLang['heading_title'] = 'Information des liens';

$aLang['text_main'] = 'Nous vous prions de bien vouloir remplir ce formulaire afin de d�poser votre site web.';

$aLang['email_subject'] = 'Bienvenue chez ' . STORE_NAME . ' �change de liens.';
$aLang['email_greet_none'] = 'Cher / Ch�re %s' . "\n\n";
$aLang['email_welcome'] = 'Nous vous souhaitons la bienvenue <b>' . STORE_NAME . '</b> � notre programme lien d\'�change.' . "\n\n";
$aLang['email_text'] = 'Votre lien a �t� d�pos� avec succ�s aupr�s de ' . STORE_NAME . '. Il sera ajout� � notre liste d�s que nous l\'approuvons. Vous recevrez un message par e-mail concernant le statut de votre soumission. Etant donn� le cas o� vous ne l\'aurez pas re�u dans les 48h, nous vous prions de bien vouloir nous contacter avant de le renvoyer de nouveau.' . "\n\n";
$aLang['email_contact'] = 'N\'h�sitez pas � nous contacter par e-mail, si vous avez besoin d\'une assistance concernant le programme �change de liens: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n";
$aLang['email_warning'] = '<b>Note:</b> Cette adresse e-mail nous a �t� transmise pendant la soumission du lien. Veuillez en cas de probl�mes nous envoyer un e-mail � ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n";
$aLang['email_owner_subject'] = 'Lien vers soumission ' . STORE_NAME;
$aLang['email_owner_text'] = 'Un nouveau lien a �t� d�pos� chez ' . STORE_NAME . '. Il n\'a pas �t� approuv�. Veuillez s\'il vous pla�t v�rifier ce lien et l\'activer.' . "\n\n";

$aLang['text_links_help_link'] = '&nbsp;Help&nbsp;[?]';

$aLang['heading_links_help'] = 'Aide liens';
$aLang['text_links_help'] = '<b>Titre de la page:</b> Un titre descriptif pour votre site web.<br><br><b>URL:</b> L\'adresse Web absolue de votre site web incluant la \'http://\'.<br><br><b>Cat�gorie:</b> La cat�gorie la plus corr�lative sous laquelle votre site web peut �tre class�.<br><br><b>Description:</b> Une br�ve description de votre site.<br><br><b>Image URL:</b> L\'URL absolu de l\'image que vous souhaitez d�poser incluant le \'http://\'. Cette image sera diffus�e avec votre lien du site web.<br>P.ex.: http://your-domain.com/path/to/your/image.gif <br><br><b>Nom complet:</b> Votre nom complet.<br><br><b>e-mail:</b> Votre adresse e-mail. Veuillez enregistrer une adresse e-mail valide comme vous serez tenu inform� par e-mail.<br><br><b>Page r�ciproque:</b> Votre URL absolu de votre page liens, o� un lien avec notre site web sera enregistr�.<br>P.ex.: http://your-domain.com/path/to/your/links_page.php';
$aLang['text_close_window'] = '<u>Fermer la fen�tre</u> [x]';

// VJ todo - move to common language file
$aLang['category_website'] = 'D�tails du site web';
$aLang['category_reciprocal'] = 'D�tails de la page r�ciproque';

$aLang['entry_links_title'] = 'Titre du site:';
$aLang['entry_links_title_error'] = 'Le lien au titre doit au minimum compter ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' Lettres.';
$aLang['entry_links_title_text'] = '*';
$aLang['entry_links_url'] = 'URL:';
$aLang['entry_links_url_error'] = 'L\'URL doit au minimum compter ' . ENTRY_LINKS_URL_MIN_LENGTH . ' Lettres.';
$aLang['entry_links_url_text'] = '*';
$aLang['entry_links_category'] = 'Cat�gorie:';
$aLang['entry_links_category_text'] = '*';
$aLang['entry_links_description'] = 'Description:';
$aLang['entry_links_description_error'] = 'La description doit au minimum compter ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' lettres.';
$aLang['entry_links_description_text'] = '*';
$aLang['entry_links_image'] = 'Image URL:';
$aLang['entry_links_image_text'] = '';
$aLang['entry_links_contact_name'] = 'Nom complet:';
$aLang['entry_links_contact_name_error'] = 'Votre nom complet doit au minimum compter ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' lettres.';
$aLang['entry_links_contact_name_text'] = '*';
$aLang['entry_links_reciprocal_url'] = 'Page r�ciproque:';
$aLang['entry_links_reciprocal_url_error'] = 'La page r�ciproque doit au minimum compter ' . ENTRY_LINKS_URL_MIN_LENGTH . ' lettres.';
$aLang['entry_links_reciprocal_url_text'] = '*';
?>
