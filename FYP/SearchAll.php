<!DOCTYPE html>
<html lang="en">
<style>

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        gap: 10px;
    }

    button{
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    .users .search {
  margin: 0; 
  display: flex;
  position: relative;
  align-items: center;
  justify-content: space-between;
  width: 100%; /* Set full width for the search bar */
}
.users .search .text{
  font-size: 18px;
  flex-grow: 1; /* Allow text to expand and take available space */
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
.users-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
}

.user-container {
    flex: 1;
    max-width: calc(33.33% - 20px); /* Three users per row with some gap */
    text-align: center;
    padding: 15px;
    background-color: #f5f5f5;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-decoration: none;
    color: #333;
}

.user-container img {
    display: block;
    margin: 0 auto 10px;
    width: 100px; /* Adjust the image width */
    height: 100px; /* Adjust the image height */
    border-radius: 50%;
    object-fit: cover;
}

.user-container .details {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.user-container .role {
    font-size: 14px;
    color: #777;
}
    
</style>

<?php
include_once "Backlast.php"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>User Search</title>
</head>

<body>
<section class="users">
        <h1>All Users</h1>
        <div class="search">
            <span class="text">APU Users</span>
            <input type="text" placeholder="Enter name to search...">
            <button><i class="fas fa-search"></i></button>
        </div>
</section>
        <div class="users-list">

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>