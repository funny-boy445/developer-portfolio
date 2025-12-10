<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Portfolio</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            background: #000;
            font-family: Arial, sans-serif;
            color: #fff;
            overflow-x: hidden;
        }

        nav {
            display: flex;
            justify-content: flex-end;
            padding: 20px;
            gap: 30px;
            font-size: 14px;
        }

        nav a {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        nav a:hover {
            color: #9b59b6;
        }

        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90vh;
            padding: 0 80px;
        }

        .hero-text h1 {
            font-size: 40px;
            margin: 0;
        }

        .hero-text h1 span {
            color: #9b59b6;
        }

        .hero-text h2 {
            font-size: 28px;
            color: #6a8cff;
            margin-top: 10px;
        }

        .hero-text p {
            width: 350px;
            font-size: 12px;
            color: #bbb;
            margin-top: 15px;
            line-height: 1.4;
        }

        .buttons {
            margin-top: 20px;
            display: flex;
            gap: 15px;
        }

        .buttons button {
            padding: 10px 25px;
            background: #9b59b6;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .buttons button:hover {
            opacity: 0.8;
        }

        .buttons .cv {
            background: transparent;
            border: 1px solid #9b59b6;
        }

        .mask-img {
            width: 380px;
            opacity: 0.9;
        }

        .socials {
            position: absolute;
            bottom: 30px;
            left: 40px;
            display: flex;
            gap: 20px;
        }

        .socials i {
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .socials i:hover {
            color: #9b59b6;
        }
    </style>
</head>
<body>
<nav>
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Education</a>
    <a href="#">Skills</a>
    <a href="#">Portfolio</a>
    <a href="#">Contact</a>
</nav>

<section class="hero">
    <div class="hero-text">
        <h1>Hi, I'm <span>Your Name</span></h1>
        <h2>Software Developer |</h2>

        <p>
            A passionate developer who turns ideas into beautiful and functional digital solutions. Dedicated to clean code, problem‑solving, and constant learning.
        </p>

        <div class="buttons">
            <button>Hire Me</button>
            <button class="cv">My CV</button>
        </div>
    </div>

    <img src="https://i.ibb.co/5LQjFqs/mask.png" class="mask-img" />
</section>

<div class="socials">
    <i class="fa-brands fa-github"></i>
    <i class="fa-brands fa-facebook"></i>
    <i class="fa-brands fa-instagram"></i>
</div>
</body>
</html>
