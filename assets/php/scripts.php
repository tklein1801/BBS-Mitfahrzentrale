<script>
  var navbar = document.querySelector(".main-navbar");
  window.addEventListener("scroll", () => {
    const scrollOffset = window.scrollY;
    scrollOffset >= 1 ? navbar.classList.add("scrolled") : navbar.classList.remove("scrolled");
  });

  var UserAPI = new User();
  var signOutBtn = document.querySelector(".navbar #signOut");
  signOutBtn.addEventListener("click", function () {
    UserAPI.destroySession().then(() => {
      window.location.href = window.location.origin + "/Anmelden";
    }).catch(err => console.error(err));
  });
</script>
