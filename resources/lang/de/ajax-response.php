<?php

return [

    // wrong password
    'wrong_password_title' => 'Du wurdest nicht eingeloggt',
    'wrong_password_text' => 'Dein Passwort ist falsch.',
    'wrong_password_status' => 'error',
    'wrong_password_http_code' => '401',


    // login success
    'login_success_title' => 'Login erfolgreich',
    'login_success_text' => 'Du wirst gleich weitergeleitet.',
    'login_success_status' => 'success',
    'login_success_http_code' => '200',


    // password required
    'password_required_title' => 'Du wurdest nicht eingeloggt',
    'password_required_text' => 'Du wurdest nur mit unzureichender Wahrscheinlichkeit erkannt. <br>Bitte gib zusätzlich dein Passwort ein',
    'password_required_status' => 'warning',
    'password_required_http_code' => '401',


    // login failed
    'login_failed_title' => 'Du wurdest nicht eingeloggt',
    'login_failed_text' => 'Dein Gesicht konnte nicht identifiziert werden!',
    'login_failed_status' => 'error',
    'login_failed_http_code' => '401',

    // register success
    'registration_success_title' => 'Registrierung erfolgreich',
    'registration_success_text' => 'Du wirst gleich weitergeleitet.',
    'registration_success_status' => 'success',
    'registration_success_http_code' => '200',

    // upload complete
    'upload_complete_title' => 'Upload erfolgreich',
    'upload_complete_text' => '',
    'upload_complete_status' => 'success',
    'upload_complete_http_code' => '200',

    // upload failed
    'upload_failed_title' => 'Upload fehlgeschlagen',
    'upload_failed_text' => 'Deine Dateien dürfen maximal 25 Megabyte groß sein!',
    'upload_failed_status' => 'error',
    'upload_failed_http_code' => '422',

    // files deleted
    'files_deleted_title' => 'Dateien gelöscht',
    'files_deleted_text' => 'Deine Dateien wurden erfolgreich gelöscht',
    'files_deleted_status' => 'success',
    'files_deleted_http_code' => '200',

	// share created
	'share_created_title' => 'Dateifreigabe erstellt',
    'share_created_text' => '<input type="text" id="share-link" autofocus>',
    'share_created_status' => 'success',
    'share_created_http_code' => '200',

	// share created
	'share_deleted_title' => 'Dateifreigabe gelöscht',
    'share_deleted_text' => '',
    'share_deleted_status' => 'success',
    'share_deleted_http_code' => '200',

];