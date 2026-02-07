document.getElementById("loginForm").addEventListener("submit", function (e) {
  const identity = document.getElementById("identity").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMsg = document.getElementById("errorMsg");

  // Reset error
  errorMsg.classList.add("hidden");
  errorMsg.innerText = "";

  // Validation
  if (identity === "" || password === "") {
    e.preventDefault();
    errorMsg.innerText = "All fields are required";
    errorMsg.classList.remove("hidden");
    return;
  }

  if (password.length < 6) {
    e.preventDefault();
    errorMsg.innerText = "Password must be at least 6 characters";
    errorMsg.classList.remove("hidden");
    return;
  }
});