<div class="row">
    <?php if (isset($_GET['p'])){
        if(isset($_GET['passchange'])){
            if($_GET['passchange']==1){
                include 'a_eintrag_true.php';
            }
        }
    } ?>
    <div class="small-12 text-center">
        <p></p>
        <p>Profil von: <?php echo $UserData['vorname']."&nbsp".$UserData['name']; ?></p>
    </div>
</div>
<form action="../inc/common.inc.php" method="post">
    <div class="row">
    <div class="small-6 columns">
        <label>Vorname:
            <input type="text" name="vorname" id="vorname" value="<?php echo $UserData['vorname']; ?>">            
        </label>     
    </div>
    <div class="small-6 columns">
        <label>Nachname:
            <input type="text" name="nachname" id="nachname" value="<?php echo $UserData['name']; ?>">            
        </label>   
    </div>
</div>
<div class="row">
    <div class="small-6 columns">
        <label>Benutzername:
            <input type="text" name="username" id="username" value="<?php echo $UserData['username']; ?>">            
        </label>    
    </div>
    <div class="small-6 columns">
        <label>Email:
            <input type="email" disabled="true" name="email" id="email" value="<?php echo $UserData['email']; ?>">            
        </label>
    </div>
</div>
</form>

    <div class="row">
        
            <div class="row">
                <div class="small-6 large-6 columns">
                    <div class="panel">
                        <p>Kennwort ändern</p>
                        <form action="inc/common.inc.php" method="post">
                        <div class="row">
                            <div class="small-12 large-12 columns">
                                <label>altes Kennwort:
                                    <input required type="password" name="oldpw" id="oldpw" value="" placeholder="Kennwort">            
                                </label>
                            </div>
                            <div class="small-12 large-12 columns">
                                <label>neues Kennwort:
                                    <input required type="password" name="newpw" id="newpw" value="" placeholder="Kennwort">            
                                </label>
                            </div>
                            <div class="small-12 large-12 columns">
                                <label>Kennwort bestätigen:
                                    <input required type="password" name="newpw2" id="newpw2" value="" placeholder="Kennwort wiederholen">            
                                </label>
                            </div>
                            <div class="small-12 large-12 columns">

                                    <input type="submit" value="PW ändern" class="button expand" name="pw_change" />            

                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="small-6 large-6 columns">
                    <div class="panel">
                        <p>Einladung verschicken</p>
                        <form action="inc/common.inc.php" method="post" data-abide>
                        <div class="row">
                            <div class="small-12 large-12 columns">
                                <div class="row collapse">
                                    
                                    <div class="small-9 columns">
                                        
                                            <input required type="text" id="new_kuerzel" placeholder="Kürzel" pattern="[a-zA-Z]">
                                        
                                        <small class="error">Kürzel ist erforderlich und darf nur Buchstaben enthalten.</small>
                                    </div>
                                    <div class="small-3 columns">
                                      <span class="postfix radius">@vestas.com</span>
                                      
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="small-12 large-12 columns">

                                    <input type="submit" value="Einladung verschicken" class="button expand" name="inv_send" />            

                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        
    </div>

<script type="text/javascript">
window.onload = function () {
    document.getElementById("newpw").onchange = validatePassword;
    document.getElementById("newpw2").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("newpw2").value;
var pass1=document.getElementById("newpw").value;
if(pass1!=pass2)
    document.getElementById("newpw2").setCustomValidity("Passwort stimmt nicht überein!");
else
    document.getElementById("newpw2").setCustomValidity('');  
//empty string means no validation error
}
</script>
