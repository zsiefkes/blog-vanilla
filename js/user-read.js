document.addEventListener("DOMContentLoaded", function(event) {
    
    // Initialize DOM objects
    let editUserButton = document.querySelector("#edit-user-button");
    // if there's no edituserbutton in the dom, we're on someone else's profile page.
    if (!editUserButton) {

    }

    let editUserDetailsContainer = document.querySelector(".edit-user-details");
    let editPasswordButton = document.querySelector("#edit-password-button");
    let newPasswordContainer = document.querySelector("#new-password-container");
    let passwordChangeFlag = document.querySelector("#password-change-flag");
    let formError = document.querySelector("#form-error");
    let submitUserForm = document.querySelector("#submit-user-form");

    // let deactivateUserButton = document.querySelector("#deactivate-user-button");
    let deleteUserButton = document.querySelector("#delete-user-button");
    let newPasswordField = document.querySelector('input[name=\'password\']');
    let newPasswordCheckField = document.querySelector('input[name=\'password-check\']');
    let usernameField = document.querySelector('input[name=\'username\']');
    let fnameField = document.querySelector('input[name=\'fname\']');

    let isChangingPassword = false;
    editPasswordButton.addEventListener("click", function() {
        if (isChangingPassword) {
            disableEditPassword();
        } else {
            enableEditPassword();
        }
    });
    
    function enableEditPassword() {
        newPasswordContainer.style.display = "block";
        passwordChangeFlag.value = 1;
        editPasswordButton.innerText = "Don't change password";
        isChangingPassword = true;
    }
    function disableEditPassword() {
        newPasswordContainer.style.display = "none";
        passwordChangeFlag.value = 0;
        editPasswordButton.innerText = "Change password";
        isChangingPassword = false;
    }

    // boolean to store whether we're editing the user or not
    let isEditing = false;
    editUserButton.addEventListener("click", function() {
        if (isEditing) {
            disableEditUser();
        } else {
            enableEditUser();
        }
    });
    
    function enableEditUser() {
        isEditing = true;
        editUserDetailsContainer.style.display = "block";
        // deactivateUserButton.style.display = "inline";
        deleteUserButton.style.display = "inline";
        editUserButton.innerText = "Cancel editing";
    }
    function disableEditUser() {
        isEditing = false;
        editUserDetailsContainer.style.display = "none";
        // deactivateUserButton.style.display = "none";
        deleteUserButton.style.display = "none";
        editUserButton.innerText = "Edit details";
    }

    // edit user form error checker
    submitUserForm.addEventListener("click", function(event) {
        // boolean lol always find myself wanting to start the variable declaration with the type now. that's great
        let hasError = false;
        // reset error message
        formError.innerText = "";

        // if we're changing passwords
        if (isChangingPassword) {
            // and the new passwords match,
            if (newPasswordField.value == newPasswordCheckField.value) {
                // and they're not empty strings either
                // if (newPasswordField.value != "") {
                //     // great. clear error message and continue
                //     formError.innerText = "";
                // } else {
                if (newPasswordField.value == "") {
                    formError.innerText = "Please provide a new password.";
                    // flag error
                    hasError = true;
                    // prevent form from being submitted
                    // event.preventDefault();
                }
            } else {
                // if the passwords, don't match, display error message
                formError.innerText = "New passwords must match.";
                // flag error
                hasError = true;
                // prevent form from being submitted
                // event.preventDefault();
            }
        }
        // check for empty strings
        if (usernameField.value == "") {
            if (hasError) {
                // add error on newline if there's already one present
                formError.innerText += "\n";
            }
            formError.innerText += "Username must be at least 1 character in length.";
            // event.preventDefault();
            hasError = true;
        }
        if (fnameField.value == "") {
            if (hasError) {
                // add error on newline if there's already one present
                formError.innerText += "\n";
            }
            formError.innerText += "Please provide a first name.";
            // event.preventDefault();
            hasError = true;
        } 

        // check if an error was found,
        if (hasError) {
            // prevent form being submitted
            event.preventDefault();
        } else {
            // clear error message and allow form submit.
            // formError.innerText = "";
        }
    });

    // initialize page with editing disabled
    disableEditUser();
    disableEditPassword();
    
    // i reckon run the empty string error checkers on whether the user does a keyup on either of the username or first name um. inputs. maybe
    
    // grab initial post body and copy into edit textarea
    // let postBodyText = postBody.innerText;
    // postTextarea.value = postBodyText;
    
    // // read in request parameter 'edit'
    // const urlParams = new URLSearchParams(window.location.search);
    // let isEditing = urlParams.get('edit');
    
    // // enable editing mode if edit param = 1
    // if (isEditing == true) {
    //     enableEditUser();
    // } else {
    //     // need this here in case edit parameter supplied as 0 which case isEditing will be null and first click on edit post will disable 
    //     isEditing = false;
    //     // disableEditUser();
    //     // editing is disabled by default but need to set isEditing to false in case you supply as 0 which I haven't but... just in case I do somehwere for some reason.
    // }

    // toggle between editing and not editing
    // editPostButton.addEventListener("click", function() {
    //     // set to editing
    //     if (!isEditing) {
    //         enableEditUser();
    //     } else {
    //         disableEditUser();
    //     }
    // });
    
    // function enableEditUser() {
    //     postBody.style.display = "none";
    //     editPostContainer.style.display = "block";
    //     editPostButton.innerText = "Cancel";
    //     isEditing = true;

    //     // populate textarea with the um text from the bloody yep
    //     postTextarea.value = postBodyText;
    // }
    // function disableEditUser() {
    //     postBody.style.display = "block";
    //     editPostContainer.style.display = "none";
    //     editPostButton.innerText = "Edit post";
    //     isEditing = false;
    // }


    // // let postTextarea = document.querySelector(".post-textarea");
    // const maxChar = 500;
    // let charRemaining = document.querySelector("#char-remaining-count");
    // let submitButton = document.querySelector(".submit-button");
    // // // let postsList = document.querySelector("#posts-list");
    
    // // display number of characters remaining
    // postTextarea.addEventListener("keyup", function(event) {
    //     toggleSubmitButton();
    //     updateCharRemaining();
    // });

    // // enable/disable submit button based on empty string or stuff in the textarea
    // function toggleSubmitButton() {
    //     let numChar = postTextarea.value.length;
    //     if (numChar === 0) {
    //         submitButton.disabled = true;
    //         submitButton.classList.add("button-disabled");
    //     } else {
    //         submitButton.disabled = false;
    //         submitButton.classList.remove("button-disabled");
    //     }
    // }

    // function updateCharRemaining() {
    //     // count number
    //     let numChar = postTextarea.value.length;
    //     // update characters remaining
    //     if (numChar > maxChar) {
    //         postTextarea.value = postTextarea.value.substring(0, maxChar - 1);
    //         numChar = maxChar;
    //         charRemaining.innerText = maxChar + " / " + maxChar;
    //     } else {
    //         charRemaining.innerText = numChar + " / " + maxChar;
    //     }

    //     // console.log('characters: ' + numChar);
        
    // }

    // // focus textarea and fill in char remaining
    // postTextarea.focus();
    // updateCharRemaining();
});