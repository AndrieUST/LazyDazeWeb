<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);
$_SESSION;
?>
<html lang="en">
    <html class="main" style="overflow: hidden; height: 100%;">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Scarlet Central</title>
       
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        
    <style>
@font-face {
    font-family: 'TW';
    src: url("Scarlet_Files/TwCenMT-Regular.ttf");
}

@font-face{
    font-family: 'BebasNeue';
    src: url("Scarlet_Files/BebasNeue-Regular.ttf");
}
@keyframes appear {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes navbar {
    0% {
        transform: scaleY(0)
    }
    80% {
        transform: scaleY(1.1)
    }
    100% {
        transform: scaleY(1)
    }
}
body{
    animation: appear 1s;
}
.TW {
    margin-top: .7rem ;
    font-size: 6rem ;
}
.whole-section {
    position: relative;
    box-sizing: border-box;
}
html {
    padding: 0;
    margin: 0;
    line-height: 1;
    font-size: 20px;
    /*width: 1920px !important;*/
    /*overflow: scroll !important;*/
    /*height: 1080px !important;*/
}
/* SECTION 1 STYLE */
.section-1-wrapper {
    padding-left: 6px;
    box-sizing: border-box;
    /* min-width: 1800px; */
}
.section-1-R .section-1-wrapper-right {
    width: 6rem;
    background-position: center;
    position: relative;
    background-size: 2rem 12rem;
    background: #FFD200;
}
.text-vertical {
    top: 16.8rem;
    left: .4rem;
    font-size: .8rem;
    white-space: nowrap;
    position: relative;
    transform: rotate(90deg);
}
.section-1-wrapper > .section-1-L {
    /* width: 49%; */
    flex: 1;
    padding-left: 7.75rem;
    position: relative;
}

.section-1-wrapper .main-title {
    width: 32.65rem;
    height: 22.45rem;
}

.yellow-square {
    background-color: #FFD200;
}

.section-1-L .yellow-square {
    width: 3.3rem;
    height: 3.3rem;
    margin-top: -1.65rem;
    position: relative;
    z-index: 99;
}

.section-1-L .bg-element {
    position: absolute;
    width: 17.15rem;
    height: 16.8rem;
    left: 0;
    top: 0;
}

.section-1-wrapper > .section-1-R {
    flex: 1;
    height: 35.9rem;
    width: 47.75rem;
    /*min-width: 47.75rem;*/
    background-color: #FFD200;
}

.row-between {
    display: flex;
    justify-content: space-between;
}

.section-1-text {
    width: 28.8rem;
    display: inline-block;
    font-size: 1rem;
    line-height: 1.1;
    margin: 2rem 0 1rem;
}

.section-1-wrapper .text-box {
    flex: 1;
    margin-left: 2rem;
}

.view-more {
    width: 160px;
    height: 80px;
    position: relative;
    display: flex;
    align-items: center;
}

.view-more-btn {
    position: relative;
    border: none;
}

.view-more .btn-more {
    color: #000000;
    font-size: .8rem;
    font-weight: 500;
    height: 0.6rem;
    width: 6rem;
    line-height: .6rem;
    text-align: left;
    padding: 0;
    background-color: transparent;
    position: relative;
    z-index: 2;
}

.view-more:hover .btn-more {
    background-color: #FFD200;
    transition-duration: 0.5s;
}

.view-more .btn-more .text-btn {
    position: absolute;
    top: -.4rem;
    font-weight: 600;
    left: -.1rem;
}

.section-1-wrapper .view-more .btn-more {
    margin-bottom: -1.5rem;
    left: -1rem;
}

.view-more .right-circle {
    width: 4.5rem;
    height: 4.5rem;
    border-radius: 100%;
    border: 1px solid #cecbca;
    position: absolute;
    z-index: 1;
    top: 1.1rem;
    left: 4.1rem;
    top: 0.15rem;
}

.ogey {
    position: absolute;
    height: 2.4rem;
    width: .6rem;
    background: #f2f1f1;
    left: -0.06rem;
}

.slider-right{
    scale: 40%;
}

.flex-center {
    display: flex;
    justify-content: center;
    align-items: center;
}

.section-1-L .img-main-title {
    margin-top: 3.5rem;
    width: 32.65rem;
    height: 22.45rem;
}

.img-wrapper .img-center {
    position: absolute;
    max-width: 100%;
    height: 100%;
}
.mainlogo {
    position: absolute;
    width: 30rem;
    left: 6rem;
    top: 2rem;
    z-index: 1 !important;
}
.header {
  background-color: #FFD200;
  color: black;
  padding: 16px;
  font-size: 20px;
  border: none;
  cursor: pointer;
  overflow: hidden;
}
.header:hover {
  background-color: #FFD200;
  color: #ff0000;
  padding: 16px;
  font-size: 20px;
  border: none;
  cursor: pointer;
  overflow: hidden;
  transition-duration: 0.3s;
}
.fb-icon{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
}
.fb-icon:hover{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
  box-shadow: 0 0 40px 2px #ff0000;
  transition-duration: 0.3s;
}
.twt-icon{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
}
.twt-icon:hover{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
  box-shadow: 0 0 40px 2px #ff0000;
  transition-duration: 0.3s;
}
.ig-icon{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
}
.ig-icon:hover{
  width: 30px;
  margin: 0 12px;
  border-radius: 50%;
  box-shadow: 0 0 40px 2px #ff0000;
  transition-duration: 0.3s;
}
.scarlet-icon{
    width: 5%;
    margin-top: 4px;
}
.dropdown {
  position: relative;
  display: inline-block;
}
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  width: 100%;
  z-index: 100;
}
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: #FFD200;
    transition-duration: 0.3s;
}

.dropdown:hover .dropdown-content {
  display: block;
  animation: navbar 300ms ease-in-out forwards;
  transform-origin: top center;
}

.dropdown:hover .dropbtn {
  background-color: #3e8e41;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  margin-top: auto;
  margin-bottom: auto;
}
.text-font {
  font-size: 20px;
  font-style: bold;
}
</style>
    </head>

    <body style="overflow: hidden; height: 100%; font-family: TW; background-color: #f2f1f1;" class="page-1">

    
<!-- side navigation bar below here plz
    <div class="side-bar-wrap">
        <div class="side-bar">
            
-->
<div class="dropdown center">
    <div class = "header">Welcome <?php echo $user_data['user_name'];?>!
          <img align = "right" class = "scarlet-icon" src="Scarlet_Files/UST Scarlet.png" alt="Scarlet Logo">
    <a target="_blank" href="https://www.instagram.com/scarletcentral/?hl=en">
          <img align = "right" class = "ig-icon" src="Scarlet_Files/ig.png" alt="Instagram">
        </a>
    <a target="_blank" href="https://twitter.com/scarletcentral">
          <img align = "right" class = "twt-icon" src="Scarlet_Files/twt.png" alt="Twitter">
        </a>
    <a target="_blank" href="https://www.facebook.com/iloveustscarlet">
          <img align = "right" class = "fb-icon" src="Scarlet_Files/fb.png" alt="Facebook">
        </a>
</div>
    <div class="dropdown-content">
      <a href="members.php">Members</a>
      <a href="News.php">News</a>
      <a href="logout.php">Logout</a>
    </div>
    </div>

<!-- //div containing everything// -->

<div id="main-page" class="main-content" style="height: 100%; position: relative">

    <!-- //SECTION 1 Scarlet Central// -->

    <section class="section-1 whole-section" id="section-id-1" style="height: 906px; padding-top: 3.2rem;">
        <div class="section-1-wrapper row-between">
            <div class="section-1-L">
                <div class="yellow-square"></div>
                <img src="./Scarlet_Files/UST Scarlet Title.png" class="img-main-title"> <!-- wala pa tayo image dito -->
                <img class="bg-element" src="./Scarlet_Files/section-1-bg-element-715Wx700L.png" alt="u hab bad internet"> <!-- wala pa tayo image dito -->
         
                <div class="text-box">
                    <div class="section-1-text" id="home">
                        Founded in the year 1961, UST Scarlet Central is a student ran organization that will cater to the Fil-Chi students of the University of Santo Tomas.
                        The organization is situated in UST Manila, Philippines.
                    </div>
                    <div class="view-more">
                    <a href = "members.php" class="view-more-btn btn-more"> <!-- open sidebar button. wala pa actual function -->
                        <img src="./Scarlet_Files/view-more-btn-104Wx12L.png" alt="" style="position: absolute; left: 0.5rem; top: -.4rem;width: 5rem;"> <!-- wala pa tayo image dito -->
</a>
                        <div class="right-circle flex-center pull-right">
                            <div class="ogey">

                            </div>
                            <img src="./Scarlet_Files/right-arrow-109Wx18L.png" class="slider-right"> <!-- wala pa tayo image dito -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-1-R d-flex">
                <div class="img-wrapper flex-grow-1">
                    <div class="img-center">
                    <img src = "Scarlet_Files/ust scarlet logo.png" class = "mainlogo">
                </div>
                    </div>
                </div>
            <div class="section-1-wrapper-right">
                <div class="text-vertical">
                    SCARLET  CENTRAL
                </div>

            </div>

            </div>
        </div>



    </section>


</div>

</body>
</html>