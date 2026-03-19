<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['candidate']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Als, Indian Voice Dataset Initiative for Neurodegenerative Research</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script>
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
    </script>
</head>
<body class="mainPage">
    <?php include 'header.php'; ?>
    <!-- Home -->
    <section class="home" id="home">
        <div class="wrapper">
            <div class="homeContent">
                <h1>Speech Biomarkers for Neurodegenerative Diseases</h1>
                <p>This platform invites individuals diagnosed with, or at risk of, neurodegenerative conditions to contribute short voice samples to support critical medical and scientific research.</p>
                <p>Speech is one of the earliest and most sensitive indicators of neurological change. By collecting and analyzing voice data, researchers are able to identify subtle biomarkers associated with diseases such as Amyotrophic Lateral Sclerosis (ALS) and other motor neuron disorders. These insights play a key role in improving early detection, tracking disease progression, and developing more effective diagnostic and assistive technologies.</p>
                <!-- button -->
                <div class="wrap">
                    <?php if (!$isLoggedIn): ?>
                        <button type="button" onclick="openAuthModal('login')">Login</button>
                    <?php else: ?>
                        <a href="record.php">Record Voice</a>
                    <?php endif; ?>

                    <a href="#contact" class="fill">Contact Us</a>
                </div>
            </div>
            <!-- Scroll -->
            <a href="#about" class="scrollDown"><span><i class="fa fa-long-arrow-down" aria-hidden="true"></i></span></a>
        </div>
    </section>
    <!-- About -->
    <section class="about" id="about">
        <div class="wrapper">

            <!-- CENTER : CONTENT -->
            <div class="aboutContent">
                <h2>About ALL-ALS</h2>

                <p>
                    ALL-ALS is a research and data initiative designed to advance early
                    detection and understanding of neurodegenerative diseases through
                    speech and voice analytics.
                </p>

                <p>
                    The platform supports the development of machine-learning models
                    that use voice as a biomarker to estimate the likelihood of
                    Amyotrophic Lateral Sclerosis (ALS). Existing models in this field
                    rely heavily on public datasets composed primarily of European
                    voice samples, creating a significant representation gap for
                    Indian populations.
                </p>

                <p>
                    ALL-ALS addresses this gap by building one of the first large-scale,
                    clinically relevant voice datasets of Indian patients affected by
                    ALS and other motor neuron diseases. The goal is to create a robust,
                    diverse, and accessible resource for the Indian healthcare context.
                </p>
            </div>
            <div class="aboutGrid">
                <!-- LEFT : IMAGE -->
                <div class="aboutImage">
                    <img src="assets/image/about-als.png" alt="ALL-ALS Neurodegenerative Research">
                </div>
                <!-- RIGHT : LIST -->
                <div class="aboutGoals">
                    <h3>Our Objectives</h3>

                    <ul class="aboutList">
                        <li>Improve the accuracy and inclusiveness of AI-based diagnostic tools</li>
                        <li>Enable earlier and more reliable detection of ALS</li>
                        <li>Support research into disease progression and speech biomarkers</li>
                        <li>Accelerate assistive and therapeutic technology development</li>
                        <li>Improve quality of life for individuals with motor neuron diseases</li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <!-- MND -->
    <section class="mnd mnd-parallax" id="mnd">
        <div class="mnd-overlay"></div>

        <div class="wrapper">
            <div class="mndCenter">

                <h2>What is Motor Neuron Disease (MND)?</h2>

                <p>
                    Motor Neuron Disease (MND) is a group of progressive neurological
                    disorders affecting motor neurons — the nerve cells that control
                    voluntary muscles. These neurons, located in the brain and spinal
                    cord, gradually degenerate, leading to muscle weakness, atrophy,
                    and loss of motor function.
                </p>

                <p>
                    The exact cause of MND is unknown in most cases. Around 90% of cases
                    occur sporadically, while approximately 10% are inherited due to
                    genetic mutations. Environmental and cellular factors may also
                    contribute.
                </p>

                <p>
                    Early symptoms include muscle weakness, twitching, cramping, and
                    difficulty speaking or swallowing. As the disease progresses,
                    coordination loss, stiffness, and respiratory difficulties may
                    develop.
                </p>

                <!-- HIGHLIGHTS -->
                <div class="mndHighlights">
                    <div class="mndCard">Progressive neurological disorder</div>
                    <div class="mndCard">Affects voluntary muscle control</div>
                    <div class="mndCard">Symptoms worsen over time</div>
                    <div class="mndCard">Includes ALS and related conditions</div>
                </div>

            </div>
        </div>
    </section>



        <!-- Contact Us -->
    <section class="contact" id="contact">
        <div class="wrapper contactGrid">

            <!-- LEFT TEXT -->
            <div class="contactInfo">
                <h2>Contact Us</h2>
                <p>
                    For research collaboration, participation queries, or general
                    information about the ALL-ALS initiative, please reach out using
                    the form below. Our team will respond at the earliest.
                </p>
            </div>

            <!-- RIGHT FORM -->
            <form class="contactForm" id="contact-form">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="name" placeholder="Your full name">
                    <small class="error-msg" id="error_name"></small>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" placeholder="you@example.com">
                    <small class="error-msg" id="error_email"></small>

                </div>

                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel"  id="mobile" placeholder="10-digit mobile number">
                    <small class="error-msg" id="error_mobile"></small>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea rows="4" id="message" placeholder="Write your message..."></textarea>
                    <small class="error-msg" id="error_message"></small>
                </div>

                <button type="submit" class="btn-submit" id="contact">
                    Send Message
                </button>

            </form>

        </div>
    </section>

    <?php include 'footer.php'; ?>
    <?php include 'authpopup.php'; ?>
    <!-- Toaster Container -->
    <div id="toast-container"></div>
    <?php include 'loader.php'; ?>
    <script src="assets/js/app.js"></script>
</body>
</html>