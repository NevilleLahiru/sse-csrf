# sse-csrf

This post focuses on two ways of protecting a user from Cross Site Request Forgery attacks via PHP. This web app demonstration includes three files. The index.php includes login form and the relevant validation code. Once logged in, this creates a CSRF token and saves in the server side. The protected.php file is a contact form which is protected by the login. The get-token.php file is the endpoint where the AJAX request is given the token.
