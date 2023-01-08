<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search engine-2</title>
</head>

<body>
    <h2>SEARCH FOR PRODUCT -2</h2>
    <form action="./ail.php" method="get">
        <input type="text" name="k" size="50" value="<?php $_GET['k']; ?>" />
        <input type="submit" value="Search" />
    </form>
    <hr />
    results
    <?php
    $k = $_GET['k'];
    $terms = explode(" ", $k);
    $query = "SELECT o.StoreName,p.ProductName,o.StoreID
    FROM tblstore AS o
    JOIN tblproduct as p
    ON o.StoreID=p.StoreID
    WHERE ";
    #echo $terms;
    $i = 0;
    foreach ($terms as $each) {
        #echo $each . "<b/>";
        $i++;
        if ($i == 1) {
            $query .= "p.Productname LIKE '$each' ";
        } else {
            $query .= "OR p.Productname LIKE '$each' ";
        }
    }
    //
    echo "<br>query=" . $query;
    echo "<br>";
    $con = mysqli_connect("localhost", "root", "", "db_multistore_locator");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    } else {
        echo "connected po";
    }


    $result = mysqli_query($con, $query);
    $query = mysqli_query($con, $query);
    $row_cnt = mysqli_num_rows($result);
    printf("Result set has %d rows.\n", $row_cnt);



    if (mysqli_num_rows($result) > 0) {
        // OUTPUT DATA OF EACH ROW
        while ($row = mysqli_fetch_assoc($result)) {
            //  $temp = $row["StoreID"];
            // echo "Store ID: " . $row["StoreID"]
            echo "Product Name: " . $row["ProductName"] . "<br>";
            echo "Store Name: " . $row["StoreName"];
            echo "<br>";
            echo "Store ID: " . $row["StoreID"];
            //echo "SELECT * FROM tblstore WHERE StoreID='$temp'";
            //$query2 = "SELECT * FROM tblstore WHERE StoreID='$temp'";
            // printf("Result set has %d rows.\n", $query2);
            #echo "store name:" . $result2;
            echo "<br>";
        }
    } else {
        echo "0 results";
    }
    /*
    // Perform query
    if ($result = mysqli_query($con, $query)) {
        echo "Returned rows are: " . mysqli_num_rows($result);
        // Free result set
        mysqli_free_result($result);
    }
*/

    mysqli_close($con);

    //
    /*
    $conn = mysqli_connect("localhost", 'root', "", "db_multistore_locator");
    if (!$conn) {
        echo "connection fail";
    } else {
        echo "connected";
    }
    echo "query=" . $query;
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)) {
        echo mysqli_num_rows($result);
        echo "found<br>";
    } else {
        echo "no found";
    }*/
    //connect database
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'db_multistore_locator');
    define("DB_PORT", "3306");

    //CREATE CONNECTIONs
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    //CHECK CONNECTION

    if ($conn->connect_error) {
        die("connection failded:" . $conn->connect_error);
    }
    echo "successfully connect";



    // $conn->close()
    // echo $query;

    ?>

    <?php

    ?>

</body>

</html>