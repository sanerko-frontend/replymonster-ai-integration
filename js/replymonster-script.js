// js/replymonster-script.js
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".replymonster-settings form");
  form.addEventListener("submit", function (event) {
    const tokenInput = document.getElementById("replymonster_token");
    const errorContainer = document.getElementById("replymonster_error");

    errorContainer.style.display = "none";
    errorContainer.textContent = "";

    if (tokenInput.value.trim() === "") {
      errorContainer.textContent = "Please enter a valid token.";
      errorContainer.style.display = "block";
      event.preventDefault();
    }
  });
});
