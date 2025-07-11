<?php 
// подключаем хендлеры
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/checkauth.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/getdata.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-user-data.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-film-countries.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-film-ears.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-film-genres.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-movies-data.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-film-types.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-one-film.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-reviews.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/authenticateuser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/createuser.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/get-count-movies.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/validateform.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/handlers/setsession.php';



 ?>