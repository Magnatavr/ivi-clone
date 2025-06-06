export function setupModal(triggerSelector, modalSelector, closeSelector) {
  const trigger = document.querySelector(triggerSelector);
  const modal = document.querySelector(modalSelector);
  const close = document.querySelector(closeSelector);

  if (!trigger || !modal || !close) return;

  trigger.addEventListener("click", () => {
    modal.classList.add("active");
  });

  close.addEventListener("click", () => {
    modal.classList.remove("active");
  });
  window.addEventListener("click", (e) => {
    if (e.target === modal) modal.classList.remove("active");
  });
}
