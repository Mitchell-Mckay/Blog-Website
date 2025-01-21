<?php

require('dbc.php');

// query the views table to get the number of views for the article with the given id
$query = "SELECT posts.view_count, posts.post_id FROM `posts` ORDER BY posts.view_count DESC;";

// execute the query and get the result
$result = mysqli_query($conn, $query);

// create an empty array to hold the views data
$views_data = array();

// loop through the result and add each row to the views data array
while ($row = mysqli_fetch_assoc($result)) {
   $views_data[] = $row;
}

// encode the views data array as JSON and output it
echo json_encode($views_data);
