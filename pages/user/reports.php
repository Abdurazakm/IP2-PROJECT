<?php
session_start();

// Redirect to login page if user is not logged in or client data is not available
if (!isset($_SESSION['username']) || !isset($_SESSION['client_data'])) {
    header("Location: user_login.php");
    exit;
}

// Retrieve the entire client data array from the session
$client = $_SESSION['client_data'];

// If for some reason client data is empty (though checked above), handle it
if (!$client) {
    echo "No client data found for your account.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="icon" href="../../assets/images/favicon (1).ico">
    <link rel="stylesheet" href="../../assets/css/mystatus.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        xintegrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav>
        <div class="logo">
            <a href="../../index.html">EASY CALL</a>
        </div>
        <div class="small-screen">
            <input type="checkbox" name="" id="check-box">
            <div class="links">
                <a href="../../index.html" style="--i:1">Home</a>
                <a href="reports.php" style="--i:2">My Status</a>
                <a href="/IP2-PROJECT/pages/user/notifications.php" style="--i:4">Notifications</a>
            </div>
        </div>
    </nav>
    <header>
        <h1>My Status Reports</h1>
    </header>
    <main>
        <section class="wholereport">
            <section>
                <img src="../../assets/images/housemaid.jpg" alt="personal photo">
                <p>Full Name</p>
                <p class="value"><?php echo htmlspecialchars($client['full_name'] ?? '-'); ?></p>
                <!-- <p>Phone</p>
                <p class="value"><?php echo htmlspecialchars($client['phone'] ?? '-'); ?></p> -->
                <p>Nationality</p>
                <p class="value"><?php echo htmlspecialchars($client['nationality'] ?? '-'); ?></p>
                <p>Passport number</p>
                <p class="value"><?php echo htmlspecialchars($client['passport_number'] ?? '-'); ?></p>
                <p>Marital status</p>
                <p class="value"><?php echo htmlspecialchars($client['marital_status'] ?? '-'); ?></p>
            </section>
            <section class="section2">
                <div class="data_card_sections">
                    <h2>Job details</h2>
                    <p>Position</p>
                    <p class="value"><?php echo htmlspecialchars($client['job_type'] ?? '-'); ?></p>
                    <br>
                    <!-- <p>Employment time</p>
                    <p class="value"><?php echo htmlspecialchars($client['employment_time'] ?? '-'); ?></p> -->
                </div>
            </section>
            <section class="section2">
                <div class="data_card_sections">
                    <p>Registration Date</p>
                    <p class="value"><?php echo htmlspecialchars($client['registration_date'] ?? '-'); ?></p>
                </div>
                <!-- <div class="data_card_sections">
                    <p>Biometric CheckUp</p>
                    <p class="value"><?php echo htmlspecialchars($client['biometric_status'] ?? '-'); ?></p>
                </div> -->
                <div class="data_card_sections">
                    <p>Medical Status</p>
                    <p class="value"><?php echo htmlspecialchars($client['medical_status'] ?? '-'); ?></p>
                </div>
                <div class="data_card_sections">
                    <p>Flight Date</p>
                    <p class="value"><?php echo htmlspecialchars($client['flight_date'] ?? '-'); ?></p>
                </div>
            </section>
        </section>
    </main>
    <footer>
        <p class="copyright">&copy; 2024 All Rights Reserved.</p>
    </footer>
</body>

</html>
