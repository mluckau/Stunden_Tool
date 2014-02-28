<div class="row">
    <div class="small-12 columns text-center">
        <!--Wenn erfolgreich ausgeloggt zeige Alertbox-->
        <?php 
        if (isset($_GET['logout'])){
            if ($_GET['logout']=="true"){
                include('a_logout.php');
            }
        } 
        if (isset($_GET['login'])){
            if ($_GET['login']=="false"){
                include('a_login_false.php');
            }
        }
        ?>
        <p></p>
        <p class="panel radius">Du bist nicht angemeldet, bitte melde dich an, um die Anwendung nutzen zu können.</p>
        <p></p>
        <form action="inc/common.inc.php" method="post">
            <input type="text" name="benutzer" id="benutzer" placeholder="Benutzername">
            <input type="password" name="pass" id="pass" placeholder="Passwort">
            <input type="submit" value="Anmelden" class="button expand" name="login_send" />
        </form>
        <p></p>
        <p class="panel">Die Registrierung ist nur über eine Einladung möglich, wende dich bitte an einen Benutzer dieser App und bitte ihn um eine Einladung. Oder setze dich mit mir in Verbindung.</p>
    </div>
</div>
