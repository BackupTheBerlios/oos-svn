<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_process.php,v 1.15 2003/02/16 00:42:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Créer un compte';
$aLang['navbar_title_2'] = 'Traitement';
$aLang['heading_title'] = 'Informations par rapport à votre compte client';

$aLang['email_subject'] = 'Bienvenue chez ' . STORE_NAME;
$aLang['email_greet_mr'] = 'Monsieur ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_ms'] = 'Madame ' . stripslashes($lastname) . ',' . "\n\n";
$aLang['email_greet_none'] = 'Madame, Monsieur ' . stripslashes($firstname) . ',' . "\n\n";
$aLang['email_welcome'] = 'Bienvenue chez <b>' . STORE_NAME . '</b>.' . "\n\n";
$aLang['email_text'] = 'Vous pouvez maintenant utiliser notre <b>service en ligne</b>. Le service vous offre en autres:' . "\n\n" . '<li><b>Panier</b> - Chaque article reste enregistré jusqu\'à ce que vous vous adressez à la caisse ou le supprimez du panier.' . "\n" . '<li><b>Répertoire d\'adresses</b> - Vous pouvez maintenant envoyer les articles à l\'adresse choisie. La voie parfaite pour envoyer un cadeau d\'anniversaire.' . "\n" . '<li><b>Commandes antérieures</b> - Vous pouvez à tout moment vérifier vos commandes antérieures.' . "\n" . '<li><b>Opinions par rapport aux articles</b> - Notifiez à d\'autres clients votre opinion à propos de nos articles.' . "\n\n";
$aLang['email_contact'] = 'N\'hésitez pas à nous contacter en cas de questions relatives à notre service client: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n";
$aLang['email_warning'] = '<b>Attention:</b> Cette adresse e-mail nous a été communiquée par un client. Si vous ne vous êtes pas inscrit, veuillez s\'il vous plaît nous envoyer un e-mail à ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n";

$aLang['email_gv_incentive_header'] = 'Nous vous avons envoyé un bon de %s pour vous souhaiter la bienvenue comme nouveau client.';
$aLang['email_gv_redeem'] = 'Le code du bon est: %s. Vous pouvez le saisir à la fin de votre commande';
$aLang['email_gv_link'] = 'Ou bien utilisez le lien suivant: ';
$aLang['email_coupon_incentive_header'] = 'Meilleures félicitations! Nous vous faisons parvenir ce bon, afin de rendre la première visite dans notre boutique encore plus attractive!' . "\n" .
                                         'De détails ultérieurs concernant votre bon d\'achat personnel suivent.' . "\n\n";
$aLang['email_coupon_redeem'] = 'Indiquez s\'il vous plaît à la fin du processus de commande le code du bon %s ' . "\n" .
                               'afin d\'utiliser votre bon d\'achat!';
                               
$aLang['email_password'] = 'Votre mot de passe pour \'' . STORE_NAME . '\' est:' . "\n\n" . '   %s' . "\n\n";
 

$aLang['email_disclaimer'] = '' . "\n" .
                            'Votre sphère privée:' . "\n\n" .
                            'Nous nous engageons à en aucun cas transmettre vos données (nom, e-mail etc.) à des tiers' . "\n" .
                            'à des tiers, exclu est cependant la situation de contrainte juridique' . "\n" .
                            'Une transmission n\'aurait aucun intérêt ni pour vous ni pour nous et nous la considérerons comme illégitime' . "\n" .
                            'Sachez pourtant que votre nom et adresse e-mail' . "\n" .
                            'sont visibles à tous qui lisent vos inscriptions sous ' . oos_server_get_base_url() . "\n" .
                            'La communication et l\'inscription en toile se fait souvent sous forme' . "\n" .
                            'non-cryptographique, ce qui a comme conséquence que d\'autres utilisateurs pourraient éventuellement' . "\n" .
                            'visualiser votre login et votre mot de passe. Nous vous conseillons pour des raisons sécuritaires ' . "\n" .
                            'd\'utiliser une autre combinaison de mot de passe pour cet accès ' . oos_server_get_base_url() . ' que celle' . "\n" .
                            'qui donne par exemple l\'accès à votre ordinateur' . "\n" .
                            'personnel.' . "\n\n" .
                            'Cordialement' . "\n" .
                            'Team Lensvision';


$aLang['owner_email_subject'] = 'Nouveau client';
$aLang['owner_email_date'] = 'Date:';
$aLang['owner_email_company_info'] = 'Données d\'entreprise';
$aLang['owner_email_contact'] = 'Données de contact';
$aLang['owner_email_options'] = 'Options';
$aLang['owner_email_company'] = 'Raison sociale:';
$aLang['owner_email_owner'] = 'Titulaire:';
$aLang['owner_email_number'] = 'Numéro de client:';
$aLang['owner_email_gender'] = 'Titre:';
$aLang['owner_email_first_name'] = 'Prénom:';
$aLang['owner_email_last_name'] = 'Nom:';
$aLang['owner_email_date_of_birth'] = 'Date de naissance:';
$aLang['owner_email_address'] = 'Adresse e-mail:';
$aLang['owner_email_street'] = 'Rue / No:';
$aLang['owner_email_suburb'] = 'Quartier:';
$aLang['owner_email_post_code'] = 'Code postale:';
$aLang['owner_email_city'] = 'Lieu:';
$aLang['owner_email_state'] = 'Land:';
$aLang['owner_email_country'] = 'Pays:';
$aLang['owner_email_telephone_number'] = 'Numéro de téléphone:';
$aLang['owner_email_fax_number'] = 'Numéro de téléfax:';
$aLang['owner_email_newsletter'] = 'Bulletin d\'information:';
$aLang['owner_email_newsletter_yes'] = 'abonné';
$aLang['owner_email_newsletter_no'] = 'pas abonné';
$aLang['email_separator'] = '------------------------------------------------------';

?>
