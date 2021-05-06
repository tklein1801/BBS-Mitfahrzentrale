var wrapper = document.querySelector(".wrapper");
var hamburger = wrapper.querySelector("button.hamburger");
var sidebar = wrapper.querySelector(".sidebar");
var navbar = wrapper.querySelector(".navbar");
var isSidebarShown = !wrapper.classList.contains("full");

hamburger.addEventListener("click", function (e) {
  if (isSidebarShown) {
    wrapper.classList.add("full");
  } else {
    wrapper.classList.remove("full");
  }
  isSidebarShown = !isSidebarShown;
});

// wrapper.addEventListener("click", function (e) {
//   if (isSidebarShown) {
//     wrapper.classList.remove("full");
//     isSidebarShown = !isSidebarShown;
//   }
// });
