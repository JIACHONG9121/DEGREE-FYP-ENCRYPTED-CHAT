<?php
session_start();
include_once "BackEnd/connection.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit();
}
$unique_id = $_SESSION['unique_id'];

if (strpos($unique_id, 'TP') === 0) {
    include_once "Sheader.php";
} elseif (strpos($unique_id, 'LP') === 0) {
    include_once "Lheader.php";
} elseif (strpos($unique_id, 'AP') === 0) {
    include_once "AHeader.php";
}
?>
<style>
    .include {
        padding: 50px;
        margin: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 5px;
    }

    .user-profile {
        display: flex;
        align-items: center;
    }

    .user-avatar img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 18px;
        font-weight: bold;
    }

    .logout {
        text-decoration: none;
        padding: 8px 16px;
        background-color: #333;
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .logout:hover {
        background-color: #555;
    }

    .slideshow-container {
        max-width: 100%;
        position: relative;
        margin: auto;
        width: 900px;
        height: 350px;

    }

    .mySlides {
        display: none;
        text-align: center;
    }

    .mySlides img {
        width: 100%;
        height: 100%;
    }

    .news-and-holidays-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        max-width: 900px;
    }

    .news-container,
    .holidays-container {
        width: 900px;
        border: 1px solid #ddd;
        background-color: #f5f5f5;
        border-radius: 5px;
        margin-top: 10px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

 
    .news-container h2,
    .holidays-container h2 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }


    .news-container .news-images {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .news-container .news-image {
        text-align: center;
        width: 200px;
        margin: 5px;
    }

    .news-container .news-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }

    .news-container .news-image span {
        display: block;
    }

    .holiday-detail .hd {
    padding: 10px;
    margin-bottom: 10px;
    text-align: center; 
    border: 1px solid #ddd; 
}

</style>

<body>
    <div class="include">
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM admin WHERE unique_id = '{$_SESSION['unique_id']}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
        }
        ?>
        <div class="user-profile">
            <a href="userinfo.php?user_id=<?php echo $row['unique_id']; ?>">
                <div class="user-avatar">
                    <img src="BackEnd/images/<?php echo $row['img']; ?>" alt="">
                </div>
            </a>
            <div class="user-info">
                <div class="user-name"><span>
                        <?php echo $row['fname'] . " " . $row['lname'] ?><br><br>
                        <?php echo $row['unique_id']; ?>
                    </span></div>
            </div>
        </div>
        <a href="BackEnd/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">
            <i class="fas fa-door-open"></i>
        </a>
    </div>

    <div class="slideshow-container">
        <div class="mySlides fade">
            <img src="BackEnd/img/shimg1.jpg" alt="Image 1">
        </div>
        <div class="mySlides fade">
            <img src="BackEnd/img/shimg2.jpg" alt="Image 2">
        </div>

        <div class="mySlides fade">
            <img src="BackEnd/img/shimg3.png" alt="Image 3">
        </div>
    </div>

    <div class="news-and-holidays-container">
        <div class="news-container">
            <h2>Latest News</h2>
            <div class="news-images">
                <div class="news-image">
                    <img src="BackEnd/img/news1.jpg" alt="News Image 1">
                    <span>Fostering Global Academic Enrichment: A Spotlight on the SIMATS Student Mobility Programme at
                        APU</span>
                </div>
                <div class="news-image">
                    <img src="BackEnd/img/new2.jpg" alt="News Image 2">
                    <span>APU garners multiple accolades at Private Education Excellence Awards 2023</span>
                </div>
                <div class="news-image">
                    <img src="BackEnd/img/new3.jpg" alt="News Image 3">
                    <span>Final Year Project (FYP) Showcase</span>
                </div>
                <div class="news-image">
                    <img src="BackEnd/img/new4.jpg" alt="News Image 4">
                    <span>Help your city: Electric Solution for Urban Challenge</span>
                </div>
                <div class="news-image">
                    <img src="BackEnd/img/new5.jpg" alt="News Image 5">
                    <span>World Smile Day</span>
                </div>

                <div class="news-image">
                    <img src="BackEnd/img/new6.jpg" alt="News Image 6">
                    <span>ADA Business Messaging Hackathon 2023 – Build the future of conversations on WhatsApp</span>
                </div>
            </div>
        </div>

        <div class="holidays-container">
            <h2>Upcoming Holidays</h2>
            <div class="holiday-detail">
                <div class="hd">
                    <b>Malaysia Day</b>
                    <p>Saturday, 16 September 2023</p>
                </div>
                <div class="hd">
                    <b>Malaysia Day</b>
                    <p>Thursday, 28 September 2023</p>
                </div>
                <div class="hd">
                    <b>Birthday of Prophet Muhammad S.A.W</b>
                    <p>Saturday, 16 September 2023</p>
                </div>
                <div class="hd">
                    <b>Deepavali</b>
                    <p>Sunday, 12 November 2023 - Monday, 13 November 2023</p>
                </div>
            </div>
    </div>




            <script>
                var slideIndex = 0;
                showSlides();

                function showSlides() {
                    var i;
                    var slides = document.getElementsByClassName("mySlides");
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slideIndex++;
                    if (slideIndex > slides.length) {
                        slideIndex = 1;
                    }
                    slides[slideIndex - 1].style.display = "block";
                    setTimeout(showSlides, 2000);
                }
            </script>
</body>