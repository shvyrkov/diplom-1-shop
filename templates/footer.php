<footer class="page-footer">
  <div class="container">
    <a class="page-footer__logo" href="/">
      <img src="/img/logo--footer.svg" alt="Fashion">
    </a>
    <nav class="page-footer__menu">
      <?php
        showMenu($main_menu, 'footer'); // Общее нижнее меню.
      ?>
    </nav>
    <address class="page-footer__copyright">
      ©<?=date('Y')?> Все права защищены
    </address>
  </div>
</footer>
</body>
</html>
