<?php
require("connection.php");
    // SQL query
    $sql = "SELECT full_name, age, passport_number, nationality, medical_status, job_type, marital_status, registration_date, flight_date, status FROM your_table_name";

    // Execute query using $pdo->query()  because it returns a set of values. but $pdo->exec() only returns the number of row affected
    $connection=dbConnect();   //the function returns the connection object
    if($connection){
        $statement = $connection->query($sql);

        // Fetch rows
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo "0 results";
        }
    }
    else{
        echo "cannot connect to the db";
    }




// we will make the a single displayed informatin 20-30 lists only 
//   - to make the data not boring
//   - because we take data from the database its better to come with small data at a time for UI performance and also optimize storage usage in local machine(storing size in the array).
?>