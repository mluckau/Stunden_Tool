<div class="row">
    <p></p>
    <div class="small-12 large-12 columns centered">
        <form name="register" action="inc/common.inc.php" method="POST" enctype="multipart/form-data" data-abide>
            <div class="row">
                <div class="large-3 small-6 columns">
                    <label>Vorname <small>benötigt</small><input type="text" required name="vorname" value="" placeholder="Vorname" /></label>
                    <small class="error">Erforderlich!</small>
                </div>
                <div class="large-3 small-6 columns end">
                    <label>Nachname <small>benötigt</small><input type="text" required name="name" value="" placeholder="Nachname" /></label>
                    <small class="error">Erforderlich!</small>
                </div>
                <div class="large-3 small-6 columns end">
                    <label>Personalnummer <small>benötigt</small><input type="text" required pattern="[0-9]+" name="pnumber" value="" placeholder="Personalnummer" /></label>
                    <small class="error">Darf nur Zahlen enthalten!</small>
                </div>
            </div>
            <div class="row">
                <div class="large-6 small-6 columns">
                    <label>Benutzername <small>benötigt</small><input type="text" required name="username" value="" placeholder="Benutzername" /></label>
                    <small class="error">Erforderlich!</small>
                </div>
                <div class="large-6 small-6 columns">
                    <label>Passwort <small>benötigt</small><input type="password" required id="password" name="pass1" value="" placeholder="Passwort" /></label>
                    <small class="error">Passwort entspricht nicht den Sicherheitseinstellungen!</small>
                </div>
                
            </div>
            <div class="row">
                <div class="large-6 small-6 columns">
                    <label>Email <small>benötigt</small><input type="email" required name="email" value="" placeholder="Email-Adresse" /></label>
                    <small class="error">Keine gültige Emailadresse!</small>
                </div>
                <div class="large-6 small-6 columns">
                    <label>Passwort wiederholen<input type="password" required name="pass2" value="" data-equalto="password" placeholder="Passwort wiederholen" /></label>
                    <small class="error">Passwörter stimmen nicht überein!</small>
                </div>
            </div>
            <div class="row">
                <div class="small-12 large-6 small-centered columns">
                    <label>Invite Code <small>benötigt</small><input type="text" required id="inv_code" name="inv_code" value="" placeholder="Invite-Code" /></label>
                    <small class="error">Invite-Code ist zwingend erforderlich!</small>
                </div>
            </div>
            
            <div class="row">
                <div class="small-12 large-6 small-centered columns">
                <input type="submit" value="Abschicken" class="button expand" name="reg_send" />
                </div>
            </div>
               
            
        </form>
    </div>
</div>

<?php

?>

