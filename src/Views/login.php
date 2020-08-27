<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="/login" method="POST" class="login_form">
        <label for="username">Username</label>
        <input id="username" name="username" type="text" required placeholder="username1"/>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required="true"/>
        <input type="submit" class="btn btn-primary"/>
    </form>
    <?php echo isset($params['message']) ? $params['message'] : '' ?>
</body>
</html>
