<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
  crossorigin="anonymous"
></script>
<script src="<?php echo $url . "assets/js/ApiHandler.js"; ?>"></script>
<script src="<?php echo $url . "assets/js/snackbar.js"; ?>"></script>
<script src="<?php echo $url . "assets/js/sort.js"; ?>"></script>
<script>
  const navbar = document.querySelector(".navbar");
  window.addEventListener("scroll", () => {
    const scrollOffset = window.scrollY;
    scrollOffset >= 1 ? navbar.classList.add("scrolled") : navbar.classList.remove("scrolled");
  });

  const UserAPI = new User();
  const signOutBtn = document.querySelector(".navbar #signOut");
  signOutBtn.addEventListener("click", function () {
    UserAPI.destroySession().then(() => {
      window.location.href = window.location.origin + "/Anmelden";
    }).catch(err => console.error(err));
  });
</script>
