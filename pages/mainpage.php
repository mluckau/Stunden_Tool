<div class="row">
    <div class="small-12 large-12 columns text-center">
        <p></p>
        <p class="panel">Hallo <?php echo $UserData["vorname"]."&nbsp".$UserData["name"]."&nbsp;<br>Personalnummer: ".$UserData['pers_nr'];?></p>
    </div>
</div>

<div class="row">
    <div class="small-12 columns text-center">
        <h3>Aktueller Stand:</h3>
    </div>
</div>

<div class="row text-right">
    <div class="small-4 columns">
        <p>Poolstunden:</p>
    </div>
    <div class="small-4 columns">
        <p><?php echo $UserData['pool']?>&nbsp;h</p>
    </div>
    <div class="small-4 columns">
        <p><?php $poolTage = round($UserData['pool']/7.6,1); echo "&asymp;&nbsp;".$poolTage."&nbsp;Tage"; ?></p>
    </div>
</div>    

<div class="row text-right">
    <div class="small-4 columns">
        <p>Urlaubstage:</p>
    </div>
    <div class="small-3 columns">
        <p><?php echo $UserData['urlaub']?>&nbsp;Tage</p>
    </div>
</div>

<div class="row text-right">
    <div class="small-4 columns">
        <p>Gesamt:</p>
    </div>
    <div class="small-4 columns">
        <p><?php echo $UserData['urlaub']+$poolTage?>&nbsp;Tage</p>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <a href="index.php?p=std" class="button expand">Stunden eintragen</a>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <a href="index.php?p=abr" class="button expand">Abrechnung ansehen</a>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <a href="index.php?p=url" class="button expand">Urlaub beantragen</a>
    </div>
</div>
     