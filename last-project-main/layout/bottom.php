</section>
</div>

<script>
  menu = document.getElementById('menu-burger');
  mobileSidebar = document.getElementById('mobile-sidebar');

  function toggleSidebar(e) {
    if (e.target !== this)
      return;

    mobileSidebar.classList.toggle('backdrop');
    mobileSidebar.childNodes[1].classList.toggle('!-left-0');
  }

  menu.addEventListener('click', function(e) {
    if (e.target !== this)
      return;

    mobileSidebar.classList.toggle('backdrop');
    mobileSidebar.childNodes[1].classList.toggle('!-left-0');
  })

  mobileSidebar.addEventListener('click', function(e) {
    if (e.target !== this)
      return;

    mobileSidebar.classList.toggle('backdrop');
    mobileSidebar.childNodes[1].classList.toggle('!-left-0');
  })
</script>
</body>

</html>