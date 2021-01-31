document.addEventListener("DOMContentLoaded", function(event) {
    let posts = [];

    let postTextarea = document.querySelector("#post-textarea");
    const maxChar = 500;
    let charRemaining = document.querySelector("#char-remaining-count");
    let submitButton = document.querySelector(".submit-button");
    
    // display number of characters remaining
    postTextarea.addEventListener("keyup", function(event) {
        toggleSubmitButton();
        updateCharRemaining();
    });
    
    function toggleSubmitButton() {
        let numChar = postTextarea.value.length;
        if (numChar === 0) {
            submitButton.disabled = true;
            submitButton.classList.add("button-disabled");
        } else {
            submitButton.disabled = false;
            submitButton.classList.remove("button-disabled");
        }
    }

    function updateCharRemaining() {
        // count number
        let numChar = postTextarea.value.length;
        // update characters remaining
        if (numChar > maxChar) {
            postTextarea.value = postTextarea.value.substring(0, maxChar - 1);
            numChar = maxChar;
            charRemaining.innerText = maxChar + " / " + maxChar;
        } else {
            charRemaining.innerText = numChar + " / " + maxChar;
        }
    }

    // focus textarea and fill in char remaining
    postTextarea.focus();
    updateCharRemaining();
});