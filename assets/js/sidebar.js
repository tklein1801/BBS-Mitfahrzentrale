const wrapper = document.querySelector(".wrapper");
const hamburger = wrapper.querySelector("button.hamburger");
const sidebar = wrapper.querySelector(".sidebar");
const navbar = wrapper.querySelector(".navbar");
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
