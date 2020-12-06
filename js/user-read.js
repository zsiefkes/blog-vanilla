document.addEventListener("DOMContentLoaded", function(event) {
    
    // Initialize DOM objects
    let editUserButton = document.querySelector("#edit-user-button");
    // if there's no edituserbutton in the dom, we're on someone else's profile page.


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

    // read in request parameter 'edit'
    const urlParams = new URLSearchParams(window.location.search);
    let isEditing = urlParams.get('edit');

    // enable editing mode if edit param = 1
    if (isEditing == 1) {
        enableEditUser();
    } else {
        disableEditUser();
    }

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
    // let isEditing = false;
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
        // error flag and message
        let hasError = false;
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
            }
        }
        // check for empty strings
        if (usernameField.value == "") {
            if (hasError) {
                // add error on newline if there's already one present
                formError.innerText += "\n";
            }
            formError.innerText += "Username must be at least 1 character in length.";
            hasError = true;
        }
        if (fnameField.value == "") {
            if (hasError) {
                // add error on newline if there's already one present
                formError.innerText += "\n";
            }
            formError.innerText += "Please provide a first name.";
            hasError = true;
        } 

        // check if an error was found,
        if (hasError) {
            // prevent form being submitted
            event.preventDefault();
        } else {
            // clear error message and allow form submit.
            formError.innerText = "";
        }
    });

    // disableEditUser();
    // initialize with password edit disabled
    disableEditPassword();
    
});