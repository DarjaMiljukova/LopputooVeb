<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pidu</title>
    <link rel="stylesheet" type="text/css" href="stiilid/pea.css">
</head>
<body>
<header>
    <h1 style="user-select: none" class="gradient-text">Maagiline pidu</h1>
    <?php
    session_start();
    if (isset($_SESSION['kasutaja'])) {
        ?>
        <h3>Tere, <?= htmlspecialchars($_SESSION['kasutaja']) ?></h3>
        <a href="logout.php">Logi välja</a>
        <?php
    } else {
        ?>
        <div id="verti" style="user-select: none ">
            <a href="login.php">Logi sisse</a>
            <a href="register.php" id="register">Registreerimine</a>
        </div>
        <?php
    }
    ?>
</header>
<div id="content">
    <div id="header">
        <span style="font-size:80px;cursor:pointer;color: #fdfdfe; text-shadow: 0px 0px 5px #b393d3, 0px 0px 10px #b393d3, 0px 0px 10px #b393d3, 0px 0px 20px #b393d3; user-select: none" onclick="toggleNav()">&#x2261; </span>
    </div>
</div>

<div class="image-box" style="user-select: none">
    <div class="border"></div>
    <img src="images/party1.jpg" alt="Pidu">
    <div class="image-content">
        <h3 class="image-header" style="user-select: none">Pidu</h3>
        <p style="user-select: none">Oled tüdinenud pidevast kontorielust? Tule meie peole ja pääse kõigist muredest!</p>
    </div>
</div>
<div class="image-box2" style="user-select: none">
    <div class="border"></div>
    <img src="images/party3.jpg" alt="Kohtumine sõpradega">
    <div class="image-content">
        <h3 class="image-header" style="user-select: none">Kohtumine sõpradega</h3>
        <p style="user-select: none">Kas te ei ole oma sõpru või perekonda ammu näinud? Registreeru peole ja tule kokku!</p>
    </div>
</div>

<script>

    function toggleNav() {
        var verti = document.getElementById("verti");
        if (verti.style.left === "0px") {
            closeNav();
        } else {
            openNav();
        }
    }

    function openNav() {
        document.getElementById("verti").style.left = "0";
    }

    function closeNav() {
        document.getElementById("verti").style.left = "-250px";
    }
</script>
</body>
</html>
