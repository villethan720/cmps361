<?php

$apiURL = "https://sunfreshapi.onrender.com/api/v1/shipments";

//fetch data
$response = file_get_contents($apiURL);

//decode JSON
$data = json_decode($response, true);

//validate if data exists
if ($data && is_array($data)){
    //pagination
    $limit = 15;
    $totalRecords = count($data);
    $totalPages = ceil($totalRecords / $limit); //calculate number of pages

    //Capture the current page or set a default page
    $currentpage = isset($_GET['page']) ? (int)$_GET[('page')] : 1;
    $initialPage = ($currentPage - 1) * $limit;

    // calculate the starting index of the current page
    if ($currentpage < 1) {
        $currentpage = 1;
    } elseif ($currentpage > $totalPages){
        $currentpage = $totalPages;
    }

    $startIndex = ($currentpage - 1) * $limit;
    $pageData = array_slice($data, $startIndex, $limit);

    //build out table
    echo "<table border = '1' cell padding='10'>";
    echo "<threads>";
    echo "<tr>";
    echo "<th>Shipment ID</th>";
    echo "<th>Load Date</th>";
    echo "<th>Arrival Date</th>";
    echo "<th>Carrier ID</th>";
    echo "<th>Shipper</th>";
    echo "<th>Status</th>";
    echo "</tr>";
    echo "</thred>";
    echo "<tbody>";

    //loop through data
    foreach ($pageData as $post) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['shipemnt_id']) . "</td>";
        echo "<td>" . htmlspecialchars($post['load_date']) . "</td>";
        echo "<td>" . htmlspecialchars($post['arrival_date']) . "</td>";
        echo "<td>" . htmlspecialchars($post['carrier_id']) . "</td>";
        echo "<td>" . htmlspecialchars($post['shipper']) . "</td>";
        echo "<td>" . htmlspecialchars($post['status']) . "</td>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "Sorry there is no data available, try a different one";
}

for ($currentpage = 1; $currentpage <= $totalPages; $currentpage++){
    echo '<a href = "getData.php?page=' . $currentpage . '>' . $currentpage . '</a>';
}

?>