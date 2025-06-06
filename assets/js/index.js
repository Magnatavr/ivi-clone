import { toggleAuth } from "./modules/auth.js";
import { setupCancelButton } from "./modules/edit-profile.js";
import { setupReviewCancelButton } from "./modules/review.js";
import { setupSearch } from "./modules/search.js";
import { setupModal } from "./modules//modal.js";
import { moviesFilter } from "./modules/filter.js";

document.addEventListener("DOMContentLoaded", () => {
  setupReviewCancelButton();
  toggleAuth();
  setupCancelButton();
  setupModal("#searchBtn", "#searchModal", "#searchCloseBtn");
  setupSearch("#searchInput", "#searchResults");
  moviesFilter();
});
