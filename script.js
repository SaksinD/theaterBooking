var selectedDate = null;
var selectedTime = null;
var selectedLocation = null;

function showPopup(movieId, movieName) {
  document.getElementById("popup").style.display = "block";
  fetchMovieData(movieId, movieName);
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
}

function fetchMovieData(movieId, movieName) {
  $.ajax({
    url: "fetch_movie_data.php",
    type: "GET",
    data: {
      movieId: movieId
    },
    success: function(response) {
      var data = JSON.parse(response);
      if (data.dates.length === 0 || data.times.length === 0 || data.locations.length === 0) {
        showNotAvailableMessage(movieName);
      } else {
        showBookNowButton(movieName);
        populateButtons(data.dates, "dates-container", selectDate);
        populateButtons(data.times, "times-container", selectTime);
        populateButtons(data.locations, "locations-container", selectLocation);
      }
    },
    error: function(xhr, status, error) {
      console.error("Error fetching movie data: " + error);
    }
  });
}

function showNotAvailableMessage(movieName) {
  var popupContent = document.querySelector(".popup-content");
  popupContent.innerHTML = `
    <span class="close" onclick="closePopup()">&times;</span>
    <p>Sorry Buddy, ${movieName} is not available!</p>
  `;
}

function populateButtons(items, containerId, clickHandler) {
  var container = document.getElementById(containerId);
  container.innerHTML = ""; // Clear previous buttons
  items.forEach(function(item) {
    var button = document.createElement("button");
    button.textContent = item;
    button.onclick = function() {
      clickHandler(item, containerId);
    };
    container.appendChild(button);
  });
}

function selectDate(date, containerId) {
  selectedDate = date;
  clearSelection(containerId);
  console.log("Selected date: " + date);
}

function selectTime(time, containerId) {
  selectedTime = time;
  clearSelection(containerId);
  console.log("Selected time: " + time);
}

function selectLocation(location, containerId) {
  selectedLocation = location;
  clearSelection(containerId);
  console.log("Selected location: " + location);
}

function clearSelection(containerId) {
  var container = document.getElementById(containerId);
  var buttons = container.getElementsByTagName("button");
  for (var i = 0; i < buttons.length; i++) {
    buttons[i].classList.remove("selected");
  }
  event.target.classList.add("selected");
}

function showSeats() {
  if (selectedDate && selectedTime && selectedLocation) {
    console.log("Date: " + selectedDate + ", Time: " + selectedTime + ", Location: " + selectedLocation);
    // Proceed to show seats based on selected date, time, and location
  } else {
    alert("Please select a date, time, and location.");
  }
}

function showBookNowButton(movieName) {
  var popupContent = document.querySelector(".popup-content");
  popupContent.innerHTML = `
    <span class="close" onclick="closePopup()">&times;</span>
    <h2 id="popup-header">Book Now - ${movieName}</h2>
    <div class="dates" id="dates-container"></div>
    <div class="times" id="times-container"></div>
    <div class="locations" id="locations-container"></div>
    <button class="btn-show-seats btn btn-success" id="btn-show-seats" onclick="showSeats()" >Show Seats</button>
  `;
}


document.addEventListener("DOMContentLoaded", function() {
  const groundFloorSeats = document.getElementById("ground-floor");
  const balconySeats = document.getElementById("balcony");
  const bookingForm = document.getElementById("booking-form");
  const seatsForm = document.getElementById("booking-details-form");
  const selectedSeatsInput = document.getElementById("selected-seats");

  // Function to populate seats
  function populateSeats() {
      // Populate ground floor seats
      for (let i = 1; i <= 80; i++) {
          const seat = createSeat(i);
          groundFloorSeats.appendChild(seat);
      }

      // Populate balcony seats
      for (let i = 81; i <= 100; i++) {
          const seat = createSeat(i);
          balconySeats.appendChild(seat);
      }

      // Apply additional styling for ground floor seats
      groundFloorSeats.style.gridTemplateColumns = "repeat(8, 1fr)";
      groundFloorSeats.style.gridGap = "5px";

      // Apply additional styling for balcony seats
      balconySeats.style.gridTemplateColumns = "repeat(10, 1fr)";
      balconySeats.style.gridGap = "5px";
  }

  // Function to create a seat element
  function createSeat(seatNumber) {
      const seat = document.createElement("div");
      seat.classList.add("seat");
      seat.textContent = seatNumber;
      seat.addEventListener("click", function() {
          if (!seat.classList.contains("booked")) {
              if (seat.classList.contains("selected")) {
                  seat.classList.remove("selected");
                  updateSelectedSeats();
                  if (selectedSeatsInput.value === "") {
                      bookingForm.classList.add("hidden");
                  }
              } else {
                  seat.classList.add("selected");
                  updateSelectedSeats();
                  bookingForm.classList.remove("hidden");
              }
          }
      });
      return seat;
  }

  // Function to update selected seats input
  function updateSelectedSeats() {
      const selectedSeats = document.querySelectorAll(".selected");
      const seatsArray = Array.from(selectedSeats).map(seat => seat.textContent);
      selectedSeatsInput.value = seatsArray.join(",");
      if (selectedSeatsInput.value === "") {
          bookingForm.classList.add("hidden");
      }
  }

  // Event listener for form submission
  seatsForm.addEventListener("submit", function(event) {
      event.preventDefault();
      const formData = new FormData(seatsForm);
      const bookingDetails = Object.fromEntries(formData.entries());

      // Send booking details to server
      fetch("bookSeats.php", {
          method: "POST",
          body: JSON.stringify(bookingDetails),
          headers: {
              "Content-Type": "application/json"
          }
      })
      .then(response => response.json())
      .then(data => {
          alert(data.message); // Show success or error message
          if (data.success) {
              // Reset form and seats
              seatsForm.reset();
              document.querySelectorAll(".selected").forEach(seat => {
                  seat.classList.remove("selected");
                  seat.classList.add("booked");
              });
              bookingForm.classList.add("hidden");
          }
      })
      .catch(error => {
          console.error("Error:", error);
      });
  });

  // Initialize
  populateSeats();
});
