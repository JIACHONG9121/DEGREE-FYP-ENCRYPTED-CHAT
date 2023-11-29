const form = document.querySelector(".typing-area"),
  incoming_id = form.querySelector(".incoming_id").value,
  inputField = form.querySelector(".input-field"),
  sendBtn = form.querySelector("button"),
  attachment = form.querySelector("#attachment"),
  chatBox = document.querySelector(".chat-box"),
  wordCount = document.getElementById("word-count"); 

const textarea = document.querySelector("textarea");

form.onsubmit = (e) => {
  e.preventDefault();
};

inputField.focus();

textarea.addEventListener("keyup", e => {
  textarea.style.height = "45px";
  let scHeight = e.target.scrollHeight;
  textarea.style.height = `${scHeight}px`;
});

function updateSendButtonState() {
  if (inputField.value.trim() !== "" || attachment.files.length > 0) {
    sendBtn.classList.add("active");
    sendBtn.removeAttribute("disabled");
  } else {
    sendBtn.classList.remove("active");
    sendBtn.setAttribute("disabled", "disabled");
  }
}

function updateWordCount() {
  const inputText = inputField.value.trim();
  const textWithoutLineBreaks = inputText.replace(/(\r\n|\n|\r)/g, ''); 
  const charCount = textWithoutLineBreaks.length;
  wordCount.textContent = `${charCount}/1000`;

  if (charCount > 1000) {
    alert("You have exceeded the maximum character limit (1000 characters).");
    sendBtn.classList.remove("active");
    sendBtn.setAttribute("disabled", "disabled");
  }
}

function cleanMessageText(text) {
  const cleanedText = text.replace(/(\r\n|\n|\r)/g, '<br>');
  
  const nonEmptyLines = cleanedText.split('<br>').filter(line => line.trim() !== '');
  
  console.log('Cleaned Text:', nonEmptyLines.join('<br>'));
  return nonEmptyLines.join('<br>');
}



inputField.onkeyup = () => {
  updateSendButtonState();
  updateWordCount();
};

attachment.addEventListener("change", () => {
  updateSendButtonState();
  updateWordCount();

  const fileSize = attachment.files[0]?.size; 
  const maxSize = 10 * 1024 * 1024; 

  if (fileSize > maxSize) {
    alert("File size exceeds the maximum allowed (10MB). Please choose a smaller file.");
    attachment.value = "";
    sendBtn.classList.remove("active");
    sendBtn.setAttribute("disabled", "disabled");
    document.querySelector(".red-dot").style.display = "none";
    return;
  }
  const allowedExtensions = ["png", "jpeg", "jpg", "docx", "pdf"];
  const fileExtension = attachment.value.split('.').pop().toLowerCase();

  console.log("File extension:", fileExtension);

  if (!allowedExtensions.includes(fileExtension)) {
    alert("Invalid file type. Allowed file types are: png, jpeg, jpg, docx, pdf");
    sendBtn.classList.remove("active");
    sendBtn.setAttribute("disabled", "disabled"); 
    document.querySelector(".red-dot").style.display = "none";
    return;
  }
  if (attachment.files.length = 0) {
    document.querySelector(".red-dot").style.display = "none";
    sendBtn.classList.remove("active");
    sendBtn.setAttribute("disabled", "disabled"); 
  }

  if (attachment.files.length > 0) {
    document.querySelector(".red-dot").style.display = "block";
  } else {
    document.querySelector(".red-dot").style.display = "none";
  }
});

inputField.addEventListener("keydown", (e) => {
  if (e.key === "Enter" && !e.shiftKey) {
    e.preventDefault(); 
    sendBtn.click(); 
  } else if (e.key === "Enter" && e.shiftKey) {
    inputField.value += "\r";
  }
});


sendBtn.onclick = () => {
  const messageText = cleanMessageText(inputField.value);
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "BackEnd/insert-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = "";
        attachment.value = "";
        sendBtn.classList.remove("active");
        scrollToBottom();
        updateWordCount();
        document.querySelector(".red-dot").style.display = "none";
        textarea.style.height = "45px";
      }
    }
  };

  let formData = new FormData(form);
  formData.set('message', messageText);
  xhr.send(formData);
};

chatBox.onmouseenter = () => {
  chatBox.classList.add("active");
};

chatBox.onmouseleave = () => {
  chatBox.classList.remove("active");
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "BackEnd/receive-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        chatBox.innerHTML = data;
        if (!chatBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + incoming_id);
}, 500);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
