document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Get the username and password from the form
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Basic client-side validation (you can add more complex validation)
        if (!username || !password) {
            alert('Please enter both username and password.');
            return;
        }

        // Simulate authentication (replace with your server-side logic)
        if (username === 'your_username' && password === 'your_password') {
            alert('Login successful!'); // Replace with a redirect or further actions
        } else {
            alert('Invalid username or password. Please try again.');
        }
    });
});
