{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <title>Sign-in page</title>

    <link href="{$appConfig->getValue("baseUrl")}css/pure.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
    <div class="content-wrapper">
        <h1>Sign-in form</h1>

        <form action="{$appConfig->getValue('baseUrl')}/signin" method="post" accept-charset="utf-8" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group">
                    <label for="aligned-name">Username</label>
                    <input type="text" id="aligned-name" placeholder="Username" />
                    <span class="pure-form-message-inline">This is a required field.</span>
                </div>
                <div class="pure-control-group">
                    <label for="aligned-password">Password</label>
                    <input type="password" id="aligned-password" placeholder="Password" />
                </div>
                <div class="pure-control-group">
                    <label for="aligned-email">Email Address</label>
                    <input type="email" id="aligned-email" placeholder="Email Address" />
                </div>
                <div class="pure-control-group">
                    <label for="aligned-foo">Supercalifragilistic Label</label>
                    <input type="text" id="aligned-foo" placeholder="Enter something here..." />
                </div>
                <div class="pure-controls">
                    <label for="aligned-cb" class="pure-checkbox">
                        <input type="checkbox" id="aligned-cb" /> I&#x27;ve read the terms and conditions
                    </label>
                    <button type="submit" class="pure-button pure-button-primary">Submit</button>
                </div>
            </fieldset>
        </form>
    </div> <!-- /.content-wrapper -->
</body>
</html>
