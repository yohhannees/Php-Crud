<link rel="stylesheet" href="users_pagination.css">
<form method="get" id="records-per-page-form">
    <label for="limit">Records per page:</label>
    <select name="limit" id="limit">
        <option value="3">3</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
    </select>
    <input type="hidden" name="page" value="1">
    <button type="submit">Update</button>
</form>
<?php
$limit = isset($_GET['limit']) ? $_GET['limit'] : 3; // Use the selected value or default to 3 records per page
// $limit = 3; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$result = $conn->query("SELECT COUNT(*) FROM users");
$total_records = $result->fetch_array()[0];
$total_pages = ceil($total_records / $limit);

$result = $conn->query("SELECT * FROM users LIMIT $start, $limit");


echo '<table class="table table-bordered mt-4">';
echo '<thead>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>First Name</th>';
echo '<th>Last Name</th>';
echo '<th>Age</th>';
echo '<th>Action</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['first_name'] . '</td>';
    echo '<td>' . $row['last_name'] . '</td>';
    echo '<td>' . $row['age'] . '</td>';
    echo '<td>';
    echo '<a href="edit_user.php?id=' . $row['id'] . '" class="btn btn-sm btn-edit">Edit</a> ';
    echo '<a href="delete_user.php?id=' . $row['id'] . '" class="btn btn-sm btn-delete">Delete</a>';
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<nav aria-label="Page navigation example">';
echo '<ul class="pagination justify-content-center">';
// for ($i = 1; $i <= $total_pages; $i++) {
//     echo '<li class="page-item' . ($page == $i ? ' active' : '') . '"><a class="page-link btn btn-outline-secondary" href="index.php?page=' . $i . '">' . $i . '</a></li>';
// }

for ($i = 1; $i <= $total_pages; $i++) {
    echo '<li class="page-item' . ($page == $i ? ' active' : '') . '"><a class="page-link btn btn-outline-secondary" href="index.php?page=' . $i . '&limit=' . $limit . '">' . $i . '</a></li>';
}
echo '</ul>';
echo '</nav>';
?>