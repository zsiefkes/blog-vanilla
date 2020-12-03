document.addEventListener("DOMContentLoaded", function(event) {
    let posts = [];

    let postTextarea = document.querySelector("#post-textarea");
    const maxChar = 500;
    let charRemaining = document.querySelector("#char-remaining-count");
    let submitButton = document.querySelector(".submit-button");
    // let postsList = document.querySelector("#posts-list");
    
    // display number of characters remaining
    postTextarea.addEventListener("keyup", function(event) {
        toggleSubmitButton();
        updateCharRemaining();
    });

    // // want to disable submit button until there's something written in it
    // submitButton.disabled = true;


    // submitButton.addEventListener("click", function(event) {
    //     // reduce to 500 characters
    //     updateCharRemaining();
    //     // grab the text, add the string to posts
    //     let newPost = {
    //         body: postTextarea.value,
    //         timeStamp: Date().toString()
    //     }
    //     // posts.push(newPost);
    //     // okay here, we need to make a call to the fetch api
    //     // use async/await! cool :)
    //     console.log(JSON.stringify(newPost));
    //     createPost(newPost);
    //     // updatePostList();
    //     // postTextarea.value = "";
    // });

    // // feels so weird not declaring the argument types in the function declaration lol. java what have you done to me... made me a better programmer? 
    // async function createPost(postObj) {
    //     let response = await fetch('post/create.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json'
    //         },
    //         body: JSON.stringify(postObj)
    //     });
    //     console.log(response);
    //     // console.log(JSON.parse(response));
    // }
    
    // redundant now using php to load posts
    // function updatePostList() {
    //     // first, clear existing post list element
    //     postsList.innerHTML = "";

    //     // loop over list of posts in reverse order and create and append the post elements
    //     // for (let post of posts) {
    //     for (let i = posts.length - 1; i > -1; i--) {
    //         let post = posts[i];

    //         let postElem = document.createElement("div");
    //         let timestampText = document.createTextNode("Posted at: " + post.timeStamp);
    //         let postPara = document.createElement("p");
    //         let postText = document.createTextNode(post.text);
    //         postElem.appendChild(timestampText);
    //         postElem.appendChild(postPara);
    //         postPara.appendChild(postText);
    //         postsList.appendChild(postElem);
    //     }

    // }
    
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