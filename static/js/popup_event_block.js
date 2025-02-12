document.addEventListener("click", function(event) {
  if ($('.add').css('display') === 'block') {
    if ($(event.target).closest('.add').length > 0) {
      return;
    }
    event.stopPropagation();
    event.preventDefault();  
  }
}, true);
