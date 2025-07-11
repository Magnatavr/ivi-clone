<?php
// проверка сессии 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//ставим заглушку что бы пользователь не мог зайти на прямую 
if (!defined('APP_STARTED')) {
    http_response_code(403);
    exit('Forbidden');
}
// Подключаем файлы конфигурации, БД и необходимые функции
require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/init.php';


// получение фильмов по типу через функцию 
$filmTypes = getFilmTypes($pdo);

?>


<header class="header">
    <div class="header__container">
        <div>
            <a href="<?= BASE_URL ?>/index.html" class="header__logo">IVICLONE</a>
        </div>

        <nav class="header__nav">
            <ul class="header__menu">
                <!-- отрисовываем данные которые получили сверху -->
                <?php foreach ($filmTypes as $type): ?>
                    <li class="header__menu-item">
                        <a href="<?= BASE_URL ?>/pages/movies-taypes.php?type=<?= urlencode($type['film_type']) ?>"
                            class="header__link">
                            <?= htmlspecialchars($type['film_type']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="header_right-item">
            <div class="nbl-button__primaryText">
                <div class="nbl-button__iconWrapper">
                    <img id="searchBtn" src="<?= BASE_URL ?>/assets/img/logo/search_16.svg"
                        class="nbl-iconSvg nbl-button__nbl-iconSvg" />
                </div>
                <a href="<?= BASE_URL ?>/pages/filter.php" class="header__link">Фильтер</a>
            </div>
            <div class="header__auth">
                <!-- проверка есть ли сессия у пользователя для отображения нужного контента -->
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="<?= BASE_URL ?>/pages/profile.php" class="header__register-btn header__link">Профиль</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/pages/auth.php?name=login" class="header__login-btn header__link">Войти</a>
                    <a href="<?= BASE_URL ?>/pages/auth.php?name=register"
                        class="header__register-btn header__link">Регистрация</a>
                <?php endif ?>
            </div>
        </div>
    </div>
</header>