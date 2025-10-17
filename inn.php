<?php
include("admin/conf/config.php");
/* Persist System Settings On Brand */
$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me | Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #a29bfe;
            --secondary: #6c5ce7;
            --text: #f5f6fa;
            --text-light: #dfe6e9;
            --bg: #1e272e;
            --card-bg: #2d3436;
            --shadow: rgba(0, 0, 0, 0.3);
            --quote-bg: #3d3d3d;
            --skill-fill: #636e72;
            --skill-track: #2d3436;
            --particle: rgba(162, 155, 254, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: background-color 0.5s ease, color 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Background particles */
        .particles-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background-color: var(--particle);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Header */
        header {
            text-align: center;
            padding: 40px 0;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            letter-spacing: 1px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .tagline {
            color: var(--text-light);
            font-weight: 300;
            font-size: 1.1rem;
        }

        /* Main content */
        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            margin: 40px 0;
        }

        .profile-section, .bio-section {
            flex: 1;
            min-width: 300px;
        }

        /* Profile section */
        .profile-container {
            position: relative;
            perspective: 1000px;
            max-width: 400px;
            margin: 0 auto;
        }

        .profile-avatar {
            width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 15px 30px var(--shadow);
            transform-style: preserve-3d;
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            backface-visibility: hidden;
        }

        .profile-container:hover .profile-avatar {
            transform: rotateY(10deg) rotateX(5deg) translateY(-10px);
            box-shadow: 0 25px 50px var(--shadow);
        }

        .avatar-frame {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100%;
            height: 100%;
            border: 3px solid var(--primary);
            border-radius: 20px;
            z-index: -1;
            transform: rotate(3deg);
            transition: transform 0.5s ease;
        }

        .profile-container:hover .avatar-frame {
            transform: rotate(-2deg);
        }

        /* Bio section */
        .bio-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        h2:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border-radius: 3px;
        }

        .bio-text {
            margin-bottom: 30px;
            color: var(--text-light);
            font-weight: 300;
        }

        /* Stats */
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-item {
            background-color: var(--card-bg);
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px var(--shadow);
            text-align: center;
            min-width: 120px;
            flex: 1;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* Skills */
        .skills-section {
            margin: 60px 0;
        }

        .skills-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .skill-item {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px var(--shadow);
        }

        .skill-name {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .skill-percent {
            color: var(--primary);
        }

        .skill-bar {
            height: 8px;
            background-color: var(--skill-track);
            border-radius: 4px;
            overflow: hidden;
        }

        .skill-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 4px;
            width: 0;
            transition: width 1.5s ease-out;
        }

        /* Quote */
        .quote-box {
            background-color: var(--quote-bg);
            padding: 30px;
            border-radius: 15px;
            margin: 40px 0;
            position: relative;
            box-shadow: 0 5px 15px var(--shadow);
        }

        .quote-box:before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 5rem;
            color: var(--primary);
            opacity: 0.2;
            font-family: serif;
            line-height: 1;
        }

        .quote-text {
            font-style: italic;
            font-size: 1.1rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .quote-author {
            text-align: right;
            font-weight: 500;
            color: var(--primary);
        }

        /* CTA */
        .cta-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.6);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Social links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px 0;
        }

        .social-link {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            color: var(--text);
            font-size: 1.2rem;
            box-shadow: 0 5px 15px var(--shadow);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            transform: translateY(-5px);
            color: white;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            box-shadow: 0 8px 20px rgba(108, 92, 231, 0.6);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 30px 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .profile-section, .bio-section {
                flex: 100%;
            }

            h1 {
                font-size: 2rem;
            }

            .stats {
                justify-content: center;
            }

            .stat-item {
                min-width: 100px;
            }
        }

        @media (max-width: 480px) {
            .skills-container {
                grid-template-columns: 1fr;
            }

            .cta-section {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header with Responsive Navigation -->
    <header class="main-header">
        <div class="container">
            <div class="header-inner">
                <a href="index.php" class="logo">
                    <span class="logo-text"><?php echo $sys->sys_name; ?></span>
                </a>
                
                <button class="mobile-menu-toggle" aria-label="Toggle navigation">
                    <span class="hamburger"></span>
                </button>
                
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li><a href="admin/pages_index.php" target="_blank" class="nav-link"><i class="fas fa-user-shield"></i> Admin Portal</a></li>
                        <li><a href="#" class="nav-link"><i class="fas fa-user-tie"></i> Staff Portal</a></li>
                        <li><a href="client/pages_client_index.php" target="_blank" class="nav-link"><i class="fas fa-user"></i> Client Portal</a></li>
                        <li><a href="client/pages_client_signup.php" target="_blank" class="btn btn-primary"><i class="fas fa-user-plus"></i> Join Us</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="particles-bg" id="particles-bg"></div>
    
    <div class="container">
        <header class="reveal">
            <h1>John Doe</h1>
            <p class="tagline">Creative Developer & Digital Designer</p>
        </header>

        <main>
            <div class="main-content">
                <section class="profile-section reveal">
                    <div class="profile-container">
                        <div class="avatar-frame"></div>
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" 
                             alt="Profile Avatar" 
                             class="profile-avatar">
                    </div>
                </section>

                <section class="bio-section reveal">
                    <h2>About Me</h2>
                    <p class="bio-text">
                        Hello! I'm John, a passionate full-stack developer with expertise in creating digital experiences. 
                        With over 5 years in the industry, I specialize in JavaScript frameworks, UI/UX design, and cloud solutions. 
                        I believe in clean, efficient code and intuitive user interfaces.
                    </p>

                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-number" id="exp-years">0</div>
                            <div class="stat-label">Years Experience</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" id="completed-projects">0</div>
                            <div class="stat-label">Completed Projects</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number" id="happy-clients">0</div>
                            <div class="stat-label">Happy Clients</div>
                        </div>
                    </div>

                    <div class="cta-section">
                        <a href="#" class="btn btn-primary" id="download-cv">
                            <i class="fas fa-download"></i> Download CV
                        </a>
                        <a href="#contact" class="btn btn-secondary">
                            <i class="fas fa-paper-plane"></i> Contact Me
                        </a>
                    </div>
                </section>
            </div>

            <section class="skills-section reveal">
                <h2>My Skills</h2>
                <div class="skills-container">
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>JavaScript</span>
                            <span class="skill-percent">95%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="95"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>React</span>
                            <span class="skill-percent">90%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="90"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Node.js</span>
                            <span class="skill-percent">85%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="85"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>UI/UX Design</span>
                            <span class="skill-percent">80%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="80"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>CSS/Sass</span>
                            <span class="skill-percent">92%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="92"></div>
                        </div>
                    </div>
                    <div class="skill-item">
                        <div class="skill-name">
                            <span>Python</span>
                            <span class="skill-percent">75%</span>
                        </div>
                        <div class="skill-bar">
                            <div class="skill-fill" data-percent="75"></div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="quote-box reveal">
                <p class="quote-text">
                    The only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle.
                </p>
                <p class="quote-author">— Steve Jobs</p>
            </div>

            <div class="social-links reveal">
                <a href="#" class="social-link" aria-label="GitHub">
                    <i class="fab fa-github"></i>
                </a>
                <a href="#" class="social-link" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link" aria-label="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="logo-text"><?php echo $sys->sys_name; ?></span>
                    <p><?php echo $sys->sys_tagline; ?></p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="admin/pages_index.php" target="_blank">Admin Portal</a></li>
                        <li><a href="staff/pages_staff_index.php" target="_blank">Staff Portal</a></li>
                        <li><a href="client/pages_client_index.php" target="_blank">Client Portal</a></li>
                        <li><a href="client/pages_client_signup.php" target="_blank">Sign Up</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h4>Contact Us</h4>
                    <p><i class="fas fa-envelope"></i> support@<?php echo strtolower(str_replace(' ', '', $sys->sys_name)); ?>.com</p>
                    <p><i class="fas fa-phone"></i> +1 (800) 123-4567</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $sys->sys_name; ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>

    <script>
        // Add scroll effect for transparent header
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.main-header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>

    <script>
        // Create particles
        function createParticles() {
            const particlesBg = document.getElementById('particles-bg');
            const particleCount = window.innerWidth < 768 ? 30 : 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size between 5px and 20px
                const size = Math.random() * 15 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random animation duration
                const duration = Math.random() * 20 + 10;
                particle.style.animationDuration = `${duration}s`;
                
                // Random delay
                particle.style.animationDelay = `${Math.random() * 10}s`;
                
                particlesBg.appendChild(particle);
            }
        }

        // Animated stats counter
        function animateStats() {
            const expYears = document.getElementById('exp-years');
            const completedProjects = document.getElementById('completed-projects');
            const happyClients = document.getElementById('happy-clients');
            
            const targetYears = 5;
            const targetProjects = 30;
            const targetClients = 25;
            
            let currentYears = 0;
            let currentProjects = 0;
            let currentClients = 0;
            
            const interval = setInterval(() => {
                if (currentYears < targetYears) {
                    currentYears++;
                    expYears.textContent = currentYears + '+';
                }
                
                if (currentProjects < targetProjects) {
                    currentProjects += 2;
                    if (currentProjects > targetProjects) currentProjects = targetProjects;
                    completedProjects.textContent = currentProjects + '+';
                }
                
                if (currentClients < targetClients) {
                    currentClients += 1;
                    if (currentClients > targetClients) currentClients = targetClients;
                    happyClients.textContent = currentClients + '+';
                }
                
                if (currentYears >= targetYears && 
                    currentProjects >= targetProjects && 
                    currentClients >= targetClients) {
                    clearInterval(interval);
                }
            }, 100);
        }

        // Animate skill bars
        function animateSkills() {
            const skillFills = document.querySelectorAll('.skill-fill');
            
            skillFills.forEach(fill => {
                const percent = fill.getAttribute('data-percent');
                fill.style.width = `${percent}%`;
            });
        }

        // Scroll reveal animation
        function scrollReveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            reveals.forEach(reveal => {
                const revealTop = reveal.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (revealTop < windowHeight - 100) {
                    reveal.classList.add('active');
                }
            });
        }

        // Download CV button effect
        document.getElementById('download-cv').addEventListener('click', (e) => {
            e.preventDefault();
            
            // In a real scenario, this would download a PDF
            // For demo purposes, we'll just show an alert
            alert('CV download would start here in a real implementation!');
            
            // Add a nice effect
            const btn = e.target.closest('.btn');
            btn.innerHTML = '<i class="fas fa-check"></i> Download Started!';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-download"></i> Download CV';
            }, 2000);
        });

        // Initialize everything
        document.addEventListener('DOMContentLoaded', () => {
            createParticles();
            animateStats();
            
            // Animate skills after a short delay to make it visible
            setTimeout(animateSkills, 500);
            
            // Set up scroll event listener
            window.addEventListener('scroll', scrollReveal);
            
            // Run once on load
            scrollReveal();
        });

        // Responsive adjustments
        window.addEventListener('resize', () => {
            // Recreate particles on resize
            const particlesBg = document.getElementById('particles-bg');
            particlesBg.innerHTML = '';
            createParticles();
        });
    </script>
</body>
</html>