<?php
//  ставим заглушку что бы пользователь не зашел на прямую 
if (!defined('APP_STARTED')) {
  http_response_code(403);
  exit('Forbidden');
}

?>
<footer class="footer">
  <div class="footer__container">
    <p class="footer__text">© 2025 IVI Clone. Все права защищены.</p>
  </div>
</footer>