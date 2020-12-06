document.addEventListener("DOMContentLoaded", function(event) {
    
    // Initialize DOM objects
    let postBody = document.querySelector("#post-body");
    let postTextarea = document.querySelector("#post-textarea");
    let editPostButton = document.querySelector("#edit-post-button");
    let editPostContainer = document.querySelector("#edit-post-container");

    // grab initial post body and copy into edit textarea
    let postBodyText = postBody.innerText;
    postTextarea.value = postBodyText;

    // read in request parameter 'edit'
    const urlParams = new URLSearchParams(window.location.search);
    let isEditing = urlParams.get('edit');

    // enable editing mode if edit param = 1
    if (isEditing == true) {
        enableEdit();
    } else {
        // need this here in case edit parameter supplied as 0 which case isEditing will be null and first click on edit post will disable 
        isEditing = false;
        // disableEdit();
        // editing is disabled by default but need to set isEditing to false in case you supply as 0 which I haven't but... just in case I do somehwere for some reason.
    }

    // toggle between editing and not editing
    editPostButton.addEventListener("click", function() {
        // set to editing
        if (!isEditing) {
            enableEdit();
        } else {
            disableEdit();
        }
    });
    
    function enableEdit() {
        postBody.style.display = "none";
        editPostContainer.style.display = "block";
        editPostButton.innerText = "Cancel";
        isEditing = true;

        // populate textarea with the um text from the bloody yep
        postTextarea.value = postBodyText;
    }
    function disableEdit() {
        postBody.style.display = "block";
        editPostContainer.style.display = "none";
        editPostButton.innerText = "Edit post";
        isEditing = false;
    }

    // let postTextarea = document.querySelector(".post-textarea");
    const maxChar = 500;
    let charRemaining = document.querySelector("#char-remaining-count");
    let submitButton = document.querySelector(".submit-button");
    // // let postsList = document.querySelector("#posts-list");
    
    // display number of characters remaining
    postTextarea.addEventListener("keyup", function(event) {
        toggleSubmitButton();
        updateCharRemaining();
    });

    // enable/disable submit button based on empty string or stuff in the textarea
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

        // console.log('characters: ' + numChar);
        
    }

    // focus textarea and fill in char remaining
    postTextarea.focus();
    updateCharRemaining();
});