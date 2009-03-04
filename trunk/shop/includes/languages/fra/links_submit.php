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

$aLang['text_main'] = 'Nous vous prions de bien vouloir remplir ce formulaire afin de déposer votre site web.';

$aLang['email_subject'] = 'Bienvenue chez ' . STORE_NAME . ' Échange de liens.';
$aLang['email_greet_none'] = 'Cher / Chère %s' . "\n\n";
$aLang['email_welcome'] = 'Nous vous souhaitons la bienvenue <b>' . STORE_NAME . '</b> à notre programme lien d\'échange.' . "\n\n";
$aLang['email_text'] = 'Votre lien a été déposé avec succès auprès de ' . STORE_NAME . '. Il sera ajouté à notre liste dès que nous l\'approuvons. Vous recevrez un message par e-mail concernant le statut de votre soumission. Etant donné le cas où vous ne l\'aurez pas reçu dans les 48h, nous vous prions de bien vouloir nous contacter avant de le renvoyer de nouveau.' . "\n\n";
$aLang['email_contact'] = 'N\'hésitez pas à nous contacter par e-mail, si vous avez besoin d\'une assistance concernant le programme échange de liens: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n";
$aLang['email_warning'] = '<b>Note:</b> Cette adresse e-mail nous a été transmise pendant la soumission du lien. Veuillez en cas de problèmes nous envoyer un e-mail à ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n";
$aLang['email_owner_subject'] = 'Lien vers soumission ' . STORE_NAME;
$aLang['email_owner_text'] = 'Un nouveau lien a été déposé chez ' . STORE_NAME . '. Il n\'a pas été approuvé. Veuillez s\'il vous plaît vérifier ce lien et l\'activer.' . "\n\n";

$aLang['text_links_help_link'] = '&nbsp;Help&nbsp;[?]';

$aLang['heading_links_help'] = 'Aide liens';
$aLang['text_links_help'] = '<b>Titre de la page:</b> Un titre descriptif pour votre site web.<br><br><b>URL:</b> L\'adresse Web absolue de votre site web incluant la \'http://\'.<br><br><b>Catégorie:</b> La catégorie la plus corrélative sous laquelle votre site web peut être classé.<br><br><b>Description:</b> Une brève description de votre site.<br><br><b>Image URL:</b> L\'URL absolu de l\'image que vous souhaitez déposer incluant le \'http://\'. Cette image sera diffusée avec votre lien du site web.<br>P.ex.: http://your-domain.com/path/to/your/image.gif <br><br><b>Nom complet:</b> Votre nom complet.<br><br><b>e-mail:</b> Votre adresse e-mail. Veuillez enregistrer une adresse e-mail valide comme vous serez tenu informé par e-mail.<br><br><b>Page réciproque:</b> Votre URL absolu de votre page liens, où un lien avec notre site web sera enregistré.<br>P.ex.: http://your-domain.com/path/to/your/links_page.php';
$aLang['text_close_window'] = '<u>Fermer la fenêtre</u> [x]';

// VJ todo - move to common language file
$aLang['category_website'] = 'Détails du site web';
$aLang['category_reciprocal'] = 'Détails de la page réciproque';

$aLang['entry_links_title'] = 'Titre du site:';
$aLang['entry_links_title_error'] = 'Le lien au titre doit au minimum compter ' . ENTRY_LINKS_TITLE_MIN_LENGTH . ' Lettres.';
$aLang['entry_links_title_text'] = '*';
$aLang['entry_links_url'] = 'URL:';
$aLang['entry_links_url_error'] = 'L\'URL doit au minimum compter ' . ENTRY_LINKS_URL_MIN_LENGTH . ' Lettres.';
$aLang['entry_links_url_text'] = '*';
$aLang['entry_links_category'] = 'Catégorie:';
$aLang['entry_links_category_text'] = '*';
$aLang['entry_links_description'] = 'Description:';
$aLang['entry_links_description_error'] = 'La description doit au minimum compter ' . ENTRY_LINKS_DESCRIPTION_MIN_LENGTH . ' lettres.';
$aLang['entry_links_description_text'] = '*';
$aLang['entry_links_image'] = 'Image URL:';
$aLang['entry_links_image_text'] = '';
$aLang['entry_links_contact_name'] = 'Nom complet:';
$aLang['entry_links_contact_name_error'] = 'Votre nom complet doit au minimum compter ' . ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH . ' lettres.';
$aLang['entry_links_contact_name_text'] = '*';
$aLang['entry_links_reciprocal_url'] = 'Page réciproque:';
$aLang['entry_links_reciprocal_url_error'] = 'La page réciproque doit au minimum compter ' . ENTRY_LINKS_URL_MIN_LENGTH . ' lettres.';
$aLang['entry_links_reciprocal_url_text'] = '*';
?>
