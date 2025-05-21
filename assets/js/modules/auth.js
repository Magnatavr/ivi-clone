export function toggleAuth() {
  const authLink = document.querySelectorAll(".auth__link");
  const loginForm = document.querySelector(".auth__form--login");
  const registerForm = document.querySelector(".auth__form--register");

  authLink.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      loginForm.classList.toggle("hidden");
      registerForm.classList.toggle("hidden");
    });
  });
}
