<?php
session_start();

// Optional: Implement admin authentication here if you have an admin login system
// For example:
// if (!isset($_SESSION['admin_username'])) {
//     header("Location: admin_login.html"); // Redirect to admin login page
//     exit;
// }

require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/IP2-PROJECT/assets/backend/models/Client.php'; // Ensure this path is correct

// Fetch dynamic data
$totalClients = Client::getTotalClients();
$recentClients = Client::getRecentClients(5); // Get the 5 most recent clients
$pendingClients = Client::getPendingStatusClients(); // Get clients with 'Pending' status
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="../../assets/images/favicon (1).ico">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../assets/css/Admin_report.css">
</head>

<body>
    <nav>
        <div class="logo">
            <a href="../../index.html">EASY CALL</a>
        </div>
        <div class="small-screen">
            <input type="checkbox" id="check-box">
            <div class="links">
                <a href="../../index.html" style="--i:1">Home</a>
                <a href="admin-dashboard.html" style="--i:1">Dashboard</a>
                <a href="dashboard.php" style="--i:2">Reports</a>
            </div>
        </div>
    </nav>
    <header>
        <h1>Reports</h1>
    </header>
    <main>
        <section class="dashboard-section">
            <h2>Recent Activities (Recently Registered Clients)</h2>
            <ul class="recent-activities">
                <?php if (!empty($recentClients)): ?>
                    <?php foreach ($recentClients as $client): ?>
                        <li><?php echo htmlspecialchars($client['full_name']); ?> registered on <?php echo htmlspecialchars($client['registration_date']); ?>.</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No recent client registrations.</li>
                <?php endif; ?>
            </ul>

            <h2>Pending Requests (Clients with Pending Status)</h2>
            <ul class="pending-requests">
                <?php if (!empty($pendingClients)): ?>
                    <?php foreach ($pendingClients as $client): ?>
                        <li>Pending status for <?php echo htmlspecialchars($client['full_name']); ?> (Status: <?php echo htmlspecialchars($client['status']); ?>).</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No pending client requests.</li>
                <?php endif; ?>
            </ul>

            <h2>Total Clients</h2>
            <p><?php echo htmlspecialchars($totalClients); ?> clients currently registered.</p>

        </section>
    </main>
    <footer>
        <p class="copyright">&copy; 2024 All Rights Reserved.</p>
    </footer>
</body>

</html>