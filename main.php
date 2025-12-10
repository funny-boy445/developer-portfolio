<?php
require_once 'config.php';
require_once 'db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$form_success = false;
$form_errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_submit'])) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    if (empty($name)) $form_errors['name'] = 'Name required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $form_errors['email'] = 'Valid email required';
    if (empty($subject)) $form_errors['subject'] = 'Subject required';
    if (empty($message)) $form_errors['message'] = 'Message required';

    if (empty($form_errors)) {
        $db->saveContact($name, $email, $subject, $message);
        $form_success = true;
    }
}

$skills = [
    'Frontend' => [
        ['HTML/CSS', 95],
        ['JavaScript', 90],
        ['React', 85],
        ['Vue.js', 80]
    ],
    'Backend' => [
        ['PHP/Laravel', 92],
        ['Node.js', 88],
        ['Python', 85],
        ['MySQL', 90]
    ],
    'Tools' => [
        ['Git', 94],
        ['Docker', 82],
        ['AWS', 78],
        ['Linux', 85]
    ]
];

$projects = [
    [
        'title' => 'E-Commerce Platform',
        'desc' => 'Full-featured online shopping with payment integration',
        'tags' => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap'],
        'icon' => 'fas fa-shopping-cart'
    ],
    [
        'title' => 'Task Management App',
        'desc' => 'Collaborative task management with real-time updates',
        'tags' => ['React', 'Node.js', 'MongoDB'],
        'icon' => 'fas fa-tasks'
    ],
    [
        'title' => 'Learning Management System',
        'desc' => 'Educational platform with course management',
        'tags' => ['Laravel', 'Vue.js', 'MySQL'],
        'icon' => 'fas fa-graduation-cap'
    ],
    [
        'title' => 'Health Tracker',
        'desc' => 'Mobile app for tracking workouts and nutrition',
        'tags' => ['React Native', 'Firebase'],
        'icon' => 'fas fa-heartbeat'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME . ' | ' . SITE_TITLE; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --red: #dc2626;
            --red-dark: #991b1b;
            --red-light: #f87171;
            --black: #000000;
            --dark: #0a0a0a;
            --gray: #262626;
            --gray-light: #404040;
            --light: #171717;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(220, 38, 38, 0.15);
            --shadow-lg: 0 25px 50px rgba(220, 38, 38, 0.25);
            --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--white);
            background: linear-gradient(135deg, var(--black) 0%, var(--dark) 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--gray);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
        }

        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: var(--white);
            text-decoration: none;
            position: relative;
        }

        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: var(--red);
            border-radius: 2px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 3rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--white);
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 0;
            position: relative;
            font-size: 1.1rem;
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--red);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--red);
            transition: var(--transition);
        }

        .nav-links a:hover::after, .nav-links a.active::after {
            width: 100%;
        }

        .hamburger {
            display: none;
            cursor: pointer;
            background: none;
            border: none;
            flex-direction: column;
            gap: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: var(--white);
            transition: var(--transition);
            border-radius: 3px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        main {
            padding-top: 100px;
        }

        section {
            padding: 6rem 0;
        }

        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            line-height: 1.1;
        }

        h1 {
            font-size: clamp(3rem, 6vw, 5rem);
            background: linear-gradient(135deg, var(--red) 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        h2 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--red), transparent);
            border-radius: 2px;
        }

        h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--white);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 1.2rem 2.5rem;
            border-radius: var(--radius);
            text-decoration: none;
            font-weight: 700;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            color: var(--white);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: var(--red);
            border: 2px solid var(--red);
        }

        .btn-secondary:hover {
            background: var(--red);
            color: var(--white);
            transform: translateY(-5px);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(220, 38, 38, 0.05) 0%, transparent 50%);
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-text {
            position: relative;
        }

        .profile-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-frame {
            width: 450px;
            height: 450px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            position: relative;
            animation: float 6s ease-in-out infinite, pulse-glow 3s infinite;
            box-shadow: 0 0 100px rgba(220, 38, 38, 0.3);
        }

        .profile-img {
            width: 420px;
            height: 420px;
            border-radius: 50%;
            object-fit: cover;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 5px solid var(--black);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 100px rgba(220, 38, 38, 0.3); }
            50% { box-shadow: 0 0 150px rgba(220, 38, 38, 0.5); }
        }

        .typing-text {
            font-size: 1.5rem;
            color: var(--red-light);
            margin-bottom: 2rem;
            border-right: 3px solid var(--red);
            white-space: nowrap;
            overflow: hidden;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: var(--red); }
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

        .skill-category {
            background: linear-gradient(145deg, var(--dark), var(--gray));
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--gray-light);
            position: relative;
            overflow: hidden;
        }

        .skill-category::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--red), transparent);
        }

        .skill-category:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: var(--shadow-lg);
            border-color: var(--red);
        }

        .skill-item {
            margin-bottom: 2rem;
        }

        .skill-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
        }

        .skill-bar {
            height: 12px;
            background: var(--gray-light);
            border-radius: 6px;
            overflow: hidden;
            position: relative;
        }

        .skill-progress {
            height: 100%;
            border-radius: 6px;
            width: 0;
            background: linear-gradient(90deg, var(--red), var(--red-dark));
            position: relative;
            transition: width 2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .skill-progress::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 3rem;
        }

        .project-card {
            background: linear-gradient(145deg, var(--dark), var(--gray));
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid var(--gray-light);
            position: relative;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--red), transparent);
        }

        .project-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: var(--shadow-lg);
            border-color: var(--red);
        }

        .project-icon {
            height: 250px;
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 4rem;
            position: relative;
            overflow: hidden;
        }

        .project-icon::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: slide 3s infinite linear;
        }

        @keyframes slide {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .project-content {
            padding: 2.5rem;
        }

        .project-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin: 1.5rem 0;
        }

        .tag {
            padding: 0.5rem 1.2rem;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid var(--red);
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--red-light);
            transition: var(--transition);
        }

        .tag:hover {
            background: var(--red);
            color: var(--white);
            transform: translateY(-3px);
        }

        .contact-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
        }

        .contact-info {
            background: linear-gradient(145deg, var(--dark), var(--gray));
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-light);
        }

        .contact-form {
            background: linear-gradient(145deg, var(--dark), var(--gray));
            padding: 3rem;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-light);
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-control {
            width: 100%;
            padding: 1.2rem;
            background: var(--black);
            border: 2px solid var(--gray-light);
            border-radius: var(--radius);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--white);
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .error {
            border-color: var(--red) !important;
        }

        .error-message {
            color: var(--red-light);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .success-message {
            background: linear-gradient(135deg, var(--red), var(--red-dark));
            color: var(--white);
            padding: 2rem;
            border-radius: var(--radius);
            margin-bottom: 2rem;
            text-align: center;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            background: var(--black);
            padding: 5rem 0 2rem;
            border-top: 1px solid var(--gray);
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--red), transparent);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 50px;
            height: 50px;
            background: var(--gray);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            font-size: 1.2rem;
        }

        .social-links a:hover {
            background: var(--red);
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.3);
        }

        @media (max-width: 992px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .profile-frame {
                width: 350px;
                height: 350px;
                margin: 0 auto;
            }

            .profile-img {
                width: 320px;
                height: 320px;
            }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                position: fixed;
                top: 100px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 100px);
                background: var(--dark);
                flex-direction: column;
                padding: 3rem;
                transition: var(--transition);
                border-top: 1px solid var(--gray);
            }

            .nav-links.active {
                left: 0;
            }

            .contact-container {
                grid-template-columns: 1fr;
            }

            .profile-frame {
                width: 300px;
                height: 300px;
            }

            .profile-img {
                width: 270px;
                height: 270px;
            }
        }

        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: var(--red);
            border-radius: 50%;
            opacity: 0.3;
            animation: float-particle 20s infinite linear;
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }
    </style>
</head>
<body>
<div class="floating-particles" id="particles"></div>

<header>
    <nav class="navbar container">
        <a href="?page=home" class="logo"><?php echo strtoupper(SITE_NAME); ?></a>
        <button class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-links" id="navLinks">
            <li><a href="?page=home" class="<?php echo $page == 'home' ? 'active' : ''; ?>">HOME</a></li>
            <li><a href="?page=skills" class="<?php echo $page == 'skills' ? 'active' : ''; ?>">SKILLS</a></li>
            <li><a href="?page=projects" class="<?php echo $page == 'projects' ? 'active' : ''; ?>">PROJECTS</a></li>
            <li><a href="?page=contact" class="<?php echo $page == 'contact' ? 'active' : ''; ?>">CONTACT</a></li>
        </ul>
    </nav>
</header>

<main>
    <?php if ($page == 'home'): ?>
        <section class="hero">
            <div class="container hero-content">
                <div class="hero-text" data-aos="fade-right" data-aos-duration="1500">
                    <h1 data-aos="fade-up" data-aos-delay="200"><?php echo SITE_NAME; ?></h1>
                    <div class="typing-text" data-aos="fade-up" data-aos-delay="400">SOFTWARE DEVELOPER</div>
                    <p style="font-size: 1.2rem; color: #a1a1aa; margin-bottom: 3rem; max-width: 600px;" data-aos="fade-up" data-aos-delay="600">
                        As a dedicated software engineer, I'm passionate about coding and creating impactful solutions.
                        With a solid foundation in computer science and creative approach to development,
                        I build innovative solutions that make a difference.
                    </p>
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;" data-aos="fade-up" data-aos-delay="800">
                        <a href="?page=projects" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> VIEW PROJECTS
                        </a>
                        <a href="?page=contact" class="btn btn-secondary">
                            <i class="fas fa-paper-plane"></i> CONTACT ME
                        </a>
                    </div>
                </div>
                <div class="profile-container" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="400">
                    <div class="profile-frame">
                        <?php if (file_exists('assets/pfp.jpg')): ?>
                            <img src="assets/pfp.jpg" alt="<?php echo SITE_NAME; ?>" class="profile-img">
                        <?php else: ?>
                            <div class="profile-img" style="background: linear-gradient(135deg, var(--dark), var(--gray)); display: flex; align-items: center; justify-content: center; font-size: 5rem; color: var(--red);">
                                <i class="fas fa-user"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <section style="background: var(--black);">
            <div class="container">
                <h2 data-aos="fade-up">CORE COMPETENCIES</h2>
                <div class="skills-grid">
                    <div class="skill-category" data-aos="zoom-in">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--red), var(--red-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-code"></i>
                            </div>
                            <h3>WEB DEVELOPMENT</h3>
                        </div>
                        <p style="color: #a1a1aa;">Full-stack development with modern frameworks and technologies</p>
                    </div>
                    <div class="skill-category" data-aos="zoom-in" data-aos-delay="200">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--red), var(--red-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h3>MOBILE APPS</h3>
                        </div>
                        <p style="color: #a1a1aa;">Cross-platform mobile applications with native performance</p>
                    </div>
                    <div class="skill-category" data-aos="zoom-in" data-aos-delay="400">
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--red), var(--red-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                <i class="fas fa-cloud"></i>
                            </div>
                            <h3>CLOUD SOLUTIONS</h3>
                        </div>
                        <p style="color: #a1a1aa;">Scalable cloud architecture and deployment solutions</p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page == 'skills'): ?>
        <section>
            <div class="container">
                <h1 data-aos="fade-up">TECHNICAL SKILLS</h1>
                <div class="skills-grid">
                    <?php foreach ($skills as $category => $items): ?>
                        <div class="skill-category" data-aos="fade-up">
                            <h3><?php echo $category; ?></h3>
                            <?php foreach ($items as $index => $skill): ?>
                                <div class="skill-item">
                                    <div class="skill-info">
                                        <span style="color: var(--white); font-weight: 600;"><?php echo $skill[0]; ?></span>
                                        <span style="color: var(--red); font-weight: 700;"><?php echo $skill[1]; ?>%</span>
                                    </div>
                                    <div class="skill-bar">
                                        <div class="skill-progress skill-<?php echo strtolower(str_replace(' ', '-', $skill[0])); ?>"
                                             data-width="<?php echo $skill[1]; ?>"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page == 'projects'): ?>
        <section>
            <div class="container">
                <h1 data-aos="fade-up">PORTFOLIO PROJECTS</h1>
                <div class="projects-grid">
                    <?php foreach ($projects as $index => $project): ?>
                        <div class="project-card" data-aos="zoom-in" data-aos-delay="<?php echo $index * 200; ?>">
                            <div class="project-icon">
                                <i class="<?php echo $project['icon']; ?>"></i>
                            </div>
                            <div class="project-content">
                                <h3><?php echo $project['title']; ?></h3>
                                <p style="color: #a1a1aa; margin: 1rem 0 1.5rem;"><?php echo $project['desc']; ?></p>
                                <div class="project-tags">
                                    <?php foreach ($project['tags'] as $tag): ?>
                                        <span class="tag"><?php echo $tag; ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <a href="?page=contact" class="btn btn-primary" style="margin-top: 1.5rem;">
                                    <i class="fas fa-external-link-alt"></i> LEARN MORE
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page == 'contact'): ?>
        <section>
            <div class="container">
                <h1 data-aos="fade-up">GET IN TOUCH</h1>
                <div class="contact-container">
                    <div class="contact-info" data-aos="fade-right" data-aos-delay="200">
                        <h2>CONTACT INFO</h2>
                        <div style="margin: 3rem 0;">
                            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding: 1.5rem; background: rgba(220, 38, 38, 0.05); border-radius: var(--radius); border-left: 4px solid var(--red);">
                                <div style="width: 60px; height: 60px; background: var(--black); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-envelope" style="color: var(--red); font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3>EMAIL</h3>
                                    <p style="color: #a1a1aa;"><?php echo SITE_EMAIL; ?></p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding: 1.5rem; background: rgba(220, 38, 38, 0.05); border-radius: var(--radius); border-left: 4px solid var(--red);">
                                <div style="width: 60px; height: 60px; background: var(--black); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-phone" style="color: var(--red); font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3>PHONE</h3>
                                    <p style="color: #a1a1aa;"><?php echo SITE_PHONE; ?></p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.5rem; background: rgba(220, 38, 38, 0.05); border-radius: var(--radius); border-left: 4px solid var(--red);">
                                <div style="width: 60px; height: 60px; background: var(--black); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-map-marker-alt" style="color: var(--red); font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h3>LOCATION</h3>
                                    <p style="color: #a1a1aa;"><?php echo SITE_LOCATION; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="social-links">
                            <a href="<?php echo GITHUB_URL; ?>" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="<?php echo LINKEDIN_URL; ?>" target="_blank"><i class="fab fa-linkedin"></i></a>
                            <a href="<?php echo TWITTER_URL; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="<?php echo INSTAGRAM_URL; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>

                    <div class="contact-form" data-aos="fade-left" data-aos-delay="400">
                        <h2>SEND MESSAGE</h2>
                        <?php if ($form_success): ?>
                            <div class="success-message">
                                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                                <h3>MESSAGE SENT!</h3>
                                <p>I'll get back to you within 24 hours.</p>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control <?php echo isset($form_errors['name']) ? 'error' : ''; ?>"
                                       placeholder="YOUR NAME" value="<?php echo $_POST['name'] ?? ''; ?>">
                                <?php if (isset($form_errors['name'])): ?>
                                    <div class="error-message"><?php echo $form_errors['name']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control <?php echo isset($form_errors['email']) ? 'error' : ''; ?>"
                                       placeholder="YOUR EMAIL" value="<?php echo $_POST['email'] ?? ''; ?>">
                                <?php if (isset($form_errors['email'])): ?>
                                    <div class="error-message"><?php echo $form_errors['email']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control <?php echo isset($form_errors['subject']) ? 'error' : ''; ?>"
                                       placeholder="SUBJECT" value="<?php echo $_POST['subject'] ?? ''; ?>">
                                <?php if (isset($form_errors['subject'])): ?>
                                    <div class="error-message"><?php echo $form_errors['subject']; ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <textarea name="message" class="form-control <?php echo isset($form_errors['message']) ? 'error' : ''; ?>"
                                          rows="6" placeholder="YOUR MESSAGE"><?php echo $_POST['message'] ?? ''; ?></textarea>
                                <?php if (isset($form_errors['message'])): ?>
                                    <div class="error-message"><?php echo $form_errors['message']; ?></div>
                                <?php endif; ?>
                            </div>
                            <button type="submit" name="contact_submit" class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-paper-plane"></i> SEND MESSAGE
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div>
                <h3 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem;"><?php echo strtoupper(SITE_NAME); ?></h3>
                <p style="color: #a1a1aa; max-width: 300px;">Creating innovative digital solutions with passion and cutting-edge technology.</p>
            </div>
            <div>
                <h3 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem;">QUICK LINKS</h3>
                <ul style="list-style: none;">
                    <li><a href="?page=home" style="color: #a1a1aa; text-decoration: none; display: block; margin-bottom: 0.8rem; transition: var(--transition);">HOME</a></li>
                    <li><a href="?page=skills" style="color: #a1a1aa; text-decoration: none; display: block; margin-bottom: 0.8rem; transition: var(--transition);">SKILLS</a></li>
                    <li><a href="?page=projects" style="color: #a1a1aa; text-decoration: none; display: block; margin-bottom: 0.8rem; transition: var(--transition);">PROJECTS</a></li>
                    <li><a href="?page=contact" style="color: #a1a1aa; text-decoration: none; display: block; transition: var(--transition);">CONTACT</a></li>
                </ul>
            </div>
            <div>
                <h3 style="color: white; margin-bottom: 1.5rem; font-size: 1.5rem;">CONTACT</h3>
                <p style="color: #a1a1aa; margin-bottom: 0.8rem;"><?php echo SITE_EMAIL; ?></p>
                <p style="color: #a1a1aa; margin-bottom: 0.8rem;"><?php echo SITE_PHONE; ?></p>
                <p style="color: #a1a1aa;"><?php echo SITE_LOCATION; ?></p>
            </div>
        </div>
        <div style="text-align: center; padding-top: 3rem; border-top: 1px solid var(--gray); color: #71717a;">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. ALL RIGHTS RESERVED.</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1200,
        once: true,
        offset: 100
    });

    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');

    hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        navLinks.classList.toggle('active');
    });

    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navLinks.classList.remove('active');
        });
    });

    document.querySelectorAll('.skill-progress').forEach(bar => {
        const width = bar.getAttribute('data-width');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        bar.style.width = width + '%';
                    }, 500);
                    observer.unobserve(bar);
                }
            });
        }, { threshold: 0.5 });
        observer.observe(bar);
    });

    const particlesContainer = document.getElementById('particles');
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        const size = Math.random() * 10 + 2;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';
        particle.style.left = Math.random() * 100 + 'vw';
        particle.style.animationDelay = Math.random() * 20 + 's';
        particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
        particle.style.opacity = Math.random() * 0.3 + 0.1;
        particlesContainer.appendChild(particle);
    }

    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.style.background = 'rgba(10, 10, 10, 0.95)';
            header.style.backdropFilter = 'blur(10px)';
        } else {
            header.style.background = 'rgba(10, 10, 10, 0.95)';
            header.style.backdropFilter = 'blur(10px)';
        }
    });
</script>
</body>
</html>