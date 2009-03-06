<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: german.php,v 1.116 2003/02/17 11:49:26 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to 
      lang@oos-shop.de 
   the translated file. 
   ---------------------------------------------------------------------- */

 /**
  * look in your $PATH_LOCALE/locale directory for available locales..
  * on RedHat try 'fr_FR'
  * on FreeBSD try 'fr_FR.ISO_8859-1'
  * on Windows try 'fr' or 'French'
  */
  @setlocale(LC_TIME, 'fr_FR');
  define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
  define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
  define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
  define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
  define('DATE_TIME_FORMAT_SHORT', '%H:%M:%S');


 /**
  * Return date in raw format
  * $date should be in format mm/dd/yyyy
  * raw date is in format YYYYMMDD, or DDMMYYYY
  *
  * @param $date
  * @param $reverse
  * @return string
  */
  function oos_date_raw($date, $reverse = false) {
    if ($reverse) {
      return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
    } else {
      return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'EUR');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="LTR" lang="fr"');
define('XML_PARAMS','xml:lang="fr" lang="fr"');

// charset for web pages and emails
define('CHARSET', 'iso-8859-15');

//text in oos_temp/templates/oos/system/user_navigation.html
$aLang['header_title_create_account'] = 'Nouveau compte';
$aLang['header_title_my_account'] = 'Mon compte';
$aLang['header_title_cart_contents'] = 'Panier';
$aLang['header_title_checkout'] = 'Caisse';
$aLang['header_title_top'] = 'Page d\'accueil';
$aLang['header_title_catalog'] = 'Catalogue';
$aLang['header_title_logoff'] = 'Annuler';
$aLang['header_title_login'] = 'Connecter';
$aLang['header_title_whats_new'] = 'Nouveaux articles';

$aLang['block_heading_specials'] = 'Offres';

// footer text in includes/oos_footer.php
$aLang['footer_text_requests_since'] = 'Accès depuis';

// text for gender
$aLang['male'] = 'Monsieur';
$aLang['female'] = 'Madame';
$aLang['male_address'] = 'Monsieur';
$aLang['female_address'] = 'Madame';

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');
$aLang['dob_format_string'] = 'jj.mm.aaaa';

// search block text in tempalate/your theme/block/search.html
$aLang['block_search_text'] = 'Veuillez utiliser des mots clés afin de retrouver un article.';
$aLang['block_search_advanced_search'] = 'Recherche avancée';
$aLang['text_search'] = 'Rechercher...';

// reviews block text in tempalate/your theme/block/reviews.php
$aLang['block_reviews_write_review'] = 'Veuillez évaluer cet article!';
$aLang['block_reviews_no_reviews'] = 'Il n\'y a pas encore d\'évaluations disponibles';
$aLang['block_reviews_text_of_5_stars'] = '%s sur 5 étoiles!';

// shopping_cart block text in tempalate/your theme/block/shopping_cart.html
$aLang['block_shopping_cart_empty'] = '0 articles';

// notifications block text in tempalate/your theme/block/products_notifications.php
$aLang['block_notifications_notify'] = 'Veuillez me contacter à propos d\'actualités de l\'article <b>%s</b>';
$aLang['block_notifications_notify_remove'] = 'Ne me contactez plus par rapport à l\'article <b>%s</b>';

// wishlist block text in tempalate/your theme/block/wishlist.html
$aLang['block_wishlist_empty'] = 'Vous n\'avez aucun article dans votre liste de cadeaux';

// manufacturer box text
$aLang['block_manufacturer_info_homepage'] = '%s Page d\'accueil';
$aLang['block_manufacturer_info_other_products'] = 'Plus d\'articles';

$aLang['block_add_product_id_text'] = 'Saisie du numéro de commande.';

// information block text in tempalate/your theme/block/information.html
$aLang['block_information_imprint'] = 'Impression';
$aLang['block_information_privacy'] = 'Sphère privée et protection des données';
$aLang['block_information_conditions'] = 'Nos CGV (conditions générales de ventes)';
$aLang['block_information_shipping'] = 'Coûts de livraison et frais de port';
$aLang['block_information_contact'] = 'Contact';
$aLang['block_information_v_card'] = 'Carte visa';
$aLang['block_information_mapquest'] = 'Map This Location';
$aLang['block_skype_me'] = 'Skype Me';
$aLang['block_information_gv'] = 'Encaisser le bon';
$aLang['block_information_gallery'] = 'Gallery';

//service
$aLang['block_service_links'] = 'Liens site web';
$aLang['block_service_newsfeed'] = 'RDS/RSS Newsfeed';
$aLang['block_service_gv'] = 'Encaisser le bon';
$aLang['block_service_sitemap'] = 'Plan du site';

//login 
$aLang['entry_email_address'] = 'Adresse e-mail:';
$aLang['entry_password'] = 'Mot de passe:';
$aLang['text_password_info'] = 'Avez-vous oublié le mot de passe?';
$aLang['image_button_login'] = 'Login';
$aLang['login_block_new_customer'] = 'Nouveau client';
$aLang['login_block_account_edit'] = 'Modifier les données';
$aLang['login_block_account_history'] = 'Aperçu de commande';
$aLang['login_block_order_history'] = 'Order History';
$aLang['login_block_address_book'] = 'Répertoire d\'adresses';
$aLang['login_block_product_notifications'] = 'Informations';
$aLang['login_block_my_account'] = 'Données personnelles';
$aLang['login_block_logoff'] = 'Annuler';
$aLang['login_entry_remember_me'] = 'Automatique de connection';

// tell a friend block text in tempalate/your theme/block/tell_a_friend.html
$aLang['block_tell_a_friend_text'] = 'Recommandez cet article simplement par e-mail.';

// checkout procedure text
$aLang['checkout_bar_delivery'] = 'Informations d\'envoi';
$aLang['checkout_bar_payment'] = 'Forme de paiement';
$aLang['checkout_bar_confirmation'] = 'Confirmation';
$aLang['checkout_bar_finished'] = 'Terminé!';

// pull down default text
$aLang['pull_down_default'] = 'Veuillez choisir';
$aLang['type_below'] = 'Remplir en bas s.v.p.';

//newsletter
$aLang['block_newsletters_subscribe'] = 'Enregistrer';
$aLang['block_newsletters_unsubscribe'] = 'Se déconnecter';

//myworld
$aLang['text_date_account_created'] = 'Account Created:';
$aLang['text_yourstore'] = 'Your Participation';
$aLang['edit_yourimage'] = 'Your Image';

// javascript messages
$aLang['js_error'] = 'Des données indispensables manquent!\nVeuillez remplir correctement.\n\n';

$aLang['js_review_text'] = '* Le texte doit au minimum consister en ' . REVIEW_TEXT_MIN_LENGTH . ' lettres.\n';
$aLang['js_review_rating'] = '* Veuillez enregistrer votre évaluation.\n';

$aLang['js_gender'] = '* Définir le titre.\n';
$aLang['js_first_name'] = '* Le \'prénom\' doit au minium consister en ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' lettres.\n';
$aLang['js_last_name'] = '* Le \'nom\' doit au minimum consister en ' . ENTRY_LAST_NAME_MIN_LENGTH . ' lettres.\n';
$aLang['js_dob'] = '* Veuillez indiquer \'les dates de naissance\' selon le format xx.xx.xxxx (Jour.Mois.Année).\n';
$aLang['js_email_address'] = '* L\' \'adresse e-mail\' doit au minimum consister en ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' lettres.\n';
$aLang['js_address'] = '* La \'rue/no\' doit au minimum consister en ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' lettres.\n';
$aLang['js_post_code'] = '* Le \'code postale\' doit au minimum consister en ' . ENTRY_POSTCODE_MIN_LENGTH . ' chiffres.\n';
$aLang['js_city'] = '* La \'ville\' doit au minimum consister en ' . ENTRY_CITY_MIN_LENGTH . ' lettres.\n';
$aLang['js_state'] = '* Le \'land\' doit être choisi.\n';
$aLang['js_country'] = '* Le \'pays\' doit être choisi.\n';
$aLang['js_telephone'] = '* Le \'numéro de téléphone\' doit au minimum consister en ' . ENTRY_TELEPHONE_MIN_LENGTH . ' chiffres.\n';
$aLang['js_password'] = '* Le \'mot de passe\' et la \'confirmation\' doivent correspondre et au minimum consister en ' . ENTRY_PASSWORD_MIN_LENGTH . ' lettres.\n';

$aLang['js_error_no_payment_module_selected'] = '* Veuillez choisir une forme de paiement pour votre commande.\n';
$aLang['js_error_submitted'] = 'Cette page a déjà été confirmée. Veuillez appuyer sur OK puis attendez jusqu\'à ce que le processus soit exécuté.';

$aLang['error_no_payment_module_selected'] = 'Veuillez choisir une forme de paiement pour votre commande.';
$aLang['error_conditions_not_accepted'] = 'Dans la mesure où vous n\'acceptez pas nos CGV, nous ne pourrons malheureusement pas recevoir votre commande!';

$aLang['category_company'] = 'Données d\'entreprise';
$aLang['category_personal'] = 'Vos données personnelles';
$aLang['category_address'] = 'Votre adresse';
$aLang['category_contact'] = 'Vos informations de contact';
$aLang['category_options'] = 'Options';
$aLang['category_password'] = 'Votre mot de passe';
$aLang['entry_company'] = 'Raison sociale:';
$aLang['entry_company_error'] = '';
$aLang['entry_company_text'] = '';
$aLang['entry_owner'] = 'Propriétaire';
$aLang['entry_owner_error'] = '';
$aLang['entry_owner_text'] = '';
$aLang['entry_vat_id'] = 'VAT ID';
$aLang['entry_vat_id_error'] = 'The chosen VatID is not valid or not proofable at this moment! Please fill in a valid ID or leave the field empty.';
$aLang['entry_vat_id_text'] = '* for Germany and EU-Countries only';
$aLang['entry_number'] = 'Numéro de client';
$aLang['entry_number_error'] = '';
$aLang['entry_number_text'] = '';
$aLang['entry_gender'] = 'Titre:';
$aLang['entry_gender_error'] = '&nbsp;<small><font color="#AABBDD">require_onced</font></small>';

$aLang['entry_first_name'] = 'Prénom:';
$aLang['entry_first_name_error'] = 'Au minimum ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' lettres';
$aLang['entry_last_name'] = 'Nom:';
$aLang['entry_last_name_error'] = 'Au minimum ' . ENTRY_LAST_NAME_MIN_LENGTH . ' lettres';
$aLang['entry_date_of_birth'] = 'Date de naissance:';
$aLang['entry_date_of_birth_text'] = '(P. ex. 21.05.1970)';
$aLang['entry_email_address'] = 'Adresse e-mail:';
$aLang['entry_email_address_error'] = 'Au minimum ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' lettres';
$aLang['entry_email_address_check_error'] = 'Adresse e-mail invalide!';
$aLang['entry_email_address_error_exists'] = 'Cette adresse e-mail existe déjà!';
$aLang['entry_street_address'] = 'Rue/No:';
$aLang['entry_street_address_error'] = 'Au minimum ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' lettres';

$aLang['entry_suburb'] = 'Quartier:';
$aLang['entry_suburb_error'] = '';
$aLang['entry_suburb_text'] = '';
$aLang['entry_post_code'] = 'Code postale:';
$aLang['entry_post_code_error'] = 'Au minimum ' . ENTRY_POSTCODE_MIN_LENGTH . ' chiffres';
$aLang['entry_city'] = 'lieu:';
$aLang['entry_city_error'] = 'Au minimum ' . ENTRY_CITY_MIN_LENGTH . ' lettres';
$aLang['entry_state'] = 'Land:';
$aLang['entry_country'] = 'Pays:';
$aLang['entry_country_error'] = '';
$aLang['entry_telephone_number'] = 'Numéro de téléphone:';
$aLang['entry_telephone_number_error'] = 'Au minimum ' . ENTRY_TELEPHONE_MIN_LENGTH . ' chiffres';
$aLang['entry_fax_number'] = 'Numéro de téléfax:';
$aLang['entry_fax_number_error'] = '';
$aLang['entry_fax_number_text'] = '';
$aLang['entry_newsletter'] = 'Bulletin d\'information:';
$aLang['entry_newsletter_text'] = '';
$aLang['entry_newsletter_yes'] = 'Abonné';
$aLang['entry_newsletter_no'] = 'Ne pas abonné';
$aLang['entry_newsletter_error'] = '';
$aLang['entry_password'] = 'Mot de passe:';
$aLang['entry_password_confirmation'] = 'Confirmation:';
$aLang['entry_password_error'] = 'Au minimum ' . ENTRY_PASSWORD_MIN_LENGTH . ' Lettres';
$aLang['password_hidden'] = '--CACHÉ--';
$aLang['entry_info_text'] = 'Saisie indispensable';


// constants for use in oos_prev_next_display function
$aLang['text_result_page'] = 'Pages:';
$aLang['text_display_number_of_products'] = 'Articles affichés: <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';
$aLang['text_display_number_of_orders'] = 'Commandes affichées: <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';
$aLang['text_display_number_of_reviews'] = 'Opinions affichées: <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';
$aLang['text_display_number_of_products_new'] = 'Nouveaux articles affichées: <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';
$aLang['text_display_number_of_specials'] = 'Offres affichées <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';
$aLang['text_display_number_of_wishlist'] = 'Articles désirés et affichés <b>%d</b> jusqu\'à <b>%d</b> (de <b>%d</b> au total)';

$aLang['prevnext_title_first_page'] = 'Première page';
$aLang['prevnext_title_previous_page'] = 'Page précédente';
$aLang['prevnext_title_next_page'] = 'Page suivante';
$aLang['prevnext_title_last_page'] = 'Page finale';
$aLang['prevnext_title_page_no'] = 'Page %d';
$aLang['prevnext_title_prev_set_of_no_page'] = 'Pages %d prcédentes';
$aLang['prevnext_title_next_set_of_no_page'] = 'Pages %d suivantes';
$aLang['prevnext_button_first'] = '&lt;&lt;PREMIÈRE';
$aLang['prevnext_button_prev'] = '&lt;&lt;&nbsp;précédente';
$aLang['prevnext_button_next'] = 'suivante&nbsp;&gt;&gt;';
$aLang['prevnext_button_last'] = 'FINALE&gt;&gt;';

$aLang['image_button_add_address'] = 'Nouvelle adresse';
$aLang['image_button_address_book'] = 'Répertoire d\'adresses';
$aLang['image_button_back'] = 'Retour';
$aLang['image_button_change_address'] = 'Changement d\'adresse';
$aLang['image_button_checkout'] = 'Caisse';
$aLang['image_button_confirm_order'] = 'Confirmer la commande';
$aLang['image_button_continue'] = 'Suivant';
$aLang['image_button_continue_shopping'] = 'Procéder avec l\'achat';
$aLang['image_button_delete'] = 'Supprimer';
$aLang['image_button_edit_account'] = 'Modifier les données';
$aLang['image_button_history'] = 'Aperçu de commande';
$aLang['image_button_login'] = 'S\'inscrire';
$aLang['image_button_in_cart'] = 'Ajouter au panier';
$aLang['image_button_notifications'] = 'Notifications';
$aLang['image_button_quick_find'] = 'Recherche rapide';
$aLang['image_button_remove_notifications'] = 'Supprimer les notifications';
$aLang['image_button_reviews'] = 'Évaluations';
$aLang['image_button_search'] = 'Rechercher';
$aLang['image_button_tell_a_friend'] = 'Recommander';
$aLang['image_button_update'] = 'Actualiser';
$aLang['image_button_update_cart'] = 'Actualiser le panier';
$aLang['image_button_write_review'] = 'Rédiger une évaluation';
$aLang['image_button_add_quick'] = 'Achat rapid!';
$aLang['image_wishlist_delete'] = 'Supprimer';
$aLang['image_button_in_wishlist'] = 'Liste des produits désirés';
$aLang['image_button_add_wishlist'] = 'Liste des produits désirés';
$aLang['image_button_redeem_voucher'] = 'Encaisser le bon';

$aLang['image_button_hp_buy'] = 'Ajouter au panier';
$aLang['image_button_hp_more'] = 'Afficher plus';

$aLang['icon_button_mail'] = 'E-mail';
$aLang['icon_button_pdf'] = 'PDF';
$aLang['icon_button_print'] = 'Imprimer';

$aLang['icon_arrow_right'] = 'Afficher plus';
$aLang['icon_cart'] = 'Ajouter au panier';
$aLang['icon_warning'] = 'Avertissement';

$aLang['text_greeting_personal'] = 'Quel plaisir de vous accueillir de nouveau %s. Souhaitez-vous <a href="%s"><u>visionner</u></a> les nouveaux articles?';
$aLang['text_greeting_guest'] = 'Bienvenue. Souhaitez-vous vous <a href="%s"><u>connecter</u></a>? ou désirez-vous <a href="%s"><u>créer</u></a> un compte client?';

$aLang['text_sort_products'] = 'Le tirage des articles est ';
$aLang['text_descendingly'] = 'descendant';
$aLang['text_ascendingly'] = 'ascendant';
$aLang['text_by'] = ' selon ';

$aLang['text_review_by'] = 'de %s';
$aLang['text_review_word_count'] = '%s mots';
$aLang['text_review_rating'] = 'Évaluation:';
$aLang['text_review_date_added'] = 'Date ajoutée: ';
$aLang['text_no_reviews'] = 'Il n\'y a pas encore d\'évaluations faites.';
$aLang['text_no_new_products'] = 'Il n\'y a actuellement pas de nouveaux articles.';
$aLang['text_unknown_tax_rate'] = 'Taux fiscal inconnu';
$aLang['text_required'] = 'Indispensable';
$aLang['error_oos_mail'] = '<small>ERREUR:</small> L\'e-mail ne peut pas être envoyée par le SMTP-Serveur indiqué. Veuillez s\'il vous plaît vérifier les données dans le fichier php.ini pour ensuite effectuer les corrections nécessaires!';

$aLang['warning_install_directory_exists'] = 'Avertissement: le répertoire d\'installation n\'existe pas encore sur: ' . dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/install. Veuillez supprimer le répertoire pour des raisons sécuritaires!';
$aLang['warning_config_file_writeable'] = 'Avertissement: OOS [OSIS Online Shop] peut rédiger dans le fichier de configuration: ' . dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/includes/config.php. Ceci signifie un risque sécuritaire - veuillez corriger les autorisations d\'utilisateur pour ce ficher!';
$aLang['warning_session_auto_start'] = 'Avertissement: Veuillez désactiver cette caractéristique PHP dans php.ini et redémarrez le serveur WEB!';
$aLang['warning_download_directory_non_existent'] = 'Avertissement: Le répertoire pour le téléchargement de l\'article n\'existe pas: ' . OOS_DOWNLOAD_PATH . '. Cette fonction ne sera pas opérationnelle avant que le répertoire soit crée!';
$aLang['warning_session_directory_non_existent'] = 'Avertissement: Le répertoire n\'existe pas pour les sessions: ' . oos_session_save_path() . '. Les sessions ne seront pas opérationnelles avant que le répertoire soit crée!';
$aLang['warning_session_directory_not_writeable'] = 'Avertissement: OOS [OSIS Online Shop] ne peut pas rédiger dans le répertoire des sessions: ' . oos_session_save_path() . '. Les sessions ne seront pas opérationnelles avant que les autorisations d\'utilisateur correctes soient enregistrées!';

$aLang['text_ccval_error_invalid_date'] = 'La date "valable jusque" est nulle.<br>Veuillez corriger vos saisies.';
$aLang['text_ccval_error_invalid_number'] = 'Le "numéro de carte de crédit" que vous avez indiqué est invalide.<br>Veuillez corriger vos données.';
$aLang['text_ccval_error_unknown_card'] = 'Les premiers quatre chiffres de votre carte de crédit sont: %s<br>Si ces données concordent, ce type de carte ne peut malheureusement pas être accepté.<br>Veuillez corriger vos données dans le cas échéant.';

$aLang['voucher_balance'] = 'Bon - Avoir';
$aLang['gv_faq'] = 'Bon FAQ';
$aLang['error_redeemed_amount'] = 'Parfait: La valeur d\'encaissement vous a été créditée au compte client! ';
$aLang['error_no_redeem_code'] = 'Vous n\'avez enregistré aucun code pour le bon!';  
$aLang['error_no_invalid_redeem_gv'] = 'Erreur: Vous n\'avez enregistré aucun code valable pour le bon!'; 
$aLang['table_heading_credit'] = 'Avoir';
$aLang['gv_has_vouchera'] = 'Vous avez un bon - Avoir sur votre compte client. Souhaitez-vous <br>une partie de votre avoir par';
$aLang['gv_has_voucherb'] = 'envoyer?'; 
$aLang['entry_amount_check_error'] = '&nbsp;<small><font color="#FF0000">Il n\'y a malheureusement pas de couverture suffisante sur votre compte client!</font></smal>'; 
$aLang['gv_send_to_friend'] = 'Envoyer le bon';

$aLang['voucher_redeemed'] = 'Justificatif Redeemed';
$aLang['cart_coupon'] = 'Coupon :';
$aLang['cart_coupon_info'] = 'Plus d\'informations';

$aLang['block_affiliate_info'] = 'Informations';
$aLang['block_affiliate_summary'] = 'Aperçu compte partenaire';
$aLang['block_affiliate_account'] = 'Modifier compte partenaire';
$aLang['block_affiliate_clickrate'] = 'Aperçu clics';
$aLang['block_affiliate_payment'] = 'Versements à provision';
$aLang['block_affiliate_sales'] = 'Aperçu ventes';
$aLang['block_affiliate_banners'] = 'Banniére';
$aLang['block_affiliate_contact'] = 'Contact';
$aLang['block_affiliate_faq'] = 'FAQ';
$aLang['block_affiliate_login'] = 'Inscription';
$aLang['block_affiliate_logout'] = 'Annuler';

$aLang['entry_affiliate_payment_details'] = 'Payable à:';
$aLang['entry_affiliate_accept_agb'] = 'Veuillez confirmer que vous soyez <a target="_new" href="' . oos_href_link($aModules['affiliate'], $aFilename['affiliate_terms'], '', 'SSL') . '">(avec nos CVG)\'s</a> d\'accord.';
$aLang['entry_affiliate_agb_error'] = '&nbsp;<small><font color="#FF0000">Vous devez reconnaître nos CGV.</font></small>';
$aLang['entry_affiliate_payment_check'] = 'Bénéficiaire du chèque:';
$aLang['entry_affiliate_payment_check_text'] = '';
$aLang['entry_affiliate_payment_check_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_paypal'] = 'Compte e-mail PayPal:';
$aLang['entry_affiliate_payment_paypal_text'] = '';
$aLang['entry_affiliate_payment_paypal_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_bank_name'] = 'Établissement de crédit:';
$aLang['entry_affiliate_payment_bank_name_text'] = '';
$aLang['entry_affiliate_payment_bank_name_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_bank_account_name'] = 'Titulaire du compte:';
$aLang['entry_affiliate_payment_bank_account_name_text'] = '';
$aLang['entry_affiliate_payment_bank_account_name_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_bank_account_number'] = 'Numéro de compte:';
$aLang['entry_affiliate_payment_bank_account_number_text'] = '';
$aLang['entry_affiliate_payment_bank_account_number_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_bank_branch_number'] = 'Code de banque:';
$aLang['entry_affiliate_payment_bank_branch_number_text'] = '';
$aLang['entry_affiliate_payment_bank_branch_number_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_payment_bank_swift_code'] = 'SWIFT Code:';
$aLang['entry_affiliate_payment_bank_swift_code_text'] = '';
$aLang['entry_affiliate_payment_bank_swift_code_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_company'] = 'Entreprise';
$aLang['entry_affiliate_company_text'] = '';
$aLang['entry_affiliate_company_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_company_taxid'] = 'Numéro d\'identification de T.V.A:';
$aLang['entry_affiliate_company_taxid_text'] = '';
$aLang['entry_affiliate_company_taxid_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire</font></small>';
$aLang['entry_affiliate_homepage'] = 'Page d\'accueil';

$aLang['entry_affiliate_homepage_text'] = '&nbsp;<small><font color="#000000"> (http://)</font></small>';
$aLang['entry_affiliate_homepage_error'] = '&nbsp;<small><font color="#FF0000">Nécessaire(http://)</font></small>';

$aLang['category_payment_details'] = 'Versement peut s\'effectuer par';

$aLang['block_ticket_generate'] = 'Demande de soutien';
$aLang['block_ticket_view'] = 'Voir ticket';

$aLang['down_for_maintenance_text'] = 'Pour la maintenance voir en bas ... Veuillez essayer de nouveau plus tard';
$aLang['down_for_maintenance_no_prices_display'] = 'En bas pour la maintenance';
$aLang['no_login_no_prices_display'] = 'Prix uniquement pour commerçants';
$aLang['text_products_base_price'] = 'Prix de base';

$aLang['products_see_qty_discounts'] = 'Prix dégressifs';
$aLang['products_order_qty_text'] = 'Quantité: ';
$aLang['products_order_qty_min_text'] = '<br />' . ' Quantité minimum de commande: ';
$aLang['products_order_qty_min_text_info'] = ' La quantité minimum de commande s\'élève à: ';
$aLang['products_order_qty_min_text_cart'] = ' La quantitÈ minimum de commande s\'élève à: ';
$aLang['products_order_qty_min_text_cart_short'] = 'Quantité minimale: ';

$aLang['products_order_qty_unit_text'] = ' Unité d\'emballage: ';
$aLang['products_order_qty_unit_text_info'] = 'Conditionnement par: ';
$aLang['products_order_qty_unit_text_cart'] = 'Conditionnement par: ';
$aLang['products_order_qty_unit_text_cart_short'] = ' Unité d\'emballage: ';

$aLang['error_products_quantity_order_min_text'] = '';
$aLang['error_products_quantity_invalid'] = 'Erreur: Quantité ';
$aLang['error_products_quantity_order_units_text'] = '';
$aLang['error_products_units_invalid'] = 'Erreur: Quantité ';

$aLang['error_destination_does_not_exist'] = 'Erreur: La destination n\'existe pas.';
$aLang['error_destination_not_writeable'] = 'Erreur: Il y a une faut d\'orthographe dans la destination.';
$aLang['error_file_not_saved'] = 'Erreur: Le téléchargement du fichier n\'a pas été enregistré.';
$aLang['error_filetype_not_allowed'] = 'Erreur: Ce type de téléchargement n\'est pas permis.';
$aLang['success_file_saved_successfully'] = 'Aboutissement: Le fichier a été sauvegardé avec succès.';
$aLang['warning_no_file_uploaded'] = 'Avertissement: Aucun fichier n\'a été téléchargé.';
$aLang['warning_file_uploads_disabled'] = 'Avertissement: Le téléchargement est désactivé dans le fichier de configuration php.ini.';


// 404 Email Error Report
$aLang['error404_email_subject'] = 'Rapport d\'erreur 404';
$aLang['error404_email_header'] = 'Message d\'erreur 404';
$aLang['error404_email_text'] = 'Un erreur de type 404 s\'est produit';
$aLang['error404_email_date'] = 'Date:';
$aLang['error404_email_uri'] = 'L\'URI erroné:';
$aLang['error404_email_ref'] = 'La page d\'accueil:';

$aLang['err404'] = 'Message d\'erreur 404';
$aLang['err404_page_not_found'] = 'La page recherchée n\'a pas pu être trouvé chez';
$aLang['err404_sorry'] = 'La page demandée';
$aLang['err404_doesntexist'] = 'N\'existe pas chez';
$aLang['err404_mailed'] = '<b>Des détails par rapport à l\'erreur ont automatiquement été envoyés au maître de réseau.</b>';
$aLang['err404_commonm'] = '<b>Erreurs typiques</b>';
$aLang['err404_commonh'] = 'Les conventions des noms n\'ont pas été respectées';
$aLang['err404_urlend'] = 'L\'URL indiquée se termine avec';
$aLang['err404_allpages'] = 'Toutes les pages chez';
$aLang['err404_endwith'] = 'se terminent avec';
$aLang['err404_uppercase'] = 'l\'utilisation de majuscules';
$aLang['err404_alllower'] = 'Tous les noms sont à écrire en minuscules';

$aLang['text_info_csname'] = 'Vous êtes membres du groupe de clients : ';
$aLang['text_info_csdiscount'] = 'Vous recevrez selon l\'article un rabais maximal de jusqu\'à : ';
$aLang['text_info_csotdiscount'] = 'Vous bénéficiez sur votre commande totale d\'un rabais de : ';
$aLang['text_info_csstaff'] = 'Vous êtes autorisés à bénéficier des prix dégressifs.';
$aLang['text_info_cspay'] = 'Vous pouvez utiliser les modes de paiement suivants : ';
$aLang['text_info_show_price_no'] = 'Vous n\'obtenez pas encore d\'informations de prix. Veuillez vous inscrire';
$aLang['text_info_show_price_with_tax_yes'] = 'Les prix comprennent la T.V.A.';
$aLang['text_info_show_price_with_tax_no'] = 'Les prix indiqués ne comprennent pas la T.V.A.';
$aLang['text_info_receive_mail_mode'] = 'Je souhaite recevoir des informations en format : ';
$aLang['entry_receive_mail_text'] = 'Texte uniquement';
$aLang['entry_receive_mail_html'] = 'HTML';
$aLang['entry_receive_mail_pdf'] = 'PDF';

$aLang['table_heading_price_unit'] = 'Par pièce net';
$aLang['table_heading_discount'] = 'Rabais';
$aLang['table_heading_ot_discount'] = 'Rabais forfaitaire';
$aLang['text_info_minimum_amount'] = 'Vous bénéficiez d\'un rabais forfaitaire dès le montant de la commande de';
$aLang['sub_title_ot_discount'] = 'Rabais forfaitaire:';
$aLang['text_new_customer_introduction_newsletter'] = 'Vous serez tenus au courant de toutes actualités en abonnant le bulletin d\'information de ' .  STORE_NAME . '';
$aLang['text_new_customer_ip'] = 'Ce compte a été crée par l\'IP de cet ordinateur : ';
$aLang['text_customer_account_password_security'] = 'Pour raisons de votre propre sécurité, nous ne sommes pas en mesure d\'avoir accès à votre mot de passe. Mais vous pouvez en demander un nouveau au cas où vous l\'avez oublié.';
$aLang['text_login_need_upgrade_csnewsletter'] = '<font color="#ff0000"><b>NOTE:</b></font>Vous avez déjà abonné le bulletin d\'information de &quot;Newsletter &quot;. Vous devez amender ce compte afin de pouvoir acheter.';

// use TimeBasedGreeting
$aLang['good_morning'] = 'Bonjour';
$aLang['good_afternoon'] = 'Bonjour';
$aLang['good_evening'] = 'Bonsoir';

$aLang['text_taxt_incl'] = 'T.V.A. obligatoire inclue';
$aLang['text_taxt_add'] = 'Plus T.V.A. obligatoire';
$aLang['tax_info_excl'] = 'exkl. Tax';
$aLang['text_shipping'] = 'Plus<a href="%s"><u>frais d\'expédition</u></a>.';

$aLang['price'] = 'Prix';
$aLang['price_from'] = 'from';
$aLang['price_info'] = 'Tous les prix par pièce en CHF ; T.V.A obligatoire incluse, plus <a href="' . oos_href_link($aModules['info'], $aFilename['information'], 'Information_id=1') . '">Frais </a> d\'expédition forfaitaires d\'uniquement 3.95... par commande.';
$aLang['support_info'] = 'Avez-vous encore des questions? Vous pouvez nous joindre par notre <a href="' . oos_href_link($aModules['ticket'], $aFilename['ticket_create']) . '">formulaire de contact</a>.';

?>
