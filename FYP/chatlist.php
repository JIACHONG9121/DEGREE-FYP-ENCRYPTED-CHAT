<?php 
  session_start();
  include_once "BackEnd/connection.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>

<?php
    include_once "Backlast.php"; 
?>
<style>
body{
  display: flex;
  flex-direction: column; 
  align-items: center;
  justify-content: flex-start; 
  min-height: 100vh;
  background: #f7f7f7;
  padding: 0 10px;
  margin: 0; 
}


.users{
  padding: 80px 30px;
  width: 100%; 
  max-width: 500px; 
  box-sizing: border-box; 
}
.users header,
.users-list a{
  display: flex;
  align-items: center;
  padding-bottom: 20px;
  border-bottom: 1px solid #e6e6e6;
  justify-content: space-between;
}
.wrapper img{
  object-fit: cover;
  border-radius: 50%;
}
.users header img{
  height: 65px;
  width: 60px;
}
:is(.users, .users-list) .content{
  display: flex;
  align-items: center;
}
:is(.users, .users-list) .content .details{
  color: #000;
  margin-left: 20px;
}
:is(.users, .users-list) .details span{
  font-size: 18px;
  font-weight: 500;
}
.users header .logout{
  display: block;
  background: #333;
  color: #fff;
  outline: none;
  border: none;
  padding: 7px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-size: 17px;
}
.users .search {
  margin: 0; 
  display: flex;
  position: relative;
  align-items: center;
  justify-content: space-between;
  width: 100%; 
}
.users .search .text{
  font-size: 18px;
  flex-grow: 1; 
}
.users .search input{
  position: absolute;
  height: 42px;
  width: calc(100% - 50px);
  font-size: 16px;
  padding: 0 10px;
  border: 1px solid #e6e6e6;
  outline: none;
  border-radius: 5px 0 0 5px;
  opacity: 0;
  pointer-events: none;
  transition: all 0.2s ease;
}
.users .search input.show{
  opacity: 1;
  pointer-events: auto;
}
.users .search button{
  position: relative;
  z-index: 1;
  width: 47px;
  height: 42px;
  font-size: 17px;
  cursor: pointer;
  border: none;
  background: #fff;
  color: #333;
  outline: none;
  border-radius: 0 5px 5px 0;
  transition: all 0.2s ease;
}
.users .search button.active{
  background: #333;
  color: #fff;
}
.search button.active i::before{
  content: '\f00d';
}
.chat-list {
  max-height: 400px;
  overflow-y: auto;
  width: 600px;
  border: 1px solid #e6e6e6; 
  border-radius: 5px; 
}
:is(.chat-list, .chat-box)::-webkit-scrollbar{
  width: 10px;
}
.chat-list a{
  display: flex;
  align-items: center;
  padding-bottom: 10px;
  margin-bottom: 15px;
  padding-right: 15px;
  border-bottom-color: #f1f1f1;
  text-decoration: none;
  color: #333;
}
.chat-list a:last-child{
  margin-bottom: 0px;
  border-bottom: none;
}
.chat-list a img{
  height: 40px;
  width: 40px;
  border-radius: 50%;
margin-right: 15px;
}
.chat-list a .details p{
  color: #67676a;
}

.chat-list a .details span {
font-size: 18px;
font-weight: 500;
}

.chat-list a .status-dot{
  font-size: 12px;
  color: #468669;
  padding-left: 10px;
}
.chat-list a .status-dot.offline{
  color: #ccc;
}

.user-details {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  margin-left: 15px; 
}

.user-name span {
  font-size: 18px;
  font-weight: 500;
}

.user-status p {
  color: #67676a;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<body>

    <section class="users">
      <header>
        <div class="content">
          <?php
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$_SESSION['unique_id']}'");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
      <img src="BackEnd/images/<?php echo $row['img']; ?>" alt="">
      <div class="user-details">
        <div class="user-name">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
        </div>
        <div class="user-status">
          <p><?php echo $row['status']; ?></p>
        </div>
      </div>
    </div>
      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
    </section>

    <div class="chat-list">
    </div>

  <script src="chatlist.js"></script>

</body>
</html>
