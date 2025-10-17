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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $sys->sys_name; ?> - <?php echo $sys->sys_tagline; ?>">
    <title><?php echo $sys->sys_name; ?> - <?php echo $sys->sys_tagline; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Add these in your head section -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
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

    <!-- Hero Section -->
    <section class="hero">
        <!-- Video Background -->
        <div class="video-background">
            <video autoplay muted loop playsinline>
                <!-- Provide multiple video formats for compatibility -->
                <!-- <source src="video.mp4" type="video/mp4"> -->
                <source src="vid.gif" type="video/webm">
                <!-- Fallback image if video doesn't load -->
                <img src="assets/images/hero-fallback.jpg" alt="Banking background">
            </video>
            <div class="video-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo $sys->sys_name; ?></h1>
                <p class="hero-subtitle"><?php echo $sys->sys_tagline; ?></p>
                <div class="hero-actions">
                    <a href="client/pages_client_signup.php" target="_blank" class="btn btn-accent btn-large">Get Started <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="hero-wave"></div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Choose Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure Banking</h3>
                    <p>Advanced security measures to protect your finances.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Access</h3>
                    <p>Bank anytime, anywhere with our mobile platform.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>Our team is always ready to assist you.</p>
                </div>
            </div>
        </div>
    </section>

    <div id="particles-bg" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden;"></div>
    
    <div style="max-width: 1200px; margin: 0 auto; padding: 20px; padding-top: 100px;">
        <header class="reveal" style="text-align: center; padding: 40px 0; opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
            <h1 style="font-size: 2.5rem; margin-bottom: 10px; letter-spacing: 1px; background: linear-gradient(45deg, #6c5ce7, #a29bfe); -webkit-background-clip: text; background-clip: text; color: transparent; display: inline-block;">Abdullahi Abdiweli Adam</h1>
            <p style="color: #636e72; font-weight: 300; font-size: 1.1rem;">Creative Developer & Digital Designer</p>
        </header>

        <main>
            <div style="display: flex; flex-wrap: wrap; gap: 40px; margin: 40px 0;">
                <section class="reveal" style="flex: 1; min-width: 300px; opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
                    <div style="position: relative; perspective: 1000px; max-width: 400px; margin: 0 auto;">
                        <div style="position: absolute; top: 20px; left: 20px; width: 100%; height: 100%; border: 3px solid #6c5ce7; border-radius: 20px; z-index: -1; transform: rotate(3deg); transition: transform 0.5s ease;"></div>
                        <img src="myimage22.jpg" 
                             alt="Profile Avatar" 
                             style="width: 100%; height: auto; border-radius: 20px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); transform-style: preserve-3d; transition: transform 0.5s ease, box-shadow 0.5s ease; backface-visibility: hidden;">
                    </div>
                </section>
                <section class="reveal" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; justify-content: center; opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
                    <h2 style="font-size: 2rem; margin-bottom: 20px; position: relative; display: inline-block;">About Me</h2>
                    <p style="margin-bottom: 30px; color:rgb(19, 27, 30); font-weight: 300;">
                        Hello! I'm Abdullahi, a passionate Frontend and Backend developer with expertise in creating digital experiences. 
                        With over 1 year, I specialize in JavaScript frameworks, UI/UX design, and Backend languages like PHP and MYSQL. 
                        I believe in clean, efficient code and intuitive user interfaces.
                    </p>

                    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
                        <div style="background-color: #ffffff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); text-align: center; min-width: 120px; flex: 1;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #6c5ce7; margin-bottom: 5px;" id="exp-years">0</div>
                            <div style="font-size: 0.9rem; color: #636e72;">Years Experience</div>
                        </div>
                        <div style="background-color: #ffffff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); text-align: center; min-width: 120px; flex: 1;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #6c5ce7; margin-bottom: 5px;" id="completed-projects">0</div>
                            <div style="font-size: 0.9rem; color: #636e72;">Completed Projects</div>
                        </div>
                        <div style="background-color: #ffffff; padding: 15px 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); text-align: center; min-width: 120px; flex: 1;">
                            <div style="font-size: 1.8rem; font-weight: 700; color: #6c5ce7; margin-bottom: 5px;" id="happy-clients">0</div>
                            <div style="font-size: 0.9rem; color: #636e72;">Happy Clients</div>
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; gap: 20px; margin: 40px 0; flex-wrap: wrap;">
                        <a href="#" style="padding: 12px 30px; border-radius: 50px; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(45deg, #6c5ce7, #a29bfe); color: white; box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4); transform: scale(1);" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 20px rgba(108, 92, 231, 0.6)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 5px 15px rgba(108, 92, 231, 0.4)'" 
                        id="download-cv">
                            <i class="fas fa-download"></i> Download CV
                        </a>
                        <a href="#contact" style="padding: 12px 30px; border-radius: 50px; font-weight: 500; text-decoration: none; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 10px; background-color: transparent; color: #6c5ce7; border: 2px solid #6c5ce7;" onmouseover="this.style.backgroundColor='#6c5ce7'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6c5ce7'">
                            <i class="fas fa-paper-plane"></i> Contact Me
                        </a>
                    </div>
                </section>
            </div>

            <section class="reveal" style="margin: 60px 0; opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
                <h2 style="font-size: 2rem; margin-bottom: 20px; position: relative; display: inline-block;">My Skills</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-top: 30px;">

                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-js-square" style="color: #f1c40f; margin-right: 8px;"></i>JavaScript</span>
                            <span style="color: #6c5ce7;">95%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="95"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-react" style="color: #61dafb; margin-right: 8px;"></i>React</span>
                            <span style="color: #6c5ce7;">50%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="90"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-node-js" style="color: #2ecc71; margin-right: 8px;"></i>Node.js</span>
                            <span style="color: #6c5ce7;">30%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="85"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fas fa-pencil-ruler" style="color: #e67e22; margin-right: 8px;"></i>UI/UX Design</span>
                            <span style="color: #6c5ce7;">85%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="80"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-css3-alt" style="color: #3498db; margin-right: 8px;"></i>CSS/Sass</span>
                            <span style="color: #6c5ce7;">95%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="92"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-python" style="color: #306998; margin-right: 8px;"></i>Python</span>
                            <span style="color: #6c5ce7;">80%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="75"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fab fa-php" style="color: #7a86b8; margin-right: 8px;"></i>PHP</span>
                            <span style="color: #6c5ce7;">65%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="75"></div>
                        </div>
                    </div>
                    <div style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 500;">
                            <span><i class="fas fa-database" style="color: #16a085; margin-right: 8px;"></i>Database</span>
                            <span style="color: #6c5ce7;">90%</span>
                        </div>
                        <div style="height: 8px; background-color: #f5f6fa; border-radius: 4px; overflow: hidden;">
                            <div style="height: 100%; background: linear-gradient(90deg, #6c5ce7, #a29bfe); border-radius: 4px; width: 0; transition: width 1.5s ease-out;" data-percent="75"></div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="reveal" style="background-color: #f1f1f1; padding: 30px; border-radius: 15px; margin: 40px 0; position: relative; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
                <p style="font-style: italic; font-size: 1.1rem; margin-bottom: 10px; position: relative; z-index: 1;">
                    The only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle.
                </p>
                <p style="text-align: right; font-weight: 500; color: #6c5ce7;">— Steve Jobs</p>
            </div>

            <div class="reveal" style="display: flex; justify-content: center; gap: 20px; margin: 40px 0; opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease;">
                <a href="#" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; color: #2d3436; font-size: 1.2rem; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; text-decoration: none;" aria-label="GitHub"onmouseover="this.style.background='linear-gradient(45deg, #6c5ce7, #a29bfe)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(108, 92, 231, 0.4)'"onmouseout="this.style.background='#ffffff'; this.style.color='#2d3436'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)'">
                    <i class="fab fa-github"></i>
                </a>
                <a href="#"  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; color: #2d3436; font-size: 1.2rem; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; text-decoration: none;"  aria-label="LinkedIn" onmouseover="this.style.background='linear-gradient(45deg, #6c5ce7, #a29bfe)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(108, 92, 231, 0.4)'"onmouseout="this.style.background='#ffffff'; this.style.color='#2d3436'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)'">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; color: #2d3436; font-size: 1.2rem; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; text-decoration: none;"  aria-label="Twitter" onmouseover="this.style.background='linear-gradient(45deg, #6c5ce7, #a29bfe)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(108, 92, 231, 0.4)'" onmouseout="this.style.background='#ffffff'; this.style.color='#2d3436'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)'">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background-color: #ffffff; color: #2d3436; font-size: 1.2rem; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: all 0.3s ease; text-decoration: none;" aria-label="Email" onmouseover="this.style.background='linear-gradient(45deg, #6c5ce7, #a29bfe)'; this.style.color='white'; this.style.boxShadow='0 5px 15px rgba(108, 92, 231, 0.4)'"onmouseout="this.style.background='#ffffff'; this.style.color='#2d3436'; this.style.boxShadow='0 5px 15px rgba(0, 0, 0, 0.1)'">
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
                    <p><i class="fas fa-phone"></i> +252 613667595</p>
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

        document.addEventListener('DOMContentLoaded', () => {
            const featuresGrid = document.querySelector('.features-grid');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                    }
                });
            }, { threshold: 0.1 });
            
            if (featuresGrid) {
                observer.observe(featuresGrid);
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
                particle.style.position = 'absolute';
                particle.style.backgroundColor = 'rgba(108, 92, 231, 0.09)';
                particle.style.borderRadius = '50%';
                particle.style.animation = 'float 15s infinite linear';
                
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
            const skillFills = document.querySelectorAll('[data-percent]');
            
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
                    reveal.style.opacity = '1';
                    reveal.style.transform = 'translateY(0)';
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
            const btn = e.target.closest('a');
            btn.innerHTML = '<i class="fas fa-check"></i> Download Started!';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-download"></i> Download CV';
            }, 2000);
        });

        // Initialize everything
        document.addEventListener('DOMContentLoaded', () => {
            // Add float animation keyframes
            const style = document.createElement('style');
            style.textContent = `
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
            `;
            document.head.appendChild(style);
            
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
<?php } ?>