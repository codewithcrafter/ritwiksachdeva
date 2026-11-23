<?php
/**
 * Admin Layout Footer
 */
?>
</main>
</div>
</div>

<script>
  // Mobile sidebar toggle
  const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
  const adminSidebar = document.getElementById('adminSidebar');
  if (sidebarToggleBtn && adminSidebar) {
    sidebarToggleBtn.addEventListener('click', () => {
      adminSidebar.classList.toggle('mobile-open');
    });
  }
</script>
</body>

</html>
