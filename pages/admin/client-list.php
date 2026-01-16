<?php
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
require_once __DIR__ . '/../../assets/backend/models/TableData.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client List</title>
    <link rel="icon" href="../../assets/images/favicon (1).ico">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="../../assets/css/client_list.css"><!--1st change linking with more specicfic css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .page-link {
            display: inline-block;
            padding: 8px 14px;
            margin: 5px;
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            color: #333;
            /* text-decoration: none; 007BFF*/
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .page-link:hover {
            background-color: rgb(4, 155, 72);
            color: #fff;
            border-color: #007BFF;
        }

        .page-link.active {
            background-color: rgb(4, 155, 72);
            ;
            color: #fff;
            border-color: #0056b3;
        }

        #searchForm {
            width: max-content;
            display: flex;
            align-items: center;
            padding: 14px;
            border-radius: 28px;
            background-color: rgb(252, 252, 252);
        }

        #search-input {
            font-size: 16px;
            font-family: 'Lexend', sans-serif;
            margin-left: 14px;
            color: #333333;
            outline: none;
            border: none;
            background: transparent;
        }
    </style>
</head>

<body id="client-listss">
    <nav>
        <div class="logo">
            <a href="../../index.html">EASY CALL</a>
        </div>
        <div class="small-screen">
            <input type="checkbox" name="" id="check-box">
            <div class="links">
                <a href="../../index.html" style="--i:1">Home</a>
                <a href="admin-dashboard.html" style="--i:1">Dashboard</a>
            </div>
        </div>
    </nav>
    <header>
        <div class="header-container">
            <h1>Registered Clients</h1>
            <!-- Added search bar -->
            <div class="Search-bar">
                <form id="searchForm" action="#" method="get">
                    <i id="search-Icon" class="fas fa-search" style="cursor: pointer;"></i>
                    <input id="search-input" type="search" name="search" placeholder="Search">
                </form>
            </div>

            <script>
                document.getElementById('search-Icon').addEventListener('click', function() {
                    document.getElementById('searchForm').submit();
                });
            </script>

        </div>
    </header>

    <main>
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Passport Number</th>
                        <th>Nationality</th>
                        <th>Medical Status</th>
                        <th>Job Type</th>
                        <th>Martial Status</th>
                        <th>Registration Date</th>
                        <th>Flight Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($rows)) {
                        echo "<tr><td colspan='10'><p  style='text-align:center;'>Nothing to show here</p></td></tr>";
                    } else {
                        foreach ($rows as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['age']); ?></td>
                                <td><?php echo htmlspecialchars($row['passport_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                                <td><?php echo htmlspecialchars($row['medical_status']); ?></td>
                                <td><?php echo htmlspecialchars($row['job_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['marital_status']); ?></td>
                                <td><?php echo htmlspecialchars($row['registration_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['flight_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                    <?php endforeach;
                    } ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo; Prev</a>
                <?php endif; ?>

                <?php if ($page > 8) {
                    $i = $page - 4;
                    $max = $page + 4;
                } else {
                    $i = 1;
                    $max = 9;
                }
                for ($i; $i <= $total_pages && $i <= $max; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="page-link <?php echo ($i == $page) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next &raquo;</a>
                <?php endif; ?>
            </div>

        </div>
    </main>
    <footer>
        <p class="copyright">&copy; 2024 All Rights Reserved.</p>
    </footer>
    <script src="../../assets/javascript/javascript.js"></script>

</body>

</html>