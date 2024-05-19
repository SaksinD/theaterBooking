<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin manager</title>
    <style>
        #logout-form {
            position: absolute;
            top: 40px;
            right: 10px;
        }

        #logout-form button {
            background-color: orangered;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 40px 2px;
            cursor: pointer;
        }

        table {
            font-family: Arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }


        .edit-btn,
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .popup-content,
        .edit-popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .poster-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .edit-popup,
        .adminpopup,
        .movieseditpopup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .edit-movie_popup-content {
            width: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-height: 80vh;
            /* Set maximum height */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .rowwise {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .moviename,
        .dates {
            flex: 1;
            margin-right: 10px;
        }

        .moviename input,
        .dates input {
            width: 100%;
            max-width: 120px;
        }

        @media screen and (max-width: 600px) {

            .moviename,
            .dates {
                flex: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

        .delete-btn {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="currentMovies-container">
        <h2>Movie Images</h2>
        <button onclick="document.getElementById('addForm').style.display='block'" class="button">Add Poster</button>
        <form id="logout-form" action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
        <br><br>

        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Poster</th>
                <th>Action</th>
            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "movie_theater";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the movieImages table
            $sql = "SELECT id, name, poster FROM movieImages";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td><img src='display_image.php?id=" . $row['id'] . "' alt='" . $row['name'] . " Poster' width='51.2' height='25' class='poster-img'></td>";
                    echo "<td><button class='button' onclick='openEditPopup(" . $row['id'] . ", \"" . $row['name'] . "\")'>Edit</button> <button class='delete-btn' onclick='deleteRow(" . $row['id'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>



    <div id="addForm" class="edit-popup">
        <form class="edit-popup-content" action="add_poster.php" method="post" enctype="multipart/form-data">
            <span class="close" onclick="document.getElementById('addForm').style.display='none'">&times;</span>
            <h2>Add Poster</h2>
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="poster">Poster:</label><br>
            <input type="file" id="poster" name="poster" required><br><br>
            <input type="submit" value="Add poster" class="button">
        </form>
    </div>


    <div id="editForm" class="edit-popup">
        <form class="edit-popup-content" action="edit_poster.php" method="post" enctype="multipart/form-data">
            <span class="close" onclick="document.getElementById('editForm').style.display='none'">&times;</span>
            <h2>Edit Poster</h2>
            <input type="hidden" id="editId" name="id">
            <label for="editName">Name:</label><br>
            <input type="text" id="editName" name="name" required><br><br>
            <label for="editPoster">Poster:</label><br>
            <input type="file" id="editPoster" name="poster"><br><br>
            <input type="submit" value="Edit" class="button">
        </form>
    </div>

    <script>
        function openEditPopup(id, name) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editForm').style.display = 'block';
        }

        function deleteRow(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                window.location.href = 'delete_poster.php?id=' + id;
            }
        }
    </script>
    <br>

    <div>
        <h2>Movie Management</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Movie Name</th>
                <th>Date 1</th>
                <th>Date 2</th>
                <th>Date 3</th>
                <th>Time 1</th>
                <th>Time 2</th>
                <th>Time 3</th>
                <th>Time 4</th>
                <th>Batti Cinima</th>
                <th>Yal Cinima</th>
                <th>Colombo Cinima</th>
                <th>Edit</th>
            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "movie_theater";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve data from the "movies" table
            $sql = "SELECT * FROM movies";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["movie_name"] . "</td>";
                    echo "<td>" . $row["date1"] . "</td>";
                    echo "<td>" . $row["date2"] . "</td>";
                    echo "<td>" . $row["date3"] . "</td>";
                    echo "<td>" . $row["time1"] . "</td>";
                    echo "<td>" . $row["time2"] . "</td>";
                    echo "<td>" . $row["time3"] . "</td>";
                    echo "<td>" . $row["time4"] . "</td>";
                    echo "<td>" . $row["Batti Cinima"] . "</td>";
                    echo "<td>" . $row["Yal Cinima"] . "</td>";
                    echo "<td>" . $row["Colombo Cinima"] . "</td>";
                    echo '<td><button class="button" onclick="openEditmoviePopup(' . $row["id"] . ', \'' . $row["movie_name"] . '\', \'' . $row["date1"] . '\', \'' . $row["date2"] . '\', \'' . $row["date3"] . '\', \'' . $row["time1"] . '\', \'' . $row["time2"] . '\', \'' . $row["time3"] . '\', \'' . $row["time4"] . '\', \'' . $row["Batti Cinima"] . '\', \'' . $row["Yal Cinima"] . '\', \'' . $row["Colombo Cinima"] . '\')">Edit</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>No movies found</td></tr>";
            }
            ?>
        </table>

    </div>

    <!-- Popup for editing -->


    <div id="movieseditpopup" class="movieseditpopup">
        <form class="edit-movie_popup-content" action="update_movies.php" method="post">
            <span class="close" onclick="document.getElementById('movieseditpopup').style.display='none'">&times;</span>
            <input type="hidden" name="editMovieId" id="editMovieId">
            <div class="rowwise">
                <div class="moviename">
                    <label for="editMovieName">Movie Name:</label>
                    <input type="text" name="editMovieName" id="editMovieName">
                </div>
                <div class="dates">
                    <label for="editDate1">Date 1:</label>
                    <input type="date" name="editDate1" id="editDate1">
                </div>
                <div class="dates">
                    <label for="editDate2">Date 2:</label>
                    <input type="date" name="editDate2" id="editDate2">
                </div>
                <div class="dates">
                    <label for="editDate3">Date 3:</label>
                    <input type="date" name="editDate3" id="editDate3">
                </div>
            </div>
            <br>

            Time 1:
            <select name="editTime1" id="editTime1">
                <option value="no">No</option>
                <option value="6.30 pm">6.30 pm</option>
            </select><br>
            Time 2:
            <select name="editTime2" id="editTime2">
                <option value="no">No</option>
                <option value="9.30 pm">9.30 pm</option>
            </select><br>
            Time 3:
            <select name="editTime3" id="editTime3">
                <option value="no">No</option>
                <option value="10.30 am">10.30 am</option>
            </select><br>
            Time 4:
            <select name="editTime4" id="editTime4">
                <option value="no">No</option>
                <option value="2.30 am">2.30 am</option>
            </select><br>
            Batti Cinima:
            <select name="editBattiCinema" id="editBattiCinema">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br>
            Yal Cinima:
            <select name="editYalCinema" id="editYalCinema">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br>
            Colombo Cinima:
            <select name="editColomboCinema" id="editColomboCinema">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select><br>
            <!-- Add more fields as needed -->
            <input type="submit" value="Edit" class="button">
        </form>
    </div>


    <script>
        // JavaScript function to open the edit popup
        function openEditmoviePopup(id, movieName, date1, date2, date3, time1, time2, time3, time4, battiCinema, yalCinema, colomboCinema) {
            // Populate the popup fields with the current movie details
            document.getElementById('editMovieId').value = id;
            document.getElementById('editMovieName').value = movieName;
            document.getElementById('editDate1').value = date1;
            document.getElementById('editDate2').value = date2;
            document.getElementById('editDate3').value = date3;
            document.getElementById('editTime1').value = time1;
            document.getElementById('editTime2').value = time2;
            document.getElementById('editTime3').value = time3;
            document.getElementById('editTime4').value = time4;
            document.getElementById('editBattiCinema').value = battiCinema;
            document.getElementById('editYalCinema').value = yalCinema;
            document.getElementById('editColomboCinema').value = colomboCinema;

            // Show the popup
            document.getElementById('movieseditpopup').style.display = 'block';
        }
    </script>



    <div class="users">
        <br><br>
        <h2>Users Management</h2>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Updation Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "movie_theater";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the users table
                $sql = "SELECT id, email, username, password, updationDate FROM users";
                $result = $conn->query($sql);

                // Close the connection

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["username"] . "</td>";
                        echo "<td>" . $row["password"] . "</td>";
                        echo "<td>" . $row["updationDate"] . "</td>";
                        echo "<td><button class='delete-btn' onclick='deleteRow(this)'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            // Here you can add AJAX call to delete the corresponding row from the database
        }
    </script>


<div class="admin">
    <br><br>
    <h2>Admin Management</h2>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Admin Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Updation Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "movie_theater";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the users table
            $sql = "SELECT id, FullName, AdminEmail, UserName, Password, updationDate FROM admin";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["id"]."</td>";
                    echo "<td>".$row["FullName"]."</td>";
                    echo "<td>".$row["AdminEmail"]."</td>";
                    echo "<td>".$row["UserName"]."</td>";
                    echo "<td>".$row["Password"]."</td>";
                    echo "<td>".$row["updationDate"]."</td>";
                    echo "<td>";
                    echo "<button class='edit-btn' onclick='editRow(".$row["id"].", \"".$row["FullName"]."\", \"".$row["AdminEmail"]."\", \"".$row["UserName"]."\", \"".$row["Password"]."\")'>Edit</button>";
                    echo "<button class='delete-btn' onclick='deleteRow(".$row["id"].")'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No admin found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Popup for editing admin details -->
<div id="adminPopup" class="adminpopup">
    <div class="popup-content">
        <h2>Edit Admin</h2>
        <!-- Form for editing admin details -->
        <form id="editAdminForm" action="update_admin.php" method="post">
            <label for="fullName">Full Name:</label><br>
            <input type="text" id="fullName" name="fullName"><br><br>

            <label for="adminEmail">Admin Email:</label><br>
            <input type="text" id="adminEmail" name="adminEmail"><br><br>

            <label for="userName">Username:</label><br>
            <input type="text" id="userName" name="userName"><br><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>

            <input type="hidden" id="adminId" name="adminId">

            <input type="submit" value="Update">
        </form>
    </div>
</div>

<script>
    function editRow(id, fullName, adminEmail, userName, password) {
        document.getElementById('fullName').value = fullName;
        document.getElementById('adminEmail').value = adminEmail;
        document.getElementById('userName').value = userName;
        document.getElementById('password').value = password;
        document.getElementById('adminId').value = id;

        document.getElementById('adminPopup').style.display = 'block';
    }
</script>

</body>

</html>