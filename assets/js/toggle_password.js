$(document).ready(function() {
  $("#togglePassword").click(function() {
      let togglePasswordDiv = $(".togglePassword-div");
      let currentBorderColor = togglePasswordDiv.css("border-color");

      let borderColorHex = (currentBorderColor === "rgb(74, 144, 226)") ? "#4a90e2" : "#3a3f4b";
      let newBorderColor = (borderColorHex === "#4a90e2") ? "#3a3f4b" : "#4a90e2";
      togglePasswordDiv.css("border-color", newBorderColor);

      let passwordInput = $("#password");
      let type = passwordInput.attr("type") === "password" ? "text" : "password";
      passwordInput.attr("type", type);
  });
});
