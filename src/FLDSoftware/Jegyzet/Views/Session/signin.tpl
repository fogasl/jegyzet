{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>Sign-in page</title>
</head>
<body>
    <h1>Sign-in form</h1>

    <p>MOTD: {$data->foobar}</p>

    <form action="{$appConfig->getValue('baseUrl')}/signin" method="post" accept-charset="utf-8">
        <label for="username">Username</label>
        <input type="text" name="username" autocomplete="off" required />
        <label for="password">
            Password
        </label>
        <input type="password" name="password" autocomplete="off" required />

        <input type="submit" value="Sign-in" />
    </form>
</body>
</html>
