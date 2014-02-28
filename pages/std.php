<div class="row">
    <div class="small-12 columns text-center">
<?php
if (isset($_GET['e'])){
    if (($_GET['e']==1)){
        include('a_eintrag_true.php');
    }
}

if (isset($_GET['d'])){
    
    $timestamp = $_GET['d'];
    $day = date("Y-m-d", $_GET['d']);
    $entrie = new zeiten($UserData['ID']);
    $tag = $entrie->getDay($day);
//    print_r($tag);
}

include('kalender.php');
?>

</div>
</div>

<form action="inc/common.inc.php" method="post">
    <div class="row">
            <div class="small-6 columns">
                <label>Datum
                    <input required="yes" type="date" name="date" id="date" value="<?php if(isset($tag)){echo $day;}else{$today = date("Y-m-d"); echo $today;} ?>">
                    
                </label>
            </div>
        <div class="small-6 columns">
            <label>Übernachtung
                <input type="checkbox" name="nacht" value="1" <?php if(isset($tag)){if($tag['nacht']==1){echo 'checked=\"checked\"';}} ?> id="nacht">
                
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-6 columns">
            <label>Kommen
            <input required="yes" type="time" name="kommen" id="kommen" value="<?php if(isset($tag)){if(isset($tag['start'])){echo $tag['start'];}else{echo '07:00:00';}}else{echo '07:00:00';} ?>">
            </label>
        </div>
        <div class="small-6 columns">
            <label>Gehen
            <input required="yes" type="time" name="gehen" id="gehen" value="<?php if(isset($tag)){if(isset($tag['ende'])){echo $tag['ende'];}else{echo '15:06:00';}}else{echo '15:06:00';} ?>">
            </label>
        </div>
    </div>
    <div class="row">
        
        <div class="small-6 columns">
            <label>Bereitschaft
                <input type="checkbox" name="bereit" value="1" <?php if(isset($tag)){if($tag['bereitschaft']==1){echo 'checked=\"checked\"';}} ?> id="bereit">
            </label>
        </div>
        <div class="small-6 columns">
            <label>Feiertag
                <input type="checkbox" name="feier" value="1" <?php if(isset($tag)){if($tag['feiertag']==1){echo 'checked=\"checked\"';}} ?> id="feier">
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-8 columns small-centered">
            <input type="submit" value="Eintragen" class="button expand" name="time_send" />
        </div>
    </div>
</form>