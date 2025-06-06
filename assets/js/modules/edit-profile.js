export function setupCancelButton() {
  const cancelButton = document.querySelector(".edit-profile__cancel-button");

  if (cancelButton) {
    cancelButton.addEventListener("click", () => {
      window.location.href = "profile.html";
    });
  }
}
