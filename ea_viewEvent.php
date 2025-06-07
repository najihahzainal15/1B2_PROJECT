<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR VIEW EVENT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
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
    }

    .header-center p {
      margin: 0;
      font-size: 14px;
    }

    .nav {
      height: 100%;
      width: 170px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #0074e4;
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

    .content {
      background-color: #e6f0ff;
      margin-left: 160px;
      padding: 20px;
    }

    .logo {
      height: 40px;
      margin: 10px;
    }

    .logo2 {
      height: 35px;
      margin: 10px;
    }

    .register-btn-container {
      text-align: left;
      margin-left: 30px;
    }

    .register-btn {
      background-color: #0074e4;
      color: white;
      padding: 12px 20px;
      font-size: 16px;
      font-family: 'Poppins', sans-serif;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin: 10px 0;
      text-decoration: none;
      transition: 0.3s;
    }

    .register-btn:hover {
      background-color: #005bb5;
    }

    .event-table {
      width: 95%;
      margin-left: 30px;
      border-collapse: collapse;
      background-color: white;
    }

    .event-table th, .event-table td {
      border: 2px solid #666;
      padding: 10px;
      text-align: center;
    }

    .thead {
      background-color: #0096D6;
      color: white;
    }

    .action-buttons a {
      display: inline-block;
      padding: 6px 12px;
      margin: 3px 5px;
      font-size: 14px;
      font-weight: 600;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      font-family: 'Poppins', sans-serif;
    }

    .action-buttons a.edit {
      background-color: #4CAF50;
    }

    .action-buttons a.delete {
      background-color: #f44336;
    }

    .action-buttons a.qr {
      background-color: #0074e4;
    }

    .action-buttons a:hover {
      opacity: 0.85;
    }

    .submit-button {
      background-color: #0074e4;
      color: white;
      padding: 10px 20px;
      font-size: 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      margin: 20px 30px;
      font-family: 'Poppins', sans-serif;
    }

    .submit-button:hover {
      background-color: #005bb5;
    }

    .search-box {
      margin: 20px 1px;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-box input[type="text"] {
      padding: 10px 14px;
      border: 2px solid #0074e4;
      border-radius: 8px;
      font-size: 15px;
      width: 250px;
      font-family: 'Poppins', sans-serif;
    }

    .search-box input[type="text"]:focus {
      border-color: #005bb5;
      box-shadow: 0 0 6px rgba(0, 116, 228, 0.3);
      outline: none;
    }
  </style>
</head>

<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
    <div class="header-center">
      <h2>View Event</h2>
      <p>Event Advisor: Prof. Hakeem</p>
    </div>
    <div class="header-right">
      <a href="logout_button.php" class="logout">Logout</a>
      <a href="s_edit_profile.html"><img src="images/profile.png" alt="Profile" class="logo2"></a>
    </div>
  </div>

  <div class="nav">
    <div class="menu">
      <div class="item"><a href="ea_homepage.php">Dashboard</a></div>
      <div class="item">
        <a href="#events" class="sub-button">Events <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a class="active" href="ea_viewEvent.html">View Event</a>
          <a href="ea_registerEvent1.php">Register New Event</a>
          <a href="ea_eventCommittee.php">Event Committee</a>
          <a href="ea_committeeReg.php">Register Committee Member</a>
        </div>
      </div>
      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_attendanceSlot.php">Attendance Slot</a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="register-btn-container">
      <a href="ea_registerEvent1.php" class="register-btn">REGISTER NEW EVENT</a>
      <div class="search-box">
        <input type="text" id="searchEvent" placeholder="Search by event name..." />
        <input type="text" id="searchDate" placeholder="Search by date..." />
      </div>
    </div>

    
    <table class="event-table" data-sort-dir="asc">
      <thead class="thead">
        <tr>
          <th onclick="sortTable(0)">EVENT NAME</th>
          <th onclick="sortTable(1)">DATE</th>
          <th>STATUS</th>
          <th>EDIT / DELETE / QR</th>
        </tr>
      </thead>
      <tbody class="tbody">
        <tr><td>TechFront: Faculty of Computing Innovation Day</td><td>12 August 2025</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=10'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=10' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=10'>QR</a>
                  </td></tr><tr><td>CodeSprint: Annual Programming Challenge</td><td>25 August 2025</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=11'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=11' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=11'>QR</a>
                  </td></tr><tr><td>CompFair: Computing and IT Exhibition</td><td>1 September 202</td><td>POSTPONE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=12'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=12' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=12'>QR</a>
                  </td></tr><tr><td>CyberCon: Cybersecurity Awareness Seminar</td><td>5 September 202</td><td>CANCELED</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=13'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=13' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=13'>QR</a>
                  </td></tr><tr><td>AppThon: Mobile App Development Hackathon</td><td>10–11 September</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=14'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=14' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=14'>QR</a>
                  </td></tr><tr><td>DataDive: Data Science and AI Workshop</td><td>15 September 20</td><td>POSTPONE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=15'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=15' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=15'>QR</a>
                  </td></tr><tr><td>CompTalks: Industry Insights &amp; Career Sharing</td><td>20 September 20</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=16'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=16' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=16'>QR</a>
                  </td></tr><tr><td>DevConnect: Software Engineering Networking Day</td><td>22 September 20</td><td>POSTPONE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=17'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=17' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=17'>QR</a>
                  </td></tr><tr><td>FutureTech: Emerging Technologies Forum</td><td>1 October 2025</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=18'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=18' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=18'>QR</a>
                  </td></tr><tr><td>UXperience: Human-Computer Interaction Showcase</td><td>5 October 2025</td><td>CANCELED</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=19'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=19' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=19'>QR</a>
                  </td></tr><tr><td>FLUUTER PROMAX</td><td>2025-05-27</td><td>ACTIVE</td><td class='action-buttons'>
                    <a class='edit' href='ea_viewEventUpdate.php?id=21'>EDIT</a>
                    <a class='delete' href='ea_viewEventDelete.php?id=21' onclick="return confirm('Are you sure to delete this record?');">DELETE</a>
                    <a class='qr' href='ea_registerEvent2.php?id=21'>QR</a>
                  </td></tr>      </tbody>
    </table>

    <button class="submit-button">Back</button>
  </div>

  <script>
    $(document).ready(function () {
      $('.sub-button').click(function () {
        $(this).next('.sub-menu').slideToggle();
      });

      $('#searchEvent').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.event-table tbody tr').filter(function () {
          $(this).toggle($(this).children().eq(0).text().toLowerCase().indexOf(value) > -1);
        });
      });

      $('#searchDate').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.event-table tbody tr').filter(function () {
          $(this).toggle($(this).children().eq(1).text().toLowerCase().indexOf(value) > -1);
        });
      });
    });

    function sortTable(columnIndex) {
      const table = document.querySelector(".event-table");
      const tbody = table.tBodies[0];
      const rows = Array.from(tbody.rows);
      let isAsc = table.getAttribute("data-sort-dir") === "asc";

      rows.sort((a, b) => {
        let aText = a.cells[columnIndex].textContent.trim().toLowerCase();
        let bText = b.cells[columnIndex].textContent.trim().toLowerCase();
        return isAsc ? aText.localeCompare(bText) : bText.localeCompare(aText);
      });

      rows.forEach(row => tbody.appendChild(row));
      table.setAttribute("data-sort-dir", isAsc ? "desc" : "asc");
    }
  </script>
</body>
</html>
