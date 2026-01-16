document.addEventListener("DOMContentLoaded", () => {
  const pageId = document.body.id;

  // if (pageId === "log-in") {       // make the login process

  //   const loginForm = document.getElementById("login-form");

  //   loginForm.addEventListener("submit", (e) => {
  //     e.preventDefault();

  //     const username = document.getElementById("username").value.trim();
  //     const password = document.getElementById("password").value;

  //     // Retrieve the users list from localStorage
  //     const users = JSON.parse(localStorage.getItem("users")) || [];

  //     // Check if the provided credentials match any user in the list
  //     const user = users.find(user => user.username === username && user.password === password);

  //     if (user) {
  //       alert("Login successful!");
  //       window.location.href = "reports.html"; // Redirect to admin dashboard

  //       // Redirect to a dashboard or another page
  //     } else {
  //       alert("Invalid username or password.");
  //     }

  //     loginForm.reset();
  //   });
  // }

if (pageId === "sign-up") {   // verification for sign-up page

    const usernameInput = document.getElementById('username');
    const status_username = document.getElementById('username_status');

    usernameInput.addEventListener('input', function (){
      const username = usernameInput.value.trim();
      if (!username) {
        status_username.textContent = '';
        return;
      }
    
      fetch('../../assets/backend/controllers/check_username.php?username=' + encodeURIComponent(username))
        .then(res => res.json())
        .then(data => {
          if (data.available) {
            status_username.textContent = 'Username Available';
            status_username.style.color = 'green';
          } else {
            status_username.textContent = 'Username is Taken';
            status_username.style.color = 'red';
          }
        })
        .catch(() => {
          status_username.textContent = '⚠️ Error checking username';
          status_username.style.color = 'orange';
        });
    });
    

  //   const signupForm = document.getElementById("login-form");

  //   signupForm.addEventListener("submit", (e) => {
  //     e.preventDefault();

  //     const username = document.getElementById("username").value;
  //     validateUsername(username) //check if username is valid
  //     const errors = validateUsername(username);
  //     if (errors.length > 0) {
  //       alert("Please follow this guidline for your username\n" + errors);
  //       return;
  //     }
  //     const password = document.getElementById("password").value;
  //     const confirmPassword = document.getElementById("confirm-password").value;

  //     if (password !== confirmPassword) {    //check if password is simmilar to confirm password.
  //       alert("Passwords do not match!");
  //       return;
  //     }

  //     // Retrieve existing users from localStorage or initialize an empty array
  //     const users = JSON.parse(localStorage.getItem("users")) || [];

  //     // Check if the username already exists
  //     if (users.some(user => user.username === username)) {
  //       alert("Username already exists. Please choose another one.");
  //       return;
  //     }

  //     // Add the new user to the list
  //     users.push({ username, password });

  //     // Store the updated list back in localStorage
  //     localStorage.setItem("users", JSON.stringify(users));

  //     alert("Signup successful! You can now log in.");
  //     signupForm.reset();
  //     window.location.href = "reports.html"; // Redirect to admin dashboard

  //   });
  }

  else if (pageId === "notification") {
    const timeElements = document.querySelectorAll(".timecalc");

    // Define notification times
    const notifications = [
      { id: "timecalc1", time: new Date("2025-01-19T20:20:00") }, // Flight Reminder
      { id: "timecalc2", time: new Date("2025-01-02T00:00:00") }, // Medical CheckUp
      { id: "timecalc3", time: new Date("2024-12-21T00:00:00") }, // Biometric CheckUp
    ];

    // Function to calculate time difference and update text
    const updateTimes = () => {
      const now = new Date();

      notifications.forEach(notification => {
        const elapsedTime = Math.floor((now - notification.time) / 1000); // Elapsed time in seconds
        let timeText = "";

        if (elapsedTime < 60) {
          timeText = `${elapsedTime} seconds ago`;
        } else if (elapsedTime < 3600) {
          const minutes = Math.floor(elapsedTime / 60);
          timeText = `${minutes} minute${minutes > 1 ? "s" : ""} ago`;
        } else if (elapsedTime < 86400) {
          const hours = Math.floor(elapsedTime / 3600);
          timeText = `${hours} hour${hours > 1 ? "s" : ""} ago`;
        } else {
          const days = Math.floor(elapsedTime / 86400);
          timeText = `${days} day${days > 1 ? "s" : ""} ago`;
        }

        // Update the innerText of the corresponding element
        const element = document.getElementById(notification.id);
        if (element) {
          element.innerText = timeText;
        }
      });
    };

    // Initial update and set interval for every minute
    updateTimes();
    setInterval(updateTimes, 60000); // Update every minute
  }


  // else if (pageId === "register") {
  //   // Add event listener for form submission
  //   document.getElementById("submit").addEventListener("click", registration);

  //   function registration(event) {
  //     event.preventDefault(); // Prevent form submission's default behavior (page refresh)

  //     // Get form field values
  //     const firstName = document.getElementById('fname').value;
  //     const middleName = document.getElementById('mname').value;
  //     const lastName = document.getElementById('lname').value;
  //     const phone = document.getElementById('contact').value;
  //     const passport = document.getElementById('passport').value;
  //     const nationality = document.getElementById('nationality').value;
  //     const employeeType = document.getElementById('employee_type').value;
  //     const maritalStatus = document.querySelector('input[name="mstatus"]:checked').value;
  //     const age = document.getElementById('age').value;


  //     // Combine first, middle, and last names into a full name
  //     const fullName = `${firstName} ${middleName} ${lastName}`;

  //     // Get current date for Registration Date
  //     const registrationDate = new Date().toISOString().split('T')[0];

  //     // Create a new client object
  //     const newClient = {
  //       fullName,
  //       phone,
  //       passport,
  //       nationality,
  //       employeeType,
  //       maritalStatus,
  //       registrationDate,
  //       age,
  //       status: "Active", // Default status
  //     };

  //     // Retrieve existing clients from local storage
  //     let clients = JSON.parse(localStorage.getItem("clients")) || [];

  //     // Add the new client to the list
  //     clients.push(newClient);

  //     // Save the updated clients list back to local storage
  //     localStorage.setItem("clients", JSON.stringify(clients));

  //     // Reset the form fields
  //     document.querySelector('form').reset();

  //     // Redirect to client-list.html
  //     window.location.href = "client-list.html";
  //   }

  // }

  else if (pageId === "client-listss") {
    // Ensure the client list is populated when on client-list.html
    // Check if we are on the client-list.html page
    if (document.querySelector('table tbody')) {
      // Select the table body
      const tableBody = document.querySelector('table tbody');

      // Retrieve clients from local storage
      const clients = JSON.parse(localStorage.getItem("clients")) || [];
      console.log("DOMContentLoaded triggered");


      // Append each client to the table
      clients.forEach((client) => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
              <td>${client.fullName}</td>
              <td>${client.age}</td> <!-- Age is not in the form -->
              <td>${client.passport}</td>
              <td>${client.nationality}</td>
              <td>-</td> <!-- Medical Status is not in the form -->
              <td>${client.employeeType}</td>
              <td>${client.maritalStatus}</td>
              <td>${client.registrationDate}</td>
              <td>-</td> <!-- Flight Date is not in the form -->
              <td>${client.status}</td>
          `;
        tableBody.appendChild(newRow);
      });
    }
  }

});

//----------------------------------------------------------------------->

function validateUsername(username) { //supporting function to validate username
  const errors = [];

  if (username.length < 3 || username.length > 20) {
    errors.push("\bUsername must be between 3 and 20 characters.\n");
  }
  if (!/^[a-zA-Z0-9_]+$/.test(username)) {
    errors.push("\bUsername can only contain letters, numbers, and underscores.\n");
  }
  if (username.trim() !== username) {
    errors.push("\bUsername cannot have leading or trailing spaces.\n");
  }
  if (/[_-]{2,}/.test(username)) {
    errors.push("\bUsername cannot have consecutive special characters.\n");
  }
  if (!/^[a-zA-Z]/.test(username)) {
    errors.push("\bUsername must start with a letter.\n");
  }
  if (!/[a-zA-Z0-9]$/.test(username)) {
    errors.push("\bUsername must end with a letter or number.\n");
  }

  return errors;
}
