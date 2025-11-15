<!-- ABOUT US PAGE – FIXSENSE -->
<!-- Copy into Google-Sites, WordPress, or raw HTML file -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us | FixSense</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{--primary:#0d47a1;--accent:#ffab00;--light:#f5f7fa;--dark:#222;}
    *{box-sizing:border-box;margin:0;padding:0;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;}
    body{background:var(--light);color:var(--dark);line-height:1.6;}
    .container{max-width:1000px;margin:auto;padding:2rem 1.5rem;}
    h1,h2,h3{color:var(--primary);}
    h1{font-size:2.2rem;margin-bottom:.5rem;}
    h2{font-size:1.6rem;margin:1.5rem 0 .5rem;}
    h3{font-size:1.2rem;margin:.75rem 0 .25rem;}
    p{margin-bottom:1rem;}
    .tagline{font-size:1.1rem;font-style:italic;color:var(--accent);}
    .grid{display:grid;gap:1.5rem;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));}
    .card{background:#fff;border-radius:8px;padding:1.5rem;box-shadow:0 2px 6px rgba(0,0,0,.08);}
    .team{display:flex;flex-wrap:wrap;gap:1.5rem;}
    .member{flex:1 1 200px;text-align:center;}
    .member img{width:120px;height:120px;border-radius:50%;object-fit:cover;margin-bottom:.75rem;}
    .values ul{list-style:none;padding-left:0;}
    .values li{background:var(--primary);color:#fff;margin:.35rem 0;padding:.5rem .75rem;border-radius:4px;}
    footer{text-align:center;padding:1.5rem 0;font-size:.9rem;color:#777;}
  </style>
</head>
<body>
  <div class="container">
    <h1>About FixSense</h1>
    <p class="tagline">Interactive Automotive Troubleshooting – Anytime, Anywhere.</p>

    <h2>Who We Are</h2>
    <p>FixSense is a student-built, web-based learning platform created by final-year Diploma in Information Technology students from <strong>Institut Latihan Perindustrian Kuantan (ILP Kuantan)</strong>, Malaysia.  Our team blends hands-on automotive experience with modern software development to solve a real-world problem: <em>limited access to practical troubleshooting training.</em></p>

    <div class="grid">
      <div class="card">
        <h3>Our Mission</h3>
        <p>To give every TVET learner unlimited, risk-free practice on realistic automotive faults through interactive simulations and AI-guided support.</p>
      </div>
      <div class="card">
        <h3>Our Vision</h3>
        <p>Become the leading micro-learning platform for technical troubleshooting across ASEAN vocational colleges and beyond.</p>
      </div>
    </div>

    <h2>Meet the Team</h2>
    <div class="team">
      <div class="member">
        <img src="img_members/ajim1.jpg" alt="Nazim">
        <h4>Mohamad Nazim bin Naspudin</h4>
        <p>Project Lead & Full-Stack Developer</p>
      </div>
      <div class="member">
        <img src="img_members/imad1.jpg" alt="Imaduddin">
        <h4>Ahmad Imaduddin bin Ahmad Kailani</h4>
        <p>Simulation Content Designer</p>
      </div>
      <div class="member">
        <img src="img_members/adib1.jpg" alt="Adib">
        <h4>Adib Farhan bin Khairul Nizam</h4>
        <p>AI Chatbot & Database Engineer</p>
      </div>
    </div>

    <h2>Supervisor</h2>
    <p><strong>Pn. Siti Zaharah binti Sidek</strong><br>
    Lecturer, Department of Information Technology & Communication, ILP Kuantan.</p>

    <h2>What We Built</h2>
    <ul>
      <li><strong>Step-by-step troubleshooting simulations</strong> for engine, brake, air-suspension & more.</li>
      <li><strong>Instant feedback engine</strong> – every click is evaluated and explained.</li>
      <li><strong>Lecturer dashboard</strong> – create new cases, monitor class scores, export PDF reports.</li>
      <li><strong>AI chatbot assistant</strong> – answers technical questions 24/7 using plain English.</li>
      <li><strong>Role-based access</strong> – Students, Lecturers, Admins each get only the tools they need.</li>
    </ul>

    <h2>Core Values</h2>
    <div class="values">
      <ul>
        <li>Learner-centric design</li>
        <li>Evidence-based content (JIS, SAE, OEM manuals)</li>
        <li>Open to iterative feedback (Agile methodology)</li>
        <li>Data privacy & security</li>
        <li>Low-bandwidth friendly (works on 3G)</li>
      </ul>
    </div>

    <h2>Contact & Collaboration</h2>
    <p>Email: <a href="mailto:fixsense25@gmail.com">fixsense25@gmail.com</a><br>
    <p>We welcome industry partnerships, research collaborations and translation volunteers to bring FixSense to more languages.</p>
  </div>

  <footer>
    &copy; <span id="yr"></span> FixSense FYP Team. All rights reserved.
  </footer>
  <script>document.getElementById('yr').textContent = new Date().getFullYear();</script>
</body>
</html>