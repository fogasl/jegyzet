{* Smarty *}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{$appData->name}</title>

    <link href="{$appConfig->getValue("baseUrl")}css/pure.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="{$appConfig->getValue("baseUrl")}css/layout.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
        <a href="#" id="menuLink" class="nav-menu-button">Menu</a>

        <span class="brand">{$appData->name}</span>

        <div class="nav-inner">
            <button class="primary-button pure-button">Add note</button>

            <div class="pure-menu">
                <ul class="pure-menu-list">
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Inbox <span class="email-count">(2)</span></a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Important</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Sent</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Drafts</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link">Trash</a></li>
                    <li class="pure-menu-heading">Labels</li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link"><span class="email-label-personal"></span>Personal</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link"><span class="email-label-work"></span>Work</a></li>
                    <li class="pure-menu-item"><a href="#" class="pure-menu-link"><span class="email-label-travel"></span>Travel</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="list" class="pure-u-1">
        <div class="email-item email-item-selected pure-g">
            <div class="pure-u">
                <img width="64" height="64" alt="Tilo Mitra&#x27;s avatar" class="email-avatar" src="/img/common/tilo-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Tilo Mitra</h5>
                <h4 class="email-subject">Hello from Toronto</h4>
                <p class="email-desc">
                    Hey, I just wanted to check in with you from Toronto. I got here earlier today.
                </p>
            </div>
        </div>

        <div class="email-item email-item-unread pure-g">
            <div class="pure-u">
                <img width="64" height="64" alt="Eric Ferraiuolo&#x27;s avatar" class="email-avatar" src="/img/common/ericf-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Eric Ferraiuolo</h5>
                <h4 class="email-subject">Re: Pull Requests</h4>
                <p class="email-desc">
                    Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img width="64" height="64" alt="Reid Burke&#x27;s avatar" class="email-avatar" src="/img/common/reid-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Reid Burke</h5>
                <h4 class="email-subject">Re: Design Language</h4>
                <p class="email-desc">
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img width="64" height="64" alt="Yahoo! Finance&#x27;s Avatar" class="email-avatar" src="/img/common/yfinance-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Yahoo! Finance</h5>
                <h4 class="email-subject">How to protect your finances from winter storms</h4>
                <p class="email-desc">
                    Mauris tempor mi vitae sem aliquet pharetra. Fusce in dui purus, nec malesuada mauris.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img width="64" height="64" alt="Yahoo! News&#x27; avatar" class="email-avatar" src="/img/common/ynews-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Yahoo! News</h5>
                <h4 class="email-subject">Summary for April 3rd, 2021</h4>
                <p class="email-desc">
                    We found 10 news articles that you may like.
                </p>
            </div>
        </div>
    </div>

    <div id="main" class="pure-u-1">
        <div class="email-content">
            <div class="email-content-header pure-g">
                <div class="pure-u-1-2">
                    <h1 class="email-content-title">Hello from Toronto</h1>
                    <p class="email-content-subtitle">
                        From <a>Tilo Mitra</a> at <span>3:56pm, April 3, 2021</span>
                    </p>
                </div>

                <div class="email-content-controls pure-u-1-2">
                    <button class="secondary-button pure-button">Reply</button>
                    <button class="secondary-button pure-button">Forward</button>
                    <button class="secondary-button pure-button">Move to</button>
                </div>
            </div>

            <div class="email-content-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <p>
                    Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <p>
                    Aliquam ac feugiat dolor. Proin mattis massa sit amet enim iaculis tincidunt. Mauris tempor mi vitae sem aliquet pharetra. Fusce in dui purus, nec malesuada mauris. Curabitur ornare arcu quis mi blandit laoreet. Vivamus imperdiet fermentum mauris, ac posuere urna tempor at. Duis pellentesque justo ac sapien aliquet egestas. Morbi enim mi, porta eget ullamcorper at, pharetra id lorem.
                </p>
                <p>
                    Donec sagittis dolor ut quam pharetra pretium varius in nibh. Suspendisse potenti. Donec imperdiet, velit vel adipiscing bibendum, leo eros tristique augue, eu rutrum lacus sapien vel quam. Nam orci arcu, luctus quis vestibulum ut, ullamcorper ut enim. Morbi semper erat quis orci aliquet condimentum. Nam interdum mauris sed massa dignissim rhoncus.
                </p>
                <p>
                    Regards,<br>
                    Tilo
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Script to make the Menu link work -->
<!-- Just stripped down version of the js/ui.js script for the side-menu layout -->
<script>
    function getElements() {
        return {
            menu: document.getElementById('nav'),
            menuLink: document.getElementById('menuLink')
        };
    }

    function toggleClass(element, className) {
        var classes = element.className.split(/\s+/);
        var length = classes.length;
        var i = 0;

        for (; i < length; i++) {
            if (classes[i] === className) {
                classes.splice(i, 1);
                break;
            }
        }
        // The className is not found
        if (length === classes.length) {
            classes.push(className);
        }

        element.className = classes.join(' ');
    }

    function toggleMenu() {
        var active = 'active';
        var elements = getElements();

        toggleClass(elements.menu, active);
    }

    function handleEvent(e) {
        var elements = getElements();

        if (e.target.id === elements.menuLink.id) {
            toggleMenu();
            e.preventDefault();
        } else if (elements.menu.className.indexOf('active') !== -1) {
            toggleMenu();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', handleEvent);
    });
</script>


    {* <div class="container">
        <div class="signin-container">
            <span class="brand">{$appData->name}</span>
        </div> <!-- /.signin-container -->
    </div> <!-- /.container --> *}
</body>
</html>
