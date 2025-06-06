<!DOCTYPE html>
<html>

<head>
  <title> EVENT ADVISOR MERIT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyPetakom Event Advisor Homepage</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    p {
      margin: 0px 40px;
      font-size: 16px;
    }

    .p1 {
      margin: 5px;
      font-size: 14px;
    }


    h2 {
      margin: 0px 40px;
      font-size: 25px;
      color: black;
    }


    .nav {
      height: 100%;
      width: 170px;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: #0074e4;
      overflow-x: hidden;
      padding-top: 20px;
    }

    .nav a {
      padding: 6px 8px 6px 16px;
      margin: 10px;
      text-decoration: none;
      font-size: 16px;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .nav a.active {
      background-color: #0264c2;
      color: white;
    }

    .nav a:hover {
      background-color: #0264c2;
      transition: all 0.4s ease;
    }

    .sub-menu {
      background: #044e95;
      display: none;
    }

    .sub-menu a {
      padding-left: 30px;
      font-size: 12px;
    }
	
	form label {
  font-weight: bold;
}

form select,
form button {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
}





    .content {
      margin-left: 150px;
      padding: 20px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      overflow-x: auto;
      /* allow horizontal scroll if needed */
    }

    .table-container {
      padding: 40px;
      background-color: #F2F2F2;
      width: 150%;
      /* Increased from 80% */
      max-width: 1400px;
      /* Optional: limits max width on very large screens */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }


    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: auto;
      word-wrap: break-word;
      /* wrap long text */
      font-size: 13px;
      /* slightly smaller font */
    }

    table th,
    table td {
      padding: 15px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
      word-wrap: break-word;
      /* wrap long text */
      white-space: normal;
      /* allow wrapping */
    }

    table th {
      background-color: #0096D6;
      color: white;
    }

    th:nth-child(4),
    td:nth-child(4) {
      width: 15%;
      /* Increase width */
    }

    th:nth-child(6),
    td:nth-child(6) {
      width: 20%;

    }

    th:nth-child(1),
    td:nth-child(1) {
      width: 11%;

    }

    th:nth-child(2),
    td:nth-child(2) {
      width: 8%;

    }

    th:nth-child(3),
    td:nth-child(3) {
      width: 8%;

    }


    th:nth-child(5),
    td:nth-child(5) {
      width: 13%;

    }


    .header1 {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #0074e4;
      padding: 10px 20px;
      margin-left: 160px;
      color: white;
    }

    .header-right {
      display: flex;
      align-items: center;
    }

    .header-right .logout {
      color: white;
      font-size: 14px;
      margin-right: 15px;
      /* space between Logout and profile icon */
      text-decoration: none;
      transition: color 0.3s;
    }

    .header-right .logout:hover {
      color: #ddd;
    }

    .header-center {
      text-align: center;
      flex-grow: 1;
    }

    .header-center h2 {
      margin: 0;
      font-size: 22px;
      color: white;
    }

    .header-center p {
      margin: 0;
      font-size: 14px;
    }


    .logo {
      height: 40px;
      margin: 10px;
    }

    .logo2 {
      height: 35px;
      margin: 10px;
    }

    table thead th {
      background-color: #0096D6;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tbody tr:hover {
      background-color: #e0f0ff;
      transition: background-color 0.2s ease;
    }

    table td,
    table th {
      padding: 12px 10px;
      text-align: center;
      vertical-align: middle;
      border: 1px solid #ddd;
    }

    a {
      color: #0066cc;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    td a {
      margin: 0 4px;
    }



    .content {
      margin-left: 170px;
      padding: 10px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
    }

    .table-container {
      padding: 20px;
      background-color: #F2F2F2;
      max-width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
    }

    @media (max-width: 768px) {
      .nav {
        width: 100px;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      table th,
      table td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 11px;
        padding: 6px 4px;
      }

      table th {
        background-color: #0096D6;
        color: white;
      }
  </style>
</head>

<body>

  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
    <div class="header-center">
      <h2>Merit Application</h2>
      <p>Petakom Coordinator: Dr. Haneef</p>
    </div>
    <div class="header-right">
      <a href="logout_button.php" class="logout">Logout</a>
      <a href="c_displayProfile.php">
        <img src="images/profile.png" alt="Profile" class="logo2">
      </a>
    </div>
  </div>

  <div class="nav">
    <div class="menu">
      <div class="item"><a href="c_homepage.php">Dashboard</a></div>

      <div class="item">
        <a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="c_manageProfile.php" class="sub-item">Manage Profile</a>
          <a href="c_addNewUser.php" class="sub-item">Add New User</a>
        </div>
      </div>

      <div class="item">
        <a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="c_membership.php" class="sub-item">Membership Approval</a>
        </div>
      </div>

      <div class="item">
        <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="#events" class="sub-item">View Event</a>
          <a class="active" href="c_meritApp.php" class="sub-item">Merit Application</a>
        </div>
      </div>
    </div>
  </div>



  <div class="content">
    <div class="table-container">
      <div class="section-header">MERIT APPLICATION</div>
      <table border="1" cellspacing="0" cellpadding="5">
        
		<form method="GET" style="margin-bottom: 20px; text-align: right;">
  <label for="status">Filter by Merit Status:</label>
  <select name="status" id="status" style="padding: 6px 10px; border-radius: 5px; border: 1px solid #ccc; margin-left: 10px;">
    <option value="">-- All --</option>
    <option value="Pending" >Pending</option>
    <option value="Approved" >Approved</option>
    <option value="Rejected" >Rejected</option>
  </select>
  <button type="submit" style="padding: 6px 12px; background-color: #0074e4; color: white; border: none; border-radius: 5px; margin-left: 10px;">Search</button>
</form>

		<thead>
          <tr>
            <th>EVENT NAME</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>GEOLOCATION</th>
            <th>VENUE</th>
            <th>DESCRIPTION</th>
            <th>APPROVAL LETTER</th>
            <th>MERIT SCORE</th>
            <th>STATUS</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>TechFront: Faculty of Computing Innovation Day</td><td>12 August 2025</td><td>09:00 AM – 04:00 PM</td><td>2.9235, 101.7726</td><td>Computing Hall B</td><td>A showcase of student innovations and research in computing and IT.</td><td>
  <a href='uploads/1748083463_Approval_Letter1.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td>Pending</td><td>
    <a href='c_meritAppUpdate3.php?eventID=10'>EDIT</a>

    
</td><tr><td>CodeSprint: Annual Programming Challenge</td><td>25 August 2025</td><td>10:00 AM – 05:00 PM</td><td>2.9238, 101.7732</td><td>Lab 2 &amp; Online</td><td>A competitive programming event to test algorithmic thinking and coding skills.</td><td>
  <a href='uploads/1748083676_Approval_Letter2.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td>Pending</td><td>
    <a href='c_meritAppUpdate3.php?eventID=11'>EDIT</a>

    
</td><tr><td>CompFair: Computing and IT Exhibition</td><td>1 September 202</td><td>09:00 AM – 03:00 PM</td><td>2.9240, 101.7710</td><td>Main Concourse</td><td>An exhibition highlighting the latest in computing projects, tools, and tech demos.</td><td>
  <a href='uploads/1748084002_Approval_Letter3.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td>Approved</td><td>
    <a href='c_meritAppUpdate3.php?eventID=12'>EDIT</a>

    
</td><tr><td>CyberCon: Cybersecurity Awareness Seminar</td><td>5 September 202</td><td>02:00 PM – 05:00 PM</td><td>2.9231, 101.7738</td><td>Lecture Hall D</td><td>A seminar on current cybersecurity threats and best practices for digital safety.</td><td>
  <a href='uploads/1748084065_Approval_Letter4.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=13'>EDIT</a>

    
</td><tr><td>AppThon: Mobile App Development Hackathon</td><td>10–11 September</td><td>09:00 AM – 06:00 PM</td><td>2.9245, 101.7735</td><td>Innovation Lab</td><td>A 2-day hackathon focused on developing mobile apps that solve real-world problems.</td><td>
  <a href='uploads/1748084114_Approval_Letter5.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=14'>EDIT</a>

    
</td><tr><td>DataDive: Data Science and AI Workshop</td><td>15 September 20</td><td>10:00 AM – 04:00 PM</td><td>2.9237, 101.7722</td><td>Smart Lab 1</td><td>A hands-on workshop exploring data analysis, machine learning, and AI applications.</td><td>
  <a href='uploads/1748084164_Approval_Letter6.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=15'>EDIT</a>

    
</td><tr><td>CompTalks: Industry Insights &amp; Career Sharing</td><td>20 September 20</td><td>02:00 PM – 05:00 PM</td><td>0.0000, 0.0000 (Online)</td><td>Zoom (Online)</td><td>A virtual talk featuring professionals sharing career experiences in computing fields.</td><td>
  <a href='uploads/1748084205_Approval_Letter7.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=16'>EDIT</a>

    
</td><tr><td>DevConnect: Software Engineering Networking Day</td><td>22 September 20</td><td>10:00 AM – 03:00 PM</td><td>2.9236, 101.7729</td><td>Faculty Atrium</td><td>A networking event connecting software engineering students with industry experts.</td><td>
  <a href='uploads/1748084258_Approval_Letter8.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=17'>EDIT</a>

    
</td><tr><td>FutureTech: Emerging Technologies Forum</td><td>1 October 2025</td><td>09:00 AM – 12:00 PM</td><td>2.9242, 101.7721</td><td>Auditorium A</td><td>A forum discussing the latest emerging trends in computing technology.</td><td>
  <a href='uploads/1748084300_Approval_Letter9.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=18'>EDIT</a>

    
</td><tr><td>UXperience: Human-Computer Interaction Showcase</td><td>5 October 2025</td><td>10:00 AM – 02:00 PM</td><td>2.9239, 101.7718</td><td>Design Lab</td><td>A showcase of innovative and user-centered HCI projects by students.</td><td>
  <a href='uploads/1748084348_Approval_Letter10.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=19'>EDIT</a>

    
</td><tr><td>FLUUTER PROMAX</td><td>2025-05-27</td><td>15:45</td><td>2.9235, 101.7726</td><td>DEWAN PEKAN</td><td>BLE</td><td>
  <a href='uploads/1748320976_Approval_Letter2.pdf' target='_blank'>

    <button style='padding: 5px 10px; background-color: #0074e4; color: white; border: none; border-radius: 5px;'>View</button>
  </a>
</td><td>3</td><td></td><td>
    <a href='c_meritAppUpdate3.php?eventID=21'>EDIT</a>

    
</td>        </tbody>
      </table>

    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.sub-button').click(function() {
        $(this).next('.sub-menu').slideToggle();
      });
    });
