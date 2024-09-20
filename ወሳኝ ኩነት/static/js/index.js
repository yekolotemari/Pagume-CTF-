document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // Send the login credentials to Flask backend using fetch API
    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    })
        .then(function(response) {
            if (response.ok) {
                // Redirect to dashboard if login is successful
                window.location.href = '/dashboard';
            } else {
                console.error('Login failed');
            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
});


