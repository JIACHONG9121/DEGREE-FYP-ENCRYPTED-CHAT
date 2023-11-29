<?php
session_start();
include_once "BackEnd/connection.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
}
?>

<html>
<style>
  .user-info {
    flex: 1;
  }

  .user-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 5px;
  }

  .user-email {
    font-size: 16px;
    color: #555;
  }

  .chat-area header {
    display: flex;
    align-items: center;
    padding: 18px 30px;
  }

  .chat-area header .back-icon {
    color: #333;
    font-size: 18px;
  }

  .chat-area header img {
    height: 45px;
    width: 45px;
    margin: 0 15px;
  }

  .chat-area header .details span {
    font-size: 17px;
    font-weight: 500;
  }

  .chat-box {
    position: relative;
    min-height: 500px;
    max-height: 500px;
    overflow-y: auto;
    padding: 10px 30px 20px 30px;
    background: #f7f7f7;
    box-shadow: inset 0 32px 32px -32px rgb(0 0 0 / 5%),
      inset 0 -32px 32px -32px rgb(0 0 0 / 5%);
  }


  .chat-box .text {
    position: absolute;
    top: 45%;
    left: 50%;
    width: calc(100% - 50px);
    text-align: center;
    transform: translate(-50%, -50%);
  }

  .chat-box .chat {
    margin: 15px 0;
  }

  .chat-box .chat p {
    word-wrap: break-word;
    padding: 8px 16px;
    box-shadow: 0 0 32px rgb(0 0 0 / 8%),
      0rem 16px 16px -16px rgb(0 0 0 / 10%);
  }

  .chat-box .outgoing {
    display: flex;
  }

  .chat-box .outgoing .details {
    margin-left: auto;
    max-width: calc(100% - 130px);
  }

  .details {
    margin-right: 20px;

  }

  .chatdelete {
    margin-left: auto;
  }

  .outgoing .details p {
    background: #4845f5;
    color: #fff;
    border-radius: 18px 18px 0 18px;
  }

  .chat-box .incoming {
    display: flex;
    align-items: flex-end;
  }

  .chat-box .incoming .profile-image {
    height: 35px;
    width: 35px;

  }

  .chat-box .incoming .chat-image {

    max-width: 200px;

  }

  .chat-box .incoming .details {
    margin-right: auto;
    margin-left: 10px;
    max-width: calc(100% - 130px);
  }

  .incoming .details p {
    background: #fff;
    color: #333;
    border-radius: 18px 18px 18px 0;
  }

  .typing-area {
    padding: 18px 20px;
    display: flex;
    justify-content: space-between;
  }

  .typing-area .input-field {
    width: 100%;
    resize: none;
    height: 45px;
    outline: none;
    padding: 10px;
    font-size: 16px;
    margin-top: 10px;
    border-radius: 5px;
    max-height: 300px;
    caret-color: #4671EA;
    border: 1px solid #bfbfbf;
  }

  #attach-label {
    display: inline-block;
    cursor: pointer;
    font-size: 20px;
    color: #333;
    margin-top: 10px;
    position: relative;
  }


  #attachment {
    display: none;
  }


  .typing-area #send-button {
    color: #fff;
    width: 55px;
    border: none;
    outline: none;
    background: #333;
    font-size: 19px;
    cursor: pointer;
    opacity: 0.7;
    pointer-events: none;
    border-radius: 0 5px 5px 0;
    transition: all 0.3s ease;
  }

  .typing-area #send-button.active {
    opacity: 1;
    pointer-events: auto;
  }

  textarea::placeholder {
    color: #b3b3b3;
  }

  textarea:is(:focus, :valid) {
    padding: 14px;
  }

  textarea::-webkit-scrollbar {
    width: 0px;
  }

  .red-dot {

    position: absolute;
    bottom: 25px;
    right: 80px;
    width: 10px;
    height: 10px;
    background-color: red;
    border-radius: 50%;
    display: none;
  }

  .BackB {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 20px;
    margin: 20px;
    color: #007BFF;

  }

  #imageModal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        #modalContent {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }

        #modalImage {
            width: 100%;
            height: auto;
        }
    </style>

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

        $sql_query = "SELECT * FROM users WHERE unique_id = '{$user_id}'";

        $sql = mysqli_query($conn, $sql_query);
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: chatlist.php");
        }
        ?>

        <button onclick="history.back()" class="BackB"><i class="fas fa-arrow-left"></i></button>
        <img src="BackEnd/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span>
            <?php echo $row['fname'] . " " . $row['lname'] ?>
          </span>
          <p>
            <?php echo $row['status']; ?>
          </p>
        </div>
        <div class="chatdelete" data-message-timestamp="timestamp_here">

          <div class="countdown-timer" style="display: none;">
            <span id="timer">Vanish in 00:00</span>
          </div>

          <select class="delete-timer-select">
            <option value="5">5 seconds</option>
            <option value="10">10 seconds</option>
            <option value="15">15 seconds</option>

          </select>

          <button class="delete-button" data-incoming-id="<?php echo $user_id; ?>"
            onclick="confirmDelete(this)">VanishALL</button>
        </div>

      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area" enctype="multipart/form-data">
        <input type="text" class="incoming_id" value="<?php echo $user_id; ?>" name="incoming_id" hidden>
        <textarea name="message" class="input-field" placeholder="Type a message here..." autocomplete="off"
          id="message-input"></textarea>
        <span id="word-count">0/1000</span>
        <label for="attachment" id="attach-label"><i class="fas fa-paperclip"></i></label>
        <input type="file" name="attachment" id="attachment" accept=".jpg, .jpeg, .png, .pdf, .docx"
          max-size="10485760">
        <div class="red-dot"></div>
        <button id="send-button"><i class="fab fa-telegram-plane"></i></button>

      </form>

    </section>
    <div id="imageModal" class="modal">
        <span class="close" onclick="document.getElementById('imageModal').style.display='none'">&times;</span>
        <div id="modalContent">
            <img id="modalImage" src="" alt="Modal Image">
        </div>
    </div>
  </div>

  <script src="userchat.js"></script>
  <script>


    let timers = {};
    let countdown = 0;
    const timerElement = document.getElementById('timer');

    function startTimer(button, incomingId, selectedDeleteTime) {
      countdown = selectedDeleteTime;
      const countdownTimer = document.querySelector('.countdown-timer');
      countdownTimer.style.display = 'block';
      timers[incomingId] = setInterval(() => {
        const minutes = Math.floor(countdown / 60);
        const seconds = countdown % 60;
        timerElement.textContent = `Vanish in ${padTime(minutes)}:${padTime(seconds)}`;

        if (countdown <= 0) {
          clearInterval(timers[incomingId]);
          timerElement.textContent = 'Message Vanished';


          deleteMessage(button);
        }

        countdown--;
      }, 1000);
    }

    function padTime(time) {
      return time.toString().padStart(2, '0');
    }

    function confirmDelete(button) {
      const incomingId = button.getAttribute('data-incoming-id');
      const selectElement = button.closest('.chatdelete').querySelector('.delete-timer-select');
      const selectedDeleteTime = parseInt(selectElement.value);


      button.setAttribute('data-delete-time', selectedDeleteTime);


      const chatMessages = document.querySelectorAll('.chat-box .chat');
      if (chatMessages.length === 0) {
        alert('There are no messages to delete.');
        return;
      }

      const confirmation = confirm(`Are you sure you want to delete this message after ${selectedDeleteTime} second(s)?`);

      if (confirmation) {
        clearTimer(incomingId);
        startTimer(button, incomingId, selectedDeleteTime);
      }
    }

    function deleteMessage(button) {
      const incomingId = button.getAttribute('data-incoming-id');
      const deleteTime = parseInt(button.getAttribute('data-delete-time'));


      fetch('BackEnd/delete_message.php', {
        method: 'POST',
        body: new URLSearchParams(`incoming_id=${incomingId}&delete-time=${deleteTime}`),
      })
        .then(response => response.text())
        .then(data => {
          if (data === 'success') {

            location.reload();
          } else {

            alert('Error deleting message.');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    function clearTimer(incomingId) {
      if (timers[incomingId]) {
        clearInterval(timers[incomingId]);
        timerElement.textContent = '';
      }
    }


    function openImageInModal(src) {
            var modal = document.getElementById('imageModal');
            var modalImg = document.getElementById('modalImage');

            modal.style.display = 'block';
            modalImg.src = src;

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        }



  </script>


</body>

</html>