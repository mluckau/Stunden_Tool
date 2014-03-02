<?php

include_once('inc/inc.php');

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stunden</title>

        <!-- If you are using CSS version, only link these 2 files, you may add app.css to use for your overrides if you like. -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/foundation.css">
        <link rel="stylesheet" href="css/kal.css">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
        
        <script src="js/vendor/modernizr.js"></script>
    </head>
    <body>
        
        <div class="off-canvas-wrap">
            <div class="inner-wrap">
                
                
            <div class="contain-to-grid sticky">        
            <nav class="top-bar hide-for-small" data-topbar>
                <ul class="title-area">
                <li class="name">
                <h1><a href="index.php"><i class="fa fa-clock-o"></i> Stunden</a></h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
                </ul>

                <section class="top-bar-section">
                    <!-- Right Nav Section -->
                    <ul class="right">
                        <li><a href="index.php?p=std">Stunden eintragen</a></li>
                        <li class="has-dropdown">
                            <a href="#"><i class="fa fa-user"></i> 
                                <?php
                                    if (!isset ($_SESSION["userid"]))
                                    {
                                        echo "Bitte einloggen";
                                    } else {
                                        echo '<a href="index.php?p=profile">'.$_SESSION["user_vorname"].'&nbsp'.$_SESSION["user_name"].'</a>';
                                    }
                                ?>
                            </a>
                                <ul class="dropdown">
                                    <li class="has-form">
                                        <div class="row collapse">
                                            <div class="large-12 columns">
                                                <form action="inc/common.inc.php" method="post">
                                                    <input type="text" name="benutzer" id="benutzer" placeholder="Benutzername">
                                                    <input type="password" name="pass" id="pass" placeholder="Passwort">
                                                    <input type="submit" value="Anmelden" class="button expand" name="login_send" />
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                        </li>
                        <?php
                            if (isset($_SESSION["userid"]))
                            {
                                echo "<li><a href=\"index.php?action=logout\"><i class=\"fa fa-sign-out\"></i>&nbsp;Logout&nbsp;</a></li>";
                            }
                        ?>
                    </ul>

                    <!-- Left Nav Section -->
                    <ul class="left">
                        <li><a href="index.php?p=kal">Übersicht</a></li>
                    </ul>
                </section>
            </nav>
            
            <nav class="tab-bar show-for-small">
                <section class="left-small">
                    <a class="<?php if (isset($_SESSION["userid"])){echo "left-off-canvas-toggle";}?> menu-icon">
                        <span>&nbsp;Stunden</span>
                    </a>
                </section>
                
                <!--Wenn Benutzer eingeloggt ist, dann auf Smartphones den Logout-Button anzeigen-->
                <?php
                    if (isset($_SESSION["userid"]))
                    {
                        include('pages/m_logout.php');
                    }
                ?>
            </nav>
            </div>
            
            <aside class="left-off-canvas-menu">

              <ul class="off-canvas-list">
                <li><a href="http://192.168.2.105/stunden"><i class="fa fa-home"></i> Home</a></li>
                <li><label><i class="fa fa-calendar"></i> Stunden</label></li>
                <li><a href="index.php?p=std"><i class="fa fa-clock-o"></i> Stunden eintragen</a></li>
                <li><a href="index.php?p=overview"><i class="fa fa-calendar"></i> Übersicht</a></li>
                <li><a href="index.php?p=kal"><i class="fa fa-calendar"></i> Kalender</a></li>
                <li><a href="#"><i class="fa fa-suitcase"></i> Urlaub eintragen</a></li>
                <li><label><i class="fa fa-cogs"></i> Setup</label></li>
                <li><a href="index.php?p=profile"><i class="fa fa-user"></i> Benutzer</a></li>
                <li><a href="#"><i class="fa fa-tasks"></i> Daten</a></li>
                
              </ul>
            </aside>

        <section class="main-section">
            <!--Wenn Benutzer nicht eingeloggt, dann auf Smartphones den login anzeigen-->
            <?php
                if (!isset($_SESSION["userid"]))
                    {
                        include('pages/m_login.php');
                    } else {
                        $getuser = NEW user();
                        $UserData = $getuser->getUserData($_SESSION["userid"]);
                        if(isset($_GET["p"])){
                            switch($_GET["p"]){
                        case "std":
                                include('pages/std.php');
                            break;
                        case "abr":
                                include('pages/abr.php');
                            break;
                        case "profile":
                                include('pages/profile.php');
                            break;
                        case "overview":
                                include('pages/overview.php');
                            break;
                        case "kal":
                                include('pages/calendar.php');
                            break;
                        case "reg":
                                include('pages/register.php');
                            break;
                        default:
                                include('pages/mainpage.php');
                            
                        }
                        }else{
                            include('pages/mainpage.php');
                        }
                        
                    }
               
            ?>
            
        </section>
        
        

        
        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        $('#myAlert').foundation({alert: {speed: 3000}});
        </script>
                <a class="exit-off-canvas"></a>
        </div>
        </div>
    </body>
</html>
