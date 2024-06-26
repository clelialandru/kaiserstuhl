<?php

$language = $_SESSION['lang'] ; 

$translations = [];

// Chargement des traductions en fonction de la langue
switch ($language) {
    case 'fr':
        $translations = [
            'invalid_email_format' => 'Format de mail invalide',
            'email_missing' => 'Mail manquant',
            'password_missing' => 'Mot de passe manquant',
            'firstname_missing' => 'Prénom manquant',
            'name_missing' => 'Nom manquant',
            'check_password_missing' => 'Mot de passe de vérification manquant',
            'email_or_password_wrong' => 'Mail ou mot de passe incorrect',
            'registration_failed' => 'Inscription échouée',
            'invalid_password_format' => 'Veuillez inscrire un mot de passe valide',
            'check_password_different_password' => 'Mot de passe de vérification ne correspond pas à votre mot de passe',
            'bug_bbd' => 'Un problème est survenu dans la base de données',
            'send_request_revocation' => "Votre demande d'annulation a bien été envoyée",
            'revocation_failed' => "Annulation échouée",
            'invalid_tel_format' => "Format de téléphone invalide",
            'modification_succes'=> 'Modification réussie',
            'modification_failed' => "Modification échouée",

            'failed_get_aventure' => "Échec de l'affichage de l'aventure N°",
            'succes_revocation' => "La réservation a bien été annulée",
            'failed_revocation_admin' => "Suite à une erreur, la demande n'a pas pu être annulée",
            'succes_reject_revocation' => "La demande d'annulation a bien été rejetée",
            'failed_reject_revocation' => "Suite à une erreur, la demande n'a pas pu être rejetée",
            'failure_revocation_reservation' => "Échec de l'annulation de la réservation",
            'name_already_take' => 'Nom déjà pris',
            'detail_en_missing'=> "Détail en anglais manquant",
            'detail_fr_missing'=> "Détail en français manquant",
            'detail_de_missing'=> "Détail en allemand manquant",
            'history_en_missing' => "Histoire en anglais manquante",
            'history_fr_missing' => "Histoire en français manquante",
            'history_de_missing' => "Histoire en allemand manquante",
            'description_en_missing' => "Description en anglais manquante",
            'description_fr_missing' => "Description en français manquante",
            'description_de_missing' => "Description en allemand manquante",
            'info_lang_missing' => "Langue manquante",
            'info_en_emporter_missing' => "Information à emporter en anglais manquante",
            'info_fr_emporter_missing' => "Information à emporter en français manquante",
            'info_de_emporter_missing' => "Information à emporter en allemand manquante",
            'info_en_important_missing' => "Information importante en anglais manquante",
            'info_fr_important_missing' => "Information importante en français manquante",
            'info_de_important_missing' => "Information importante en allemand manquante",
            'failed_puzzle_lvl_format' => "Veuillez choisir une difficulté de puzzle correcte",
            'puzzle_lvl_missing'=> 'Difficulté de puzzle manquante',
            'failed_walk_lvl_format' => "Veuillez choisir une difficulté de marche",
            'walk_lvl_missing' => "Difficulté de marche manquante",
            'target_en_grp_missing' => "Information groupe cible en anglais manquante",
            'target_fr_grp_missing' => "Information groupe cible en français manquante",
            'target_de_grp_missing' => "Information groupe cible en allemand manquante",
            'train_en_bus_missing' => "Veuillez indiquer une station de moyen de transport en anglais",
            'train_fr_bus_missing' => "Veuillez indiquer une station de moyen de transport en français",
            'train_de_bus_missing' => "Veuillez indiquer une station de moyen de transport en allemand",
            'localisation_missing' => "Localisation manquante",
            'failed_latitude_format' => "Problème de format pour la latitude",
            'latitude_missing' => "Latitude manquante",
            'failed_longitude_format' => "Problème de format pour la longitude",
            'longitude_missing' => "Longitude manquante",
            'address_missing' => "Adresse manquante",
            'failed_price_format' => "Format de prix invalide",
            'price_missing' => "Prix manquant",
            'failed_duration_format' => "Format de durée invalide",
            'duration_missing' => "Durée de l'escape game manquante",
            'failed_parking_format' => "Problème de format pour le parking",
            'parking_missing' => "Parking manquant",
            'failed_accebilite_format' => "Problème de format pour l'accessibilité",
            'accebilite_missing' => "Accessibilité manquante",
            'photo_pp_lourd' => "La photo principale proposée est trop lourde (max 5 Mo)" ,
            'failed_send_photo_pp' => "Erreur lors de l'envoi de la photo principale",
            'failed_send_photo' => "Erreur lors de l'envoi de la photo :",
            'photo_lourd_part1' =>'La photo ',
            'photo_lourd_part2' => ' est trop lourde (max 5 Mo)',
            'photo_wrong_format' => " n'est pas au bon format (formats acceptés : png, jpg et webp)",
            'failed_find_photo_del' => "La photo sélectionnée pour être supprimée n'a pas été identifiée",
            'missing_id_game' => "Erreur d'identifiant",
            'data_send' => "Données enregistrées",
            'failed_data_send' => "Échec de l'enregistrement des nouvelles données",
            'failed_photo_pp_save' => "Échec de l'enregistrement de la photo de profil",
            'failed_photo_save' => "Échec de l'enregistrement des photos",
            'failed_del_photo' => "Échec de la suppression des photos",
            'change_succes' => "Les changements ont bien été appliqués",
            'bug_form' => "Erreur de formulaire",
            'failed_insert_escape' => "Échec de l'insertion de l'aventure",
            'failed_del_escape' => "Échec de la suppression de l'aventure",
            
            'failed_get_id_package' => "Echec de l'affichage du cadeau N°",
            'failed_hauteur_format' => "Format hauteur invalide",
            'failed_largeur_format' => "Format largeur invalide",
            'hauteur_missing' => "Hauteur manquant",
            'largeur_missing' => "Largeur manquant",
            'tps_livre_missing' => "Temps de livraison manquant",
            'missing_id_package' => "Erreur d'identifiant",
            'failed_insert_package'=> "Échec de l'insertion du package",
            'failed_save_data_package'=> "Échec de l'enregistrement des nouvelles données",
            'failed_del_package' => "Échec de la suppression du package",

            'failed_save_data'=> "Échec de l'enregistrement des nouvelles données",
            'num_tel_missing' => "Numéro de telephone manquant",
        ];
        break;
    case 'en':
        $translations = [
            'invalid_email_format' => 'Invalid email format',
            'email_missing' => 'Email missing',
            'password_missing' => 'Password missing',
            'firstname_missing' => 'First name missing',
            'name_missing' => 'Name missing',
            'check_password_missing' => 'Check password missing',
            'email_or_password_wrong' => 'Email or password incorrect',
            'registration_failed' => 'Registration failed',
            'invalid_password_format' => 'Please enter a valid password',
            'check_password_different_password' => 'Check password does not match your password',
            'bug_bbd' => 'A problem occurred in the database',
            'send_request_revocation' => "Your revocation request has been sent successfully",
            'revocation_failed' => "Revocation failed",
            'invalid_tel_format' => "Invalid phone number format",
            'modification_succes'=> 'Modification successful',
            'modification_failed' => "Modification failed",

            'failed_get_aventure' => "Failed to display adventure No.",
            'succes_revocation' => "The reservation has been successfully canceled",
            'failed_revocation_admin' => "Due to an error, the request could not be canceled",
            'succes_reject_revocation' => "The cancellation request has been successfully rejected",
            'failed_reject_revocation' => "Due to an error, the request could not be rejected",
            'failure_revocation_reservation' => "Failed to cancel the reservation",
            'name_already_take' => 'Name already taken',
            'detail_en_missing'=> "Detail in English missing",
            'detail_fr_missing'=> "Detail in French missing",
            'detail_de_missing'=> "Detail in German missing",
            'history_en_missing' => "History in English missing",
            'history_fr_missing' => "History in French missing",
            'history_de_missing' => "History in German missing",
            'description_en_missing' => "Description in English missing",
            'description_fr_missing' => "Description in French missing",
            'description_de_missing' => "Description in German missing",
            'info_lang_missing' => "Language missing",
            'info_en_emporter_missing' => "Information to take away in English missing",
            'info_fr_emporter_missing' => "Information to take away in French missing",
            'info_de_emporter_missing' => "Information to take away in German missing",
            'info_en_important_missing' => "Important information in English missing",
            'info_fr_important_missing' => "Important information in French missing",
            'info_de_important_missing' => "Important information in German missing",
            'failed_puzzle_lvl_format' => "Please choose a correct puzzle difficulty",
            'puzzle_lvl_missing'=> 'Puzzle difficulty missing',
            'failed_walk_lvl_format' => "Please choose a walking difficulty",
            'walk_lvl_missing' => "Walking difficulty missing",
            'target_en_grp_missing' => "Target group information in English missing",
            'target_fr_grp_missing' => "Target group information in French missing",
            'target_de_grp_missing' => "Target group information in German missing",
            'train_en_bus_missing' => "Please indicate a means of transportation station in English",
            'train_fr_bus_missing' => "Please indicate a means of transportation station in French",
            'train_de_bus_missing' => "Please indicate a means of transportation station in German",
            'localisation_missing' => "Location missing",
            'failed_latitude_format' => "Problem with latitude format",
            'latitude_missing' => "Latitude missing",
            'failed_longitude_format' => "Problem with longitude format",
            'longitude_missing' => "Longitude missing",
            'address_missing' => "Address missing",
            'failed_price_format' => "Invalid price format",
            'price_missing' => "Price missing",
            'failed_duration_format' => "Invalid duration format",
            'duration_missing' => "Duration of the escape game missing",
            'failed_parking_format' => "Problem with parking format",
            'parking_missing' => "Parking missing",
            'failed_accebilite_format' => "Problem with accessibility format",
            'accebilite_missing' => "Accessibility missing",
            'photo_pp_lourd' => "The proposed main photo is too heavy (max 5MB)" ,
            'failed_send_photo_pp' => "Error sending the main photo",
            'failed_send_photo' => "Error sending the photo :",
            'photo_lourd_part1' =>'The photo ',
            'photo_lourd_part2' => ' is too heavy (max 5MB)',
            'photo_wrong_format' => " is not in the correct format (accepted formats: png, jpg and webp)",
            'failed_find_photo_del' => "The photo selected to be deleted was not identified",
            'missing_id_game' => "Identifier error",
            'data_send' => "Data saved",
            'failed_data_send' => "Failed to save new data",
            'failed_photo_pp_save' => "Failed to save profile photo",
            'failed_photo_save' => "Failed to save photos",
            'failed_del_photo' => "Failed to delete photos",
            'change_succes' => "Changes have been successfully applied",
            'bug_form' => "Form error",
            'failed_insert_escape' => "Failed to insert adventure",
            'failed_del_escape' => "Failed to delete adventure",
            
            'failed_get_id_package' => "Failed to display gift No.",
            'failed_hauteur_format' => "Invalid height format",
            'failed_largeur_format' => "Invalid width format",
            'hauteur_missing' => "Height missing",
            'largeur_missing' => "Width missing",
            'tps_livre_missing' => "Delivery time missing",
            'missing_id_package' => "Identifier error",
            'failed_insert_package'=> "Failed to insert the package",
            'failed_save_data_package'=> "Failed to save new data",
            'failed_del_package' => "Failed to delete the package",

            'failed_save_data'=> "Failed to save new data",
            'num_tel_missing' => "Missing phone number",
        ];
        break;
    case 'de' :
        $translations = [
            'invalid_email_format' => 'Ungültiges E-Mail-Format',
            'email_missing' => 'E-Mail fehlt',
            'password_missing' => 'Passwort fehlt',
            'firstname_missing' => 'Vorname fehlt',
            'name_missing' => 'Name fehlt',
            'check_password_missing' => 'Überprüfungs-Passwort fehlt',
            'email_or_password_wrong' => 'E-Mail oder Passwort inkorrekt',
            'registration_failed' => 'Registrierung fehlgeschlagen',
            'invalid_password_format' => 'Bitte geben Sie ein gültiges Passwort ein',
            'check_password_different_password' => 'Überprüfungspasswort stimmt nicht mit Ihrem Passwort überein',
            'bug_bbd' => 'Ein Problem ist in der Datenbank aufgetreten',
            'send_request_revocation' => "Ihre Widerrufsanfrage wurde erfolgreich gesendet",
            'revocation_failed' => "Widerruf fehlgeschlagen",
            'invalid_tel_format' => "Ungültiges Telefonnummerformat",
            'modification_succes'=> 'Änderung erfolgreich',
            'modification_failed' => "Änderung fehlgeschlagen",

            'failed_get_aventure' => "Fehler beim Anzeigen des Abenteuers Nr.",
            'succes_revocation' => "Die Reservierung wurde erfolgreich storniert",
            'failed_revocation_admin' => "Aufgrund eines Fehlers konnte die Anfrage nicht storniert werden",
            'succes_reject_revocation' => "Die Stornierungsanfrage wurde erfolgreich abgelehnt",
            'failed_reject_revocation' => "Aufgrund eines Fehlers konnte die Anfrage nicht abgelehnt werden",
            'failure_revocation_reservation' => "Fehler beim Stornieren der Reservierung",
            'name_already_take' => 'Name bereits vergeben',
            'detail_en_missing'=> "Detail auf Englisch fehlt",
            'detail_fr_missing'=> "Detail auf Französisch fehlt",
            'detail_de_missing'=> "Detail auf Deutsch fehlt",
            'history_en_missing' => "Geschichte auf Englisch fehlt",
            'history_fr_missing' => "Geschichte auf Französisch fehlt",
            'history_de_missing' => "Geschichte auf Deutsch fehlt",
            'description_en_missing' => "Beschreibung auf Englisch fehlt",
            'description_fr_missing' => "Beschreibung auf Französisch fehlt",
            'description_de_missing' => "Beschreibung auf Deutsch fehlt",
            'info_lang_missing' => "Sprache fehlt",
            'info_en_emporter_missing' => "Information zum Mitnehmen auf Englisch fehlt",
            'info_fr_emporter_missing' => "Information zum Mitnehmen auf Französisch fehlt",
            'info_de_emporter_missing' => "Information zum Mitnehmen auf Deutsch fehlt",
            'info_en_important_missing' => "Wichtige Informationen auf Englisch fehlt",
            'info_fr_important_missing' => "Wichtige Informationen auf Französisch fehlt",
            'info_de_important_missing' => "Wichtige Informationen auf Deutsch fehlt",
            'failed_puzzle_lvl_format' => "Bitte wählen Sie eine korrekte Puzzle-Schwierigkeit",
            'puzzle_lvl_missing'=> 'Puzzle-Schwierigkeit fehlt',
            'failed_walk_lvl_format' => "Bitte wählen Sie eine Gehschwierigkeit",
            'walk_lvl_missing' => "Gehschwierigkeit fehlt",
            'target_en_grp_missing' => "Zielgruppeninformationen auf Englisch fehlt",
            'target_fr_grp_missing' => "Zielgruppeninformationen auf Französisch fehlt",
            'target_de_grp_missing' => "Zielgruppeninformationen auf Deutsch fehlt",
            'train_en_bus_missing' => "Bitte geben Sie eine Verkehrsmittelstation auf Englisch an",
            'train_fr_bus_missing' => "Bitte geben Sie eine Verkehrsmittelstation auf Französisch an",
            'train_de_bus_missing' => "Bitte geben Sie eine Verkehrsmittelstation auf Deutsch an",
            'localisation_missing' => "Ort fehlt",
            'failed_latitude_format' => "Problem mit dem Breitengradformat",
            'latitude_missing' => "Breitengrad fehlt",
            'failed_longitude_format' => "Problem mit dem Längengradformat",
            'longitude_missing' => "Längengrad fehlt",
            'address_missing' => "Adresse fehlt",
            'failed_price_format' => "Ungültiges Preisformat",
            'price_missing' => "Preis fehlt",
            'failed_duration_format' => "Ungültiges Dauerformat",
            'duration_missing' => "Dauer des Escape-Spiels fehlt",
            'failed_parking_format' => "Problem mit dem Parkplatzformat",
            'parking_missing' => "Parkplatz fehlt",
            'failed_accebilite_format' => "Problem mit dem Zugangsformat",
            'accebilite_missing' => "Zugänglichkeit fehlt",
            'photo_pp_lourd' => "Das vorgeschlagene Hauptfoto ist zu schwer (max. 5 MB)" ,
            'failed_send_photo_pp' => "Fehler beim Senden des Hauptfotos",
            'failed_send_photo' => "Fehler beim Senden des Fotos :",
            'photo_lourd_part1' =>'Das Foto ',
            'photo_lourd_part2' => ' ist zu schwer (max. 5 MB)',
            'photo_wrong_format' => " hat das falsche Format (akzeptierte Formate: png, jpg und webp)",
            'failed_find_photo_del' => "Das zum Löschen ausgewählte Foto wurde nicht identifiziert",
            'missing_id_game' => "Identifikationsfehler",
            'data_send' => "Daten gespeichert",
            'failed_data_send' => "Fehler beim Speichern neuer Daten",
            'failed_photo_pp_save' => "Fehler beim Speichern des Profilfotos",
            'failed_photo_save' => "Fehler beim Speichern von Fotos",
            'failed_del_photo' => "Fehler beim Löschen von Fotos",
            'change_succes' => "Änderungen wurden erfolgreich übernommen",
            'bug_form' => "Formfehler",
            'failed_insert_escape' => "Fehler beim Einfügen des Abenteuers",
            'failed_del_escape' => "Fehler beim Löschen des Abenteuers",

            'failed_get_id_package' => "Fehler beim Anzeigen des Geschenks Nr.",
            'failed_hauteur_format' => "Ungültiges Höhenformat",
            'failed_largeur_format' => "Ungültiges Breitenformat",
            'hauteur_missing' => "Höhe fehlt",
            'largeur_missing' => "Breite fehlt",
            'tps_livre_missing' => "Lieferzeit fehlt",
            'missing_id_package' => "Identifikationsfehler",
            'failed_insert_package'=> "Fehler beim Einfügen des Pakets",
            'failed_save_data_package'=> "Fehler beim Speichern neuer Daten",
            'failed_del_package' => "Fehler beim Löschen des Pakets",

            'failed_save_data'=> "Fehler beim Speichern neuer Daten",
            'num_tel_missing' => "Fehlende Telefonnummer",
        ];
    
        break;
}

return $translations;
