document.addEventListener("click", function (event) {
  if ($(".sidebar").hasClass("open")) { 
    if ($(event.target).is("a, a *")) {
      return; 
    } else if ($(event.target).hasClass("menu-header")) {
    } else {
      $(".sidebar").removeClass("open");
    }
  } else {
    return;
  }
});
