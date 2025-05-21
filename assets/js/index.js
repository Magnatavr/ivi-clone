import { toggleAuth } from "./modules/auth.js";
import { setupCancelButton } from "./modules/edit-profile.js";
import { setupReviewCancelButton } from "./modules/review.js";

setupReviewCancelButton();
toggleAuth();
setupCancelButton();
