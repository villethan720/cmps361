<?php

$apiURL = "https://sunfreshapi.onrender.com/api/v1/shipments";

//fetch data
$response = file_get_contents($apiURL);

//decode JSON
$data = json_decode($response, true);

//validate if data exists
if ($data && is_array($data)){
    //pagination
    $limit = 10;
    $totalRecords = count($data);
    $totalPages = ceil($totalRecords / $limit); //calculate number of pages

    //Capture the current page or set a default page
    $currentPage = isset($_GET['page']) ? (int)$_GET[('page')] : 1;
    $initialPage = ($currentPage - 1) * $limit;

    // ensure current page is within valid range
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages){
        $currentPage = $totalPages;
    }

    //sorting logic
    $sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'shipment'; //default sort by id
    $sortOrder = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc'; //default order is 'asc' or ascending

    //sort data based on column and order
    usort($data, function($a, $b) use ($sortColumn, $sortOrder) {
        if ($sortOrder == 'asc') {
            return strcmp($a[$sortColumn], $b[$sortColumn]);
        } else {
            return strcmp($b[$sortColumn], $a[$sortColumn]);
        }
    });

    //calculate starting index of current page
    $startIndex = ($currentPage - 1) * $limit;

    //get subset of data for current page
    $pageData = array_slice($data, $startIndex, $limit);

    //function to toggle sort order
    function toggleOrder($currentOrder) {
        return $currentOrder == 'asc' ? 'desc' : 'asc';
    }

    //build out table display it in grid view (HTML)
    echo "<table border = '1' cell padding='10'>";
    echo "<threads>";
    echo "<tr>";
    echo "<th><a href='?page=$currentPage&sort=shipment_id&order=" . toggleOrder($sortOrder) . "'>Shipment ID</a></th>";
    echo "<th><a href='?page=$currentPage&sort=load_date&order=" . toggleOrder($sortOrder) . "'>Load Date</a></th>";
    echo "<th><a href='?page=$currentPage&sort=arrival_date&order=" . toggleOrder($sortOrder) . "'>Arrival Date</a></th>";
    echo "<th><a href='?page=$currentPage&sort=carrier_id&order=" . toggleOrder($sortOrder) . "'>Carrier ID</a></th>";
    echo "<th><a href='?page=$currentPage&sort=shipper&order=" . toggleOrder($sortOrder) . "'>Shipper</a></th>";
    echo "<th><a href='?page=$currentPage&sort=status&order=" . toggleOrder($sortOrder) . "'>Status</a></th>";
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

//pagination links
echo "<div style='margin-top: 20px;'>";

//display previous link if not on the first page
if ($currentPage > 1) {
    echo '<a href=?page=' . ($currentPage - 1) . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">Previous</a> ';
}

//Display page numbers
for ($i = 1; $i <= $totalPages; $i++){
    if ($i == $currentPage) {
        echo "<strong>$i</strong> ";
    } else {
        echo'<a href="?page=' . ($currentPage + 1) . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">' . $i . '</a>';
    }
}

//Display "next link if not on last page
if ($currentPage < $totalPages) {
    echo '<a href="?page=' . ($currentPage + 1) . '&sort=' . $sortColumn . '&order=' . $sortOrder . '">Next</a>';
}

echo "</div>";

//display total number of records at the bottom
echo "<div style='margin-top: 20px;'>";
echo "<strong>Total Records: $totalRecords</strong>";
echo "</div>";


//for ($currentpage = 1; $currentpage <= $totalPages; $currentpage++){
  //  echo '<a href = "getData.php?page=' . $currentpage . '>' . $currentpage . '</a>';
//}

?>