<?php

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if (!$conn)
{
    die("Connection Failed : " . mysqli_connect_error());
}

$total_farmers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM crop_data"));

$sandy_soil = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM crop_data
     WHERE LOWER(soil) LIKE '%sandy%'
     OR soil LIKE '%रेतीली%'")
);

$loamy_soil = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM crop_data
     WHERE LOWER(soil) LIKE '%loamy%'
     OR soil LIKE '%दोमट%'")
);

$clay_soil = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM crop_data
     WHERE LOWER(soil) LIKE '%clay%'
     OR soil LIKE '%चिकनी%'")
);

/* PAGINATION */

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$limit = 5;

$start = ($page - 1) * $limit;

/* SEARCH */

$where = "";

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = " WHERE farmer_name LIKE '%$search%'";
}

/* SORT */

$order = "";

if(isset($_GET['sort']) && $_GET['sort'] != "")
{
    $sort = $_GET['sort'];

    if($sort == "id_asc")
    {
        $order = " ORDER BY id ASC";
    }
    elseif($sort == "id_desc")
    {
        $order = " ORDER BY id DESC";
    }
    elseif($sort == "name_asc")
    {
        $order = " ORDER BY farmer_name ASC";
    }
    elseif($sort == "name_desc")
    {
        $order = " ORDER BY farmer_name DESC";
    }
}

$sql = "SELECT * FROM crop_data
        $where
        $order
        LIMIT $start, $limit";

$result = mysqli_query($conn, $sql);

/* TOTAL PAGES */

$count_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM crop_data $where");

$count_row = mysqli_fetch_assoc($count_query);

$total_records = $count_row['total'];

$total_pages = ceil($total_records / $limit);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Crop Data Records</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
.dashboard{
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:30px;
}

.card{
    flex:1;
    min-width:200px;
    background:#90EE90;
    padding:20px;
    text-align:center;
    border-radius:10px;
    box-shadow:0 0 5px gray;
}

.card h3{
    margin:0;
}

.card h2{
    margin-top:10px;
    color:green;
}

        body{
            font-family: Arial;
            padding:20px;
        }

        h1{
            text-align:center;
            color:green;
        }

        form{
            margin-bottom:20px;
        }

        input[type=text]{
            padding:8px;
            width:250px;
        }

        select{
            padding:8px;
        }

        input[type=submit]{
            padding:8px 15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th, td{
            border:1px solid black;
            padding:10px;
            text-align:center;
        }

        th{
            background-color:lightgreen;
        }

        .edit{
            color:blue;
            text-decoration:none;
            font-weight:bold;
        }

        .delete{
            color:red;
            text-decoration:none;
            font-weight:bold;
        }

    </style>

</head>
<body class="container mt-4">
<nav class="navbar navbar-expand-lg navbar-dark bg-success mb-4">
    <div class="container-fluid">

        <a class="navbar-brand" href="#">
            🌾 Smart Crop Advisory
        </a>

    </div>
</nav>
<h1 class="text-center text-success mb-4">
    Smart Crop Advisory System
</h1>
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <h5 class="card-title">Total Records</h5>
                <h2><?php echo $total_farmers; ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <h5 class="card-title">Sandy Soil</h5>
                <h2><?php echo $sandy_soil; ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <h5 class="card-title">Loamy Soil</h5>
                <h2><?php echo $loamy_soil; ?></h2>
            </div>
        </div>
    </div>
<div class="col-md-3">
    <div class="card text-center border-danger">
        <div class="card-body">
            <h5 class="card-title">Clay Soil</h5>
            <h2><?php echo $clay_soil; ?></h2>
        </div>
    </div>
</div>

</div>

<br>
<a href="export.php" class="btn btn-success mb-3">
    Export To Excel
</a>


<br><br>
<div class="card mt-4 mb-4">
    <div class="card-body">
        <h4 class="text-center">Soil Distribution Chart</h4>
        <div style="width:300px; margin:auto;">
    <canvas id="soilChart"></canvas>
</div>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">

    <input
        type="text"
        class="form-control"
        name="search"
        placeholder="Search Farmer Name..."
        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>"
    >

    <select name="sort" class="form-select">

        <option value="">Sort By</option>

        <option value="id_asc">ID Ascending</option>

        <option value="id_desc">ID Descending</option>

        <option value="name_asc">Name A-Z</option>

        <option value="name_desc">Name Z-A</option>

    </select>

    <input type="submit" value="Apply" class="btn btn-primary">

</form>

<table class="table table-bordered table-striped table-hover">

<tr>
    <th>ID</th>
    <th>Farmer Name</th>
    <th>Soil</th>
    <th>Temperature</th>
    <th>Humidity</th>
    <th>Rainfall</th>
    <th>Water</th>
    <th>Crop</th>
    <th>Action</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['farmer_name']; ?></td>
    <td><?php echo $row['soil']; ?></td>
    <td><?php echo $row['temperature']; ?></td>
    <td><?php echo $row['humidity']; ?></td>
    <td><?php echo $row['rainfall']; ?></td>
    <td><?php echo $row['water_availability']; ?></td>
<td><?php echo $row['recommended_crop']; ?></td>

    <td>

        <a class="edit"
           href="edit.php?id=<?php echo $row['id']; ?>">
           Edit
        </a>

        &nbsp;&nbsp;

        <a class="delete"
           href="delete.php?id=<?php echo $row['id']; ?>"
           onclick="return confirm('Are you sure you want to delete this record?');">
           Delete
        </a>

    </td>

</tr>

<?php
}
?>

</table>
<br><br>

<div style="text-align:center;">

<?php

for($i = 1; $i <= $total_pages; $i++)
{
    echo "<a href='?page=$i&search="
    .(isset($_GET['search']) ? $_GET['search'] : '')
    ."&sort="
    .(isset($_GET['sort']) ? $_GET['sort'] : '')
    ."' style='padding:8px 12px;
    border:1px solid black;
    margin:5px;
    text-decoration:none;'>$i</a>";
}

?>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('soilChart');

new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Sandy Soil', 'Loamy Soil', 'Clay Soil'],
        datasets: [{
            data: [
                <?php echo $sandy_soil; ?>,
                <?php echo $loamy_soil; ?>,
                <?php echo $clay_soil; ?>
            ],
            backgroundColor: [
                '#36A2EB',
                '#FFCE56',
                '#FF6384'
            ]
        }]
    }
});
</script>
</body>
</html>