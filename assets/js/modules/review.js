export function setupReviewCancelButton(){
    const cancelBtn = document.querySelector(".review__cancel-btn");

    if(cancelBtn){
        cancelBtn.addEventListener('click', () => {
            window.history.back();
        } )
    }
}