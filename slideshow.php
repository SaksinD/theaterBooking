<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movie Theater</title>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <style>
    body {
            margin: 0;
            padding: 0;
            /*background-image: url('./images/indexpage_bg.svg');*/
            background-color: black;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;

        }

        .topBar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: black;
            height: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 40px 40px;
            z-index: 1000;
            height: 100px;
        }

        #logo {
            width: 100px;
            height: 75px;
        }

        #logo img {
            width: 100%;
            /* Make sure the image fills the container */
            height: auto;
            /* Maintain aspect ratio */
        }
        #admin-signup,
        #admin-login {
            text-decoration: none;
            color: #0CE7EB;
            border-color: #0CE7EB;
            font-weight: bold;
            font-weight: bold;
            display: inline-block;
            padding: 5px 20px;
            margin-top: 40px;
            text-align: center;
        }
        #admin-signup,
        #admin-login:hover {
            color: #FC3066;
            background-color: #0CE7EB;
            border-color: #0CE7EB;
        }



    .book-container {
      padding-top: 150px;
      display: grid;
      grid-template-columns: 1fr 3fr;
      gap: 20px;
    }

    .form-container {
      padding: 20px;
      border: 1px solid #ccc;
    }

    .movie-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1.5fr));
      gap: 20px;
    }

    .movie-card {
      padding: 10px;
      border: 1px solid #ccc;
    }

    .movie-card img {
      width: 100%;
      height: auto;
    }

    .card {
      max-width: 345px;
      max-height: 260px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .card-image {
      width: 100%;
      height: auto;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }

    .card-content {
      display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    padding: 5px 15px 5px 15px;
    margin: 10px;
    }

    .card-title {
      font-size: 1.2rem;
      text-transform: uppercase;
    width: 45%;
    }

    .btn-book-now {
      width: 45%;
    }

    .card-content > * {
    margin-right: 10%;
}

.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.popup-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
}

.close {
    position: absolute;
    top: 0px;
    right: 10px;
    cursor: pointer;
    font-size: 25px;
}

.button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.dates,
.times,
.locations {
    flex: 1; 
    margin: 10px;
}


#dates-container button,
#times-container button,
#locations-container button {
    margin-right: 10px;
    left: 10%;
    right: 10%;
}

#popup-header {
    text-transform: uppercase;
}

button.selected {
    background-color: green;
    color: white;
}

.form-group {
  margin-bottom: 10px;
}




  </style>
</head>

<header>
    <div class="topBar">
        <a href="#" id="logo"><img src="./images/logo.png" /> </a>
        <div class="sign-log">
        <a href="signUp.php" id="admin-signup" class="btn btn-outline">Sign Up</a>
        <a href="admin-login.php" id="admin-login" class="btn btn-outline" target="_blank">Login</a>
        </div>
    </div>

</header>

<body>

  <div class="book-container">
    <div class="form-container" id="form-container">
  <h2>UP CINEMA.COM THEATER SEAT BOOKING</h2>
  <form action="booking.php" method="post" class="needs-validation" novalidate>
    <div class="form-group">
      <label for="movie">Movie:</label>
      <select id="movie" name="movie" class="form-control" required onchange="populateOptions()">
        <option value="" disabled selected>Select a movie</option>
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "movie_theater";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM movies";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['movie_name'] . "</option>";
          }
        } else {
          echo "0 results";
        }
        $conn->close();
        ?>
      </select>
      <div class="invalid-feedback">Please select a movie.</div>
    </div>
    <div class="form-group">
      <label for="date">Date:</label>
      
      <select id="date" name="date" class="form-control" required>
      <option value="" disabled selected>Select a date</option></select>
      <div class="invalid-feedback">Please select a date.</div>
    </div>
    <div class="form-group">
    
      <label for="time">Time:</label>
      <select id="time" name="time" class="form-control" required>
      <option value="" disabled selected>Select a time</option></select>
      <div class="invalid-feedback">Please select a time.</div>
    </div>
    <div class="form-group">
      <label for="location">Location:</label>
      
      <select id="location" name="location" class="form-control" required>
      <option value="" disabled selected>Select a location</option></select>
      <div class="invalid-feedback">Please select a location.</div>
    </div>
    <button class="btn-show-seats btn btn-success" id="btn-show-seats" onclick="showSeats()">Show Seats</button>
    
  </form>
</div>


    <script>
      function populateOptions() {
        var movieId = document.getElementById("movie").value;
        var dateSelect = document.getElementById("date");
        var timeSelect = document.getElementById("time");
        var locationSelect = document.getElementById("location");

        // Clear previous options
        dateSelect.innerHTML = "<option value='' disabled selected>Select a date</option>";
        timeSelect.innerHTML = "<option value='' disabled selected>Select a time</option>";
        locationSelect.innerHTML = "<option value='' disabled selected>Select a location</option>";

        // AJAX call to fetch available dates, times, and locations based on selected movie
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "fetch_form_movie_data.php?movie_id=" + movieId, true);
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText);

            // Populate dates
            data.dates.forEach(function(date) {
              var option = document.createElement("option");
              option.text = date;
              dateSelect.add(option);
            });

            // Populate times
            data.times.forEach(function(time) {
              var option = document.createElement("option");
              option.text = time;
              timeSelect.add(option);
            });

            // Populate locations
            data.locations.forEach(function(location) {
              var option = document.createElement("option");
              option.text = location;
              locationSelect.add(option);
            });
          }
        };
        xhr.send();
      }
    </script>


    <div class="movie-container">
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

      $sql = "SELECT id, name, poster FROM movieImages";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          echo '<div class="card">';
          echo '<img class="card-image" src="data:image/jpeg;base64,' . base64_encode($row['poster']) . '" alt="' . $row['name'] . '">';
          echo '<div class="card-content">';
          echo '<h5 class="card-title" style="text-transform: uppercase;">' . $row['name'] . '</h5>';
          echo '<button class="btn-book-now btn btn-success" onclick="showPopup(' . $row['id'] . ', \'' . $row['name'] . '\')" style="background-color:green";>Book Now</button>'; 
          echo '</div>';
          echo '</div>';
      }      
      } else {
        echo "0 results";
      }
      $conn->close();
      ?>
    </div>
  </div>


 <!-- Popup -->
<div class="popup" id="popup">
  <div class="popup-content">
    <!-- Close button -->
    <span class="close" onclick="closePopup()">&times;</span>
    <h2 id="popup-header">Book Now</h2>
    <div class="button-container">
      <div class="dates" id="dates-container"></div>
      <div class="times" id="times-container"></div>
      <div class="locations" id="locations-container"></div>
    </div>
    <button class="btn-show-seats" id="btn-show-seats" onclick="showSeats()">Show Seats</button>
  </div>
</div>



<!-- Script tags for jQuery and custom JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
<script>
 function showSeats() {
  if (selectedDate && selectedTime && selectedLocation) {
    console.log("Date: " + selectedDate + ", Time: " + selectedTime + ", Location: " + selectedLocation);
    // Proceed to show seats based on selected date, time, and location
    window.location.href = "showseat.php";
  } else {
    alert("Please select a date, time, and location.");
  }
}
</script>

  





  

</body>

</html>