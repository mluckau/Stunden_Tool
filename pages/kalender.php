<?php
setlocale(LC_TIME, "de_DE");
$kal_datum = time();
$kal_tage_gesamt = date("t", $kal_datum);
$kal_start_timestamp = mktime(0,0,0,date("n",$kal_datum),1,date("Y",$kal_datum));
$kal_start_tag = date("N", $kal_start_timestamp);
$kal_ende_tag = date("N", mktime(0,0,0,date("n",$kal_datum),$kal_tage_gesamt,date("Y",$kal_datum)));
$kal_month=utf8_decode(strftime("%m", $kal_datum));
$kal_year= date("Y", $kal_datum);

$eintrag = new zeiten($UserData['ID']);
$tage = $eintrag->getMonth($kal_month,$kal_year);


?>
<div class="row">
    
    <div class="small-10 large-3 columns small-centered large-centered">
        <p></p>
        <div class="row">
            <div class="small-2 columns">
                <a href="#"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="small-8 columns text-center">
                <p><?php echo utf8_decode(strftime("%B %Y", $kal_datum)); ?></p>
            </div>
            <div class="small-2 columns text-center">
                <a href="#"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="small-10 large-6 columns small-centered large-centered">
<table class="kalender" align="center" style="text-align: center; ">
    
  <thead>
    <tr>
      <th>Mo</th>
      <th>Di</th>
      <th>Mi</th>
      <th>Do</th>
      <th>Fr</th>
      <th>Sa</th>
      <th>So</th>
    </tr>
  </thead>
  <tbody>
<?php
    
    
  for($i = 1; $i <= $kal_tage_gesamt+($kal_start_tag-1)+(7-$kal_ende_tag); $i++)
  {
    $kal_anzeige_akt_tag = $i - $kal_start_tag;
    $kal_anzeige_heute_timestamp = strtotime($kal_anzeige_akt_tag." day", $kal_start_timestamp);
    $kal_anzeige_heute_tag = date("j", $kal_anzeige_heute_timestamp);
    
    $txtfarbe = 'black';
    $bgfarbe = 'initial';
    $link = 'index.php?p=std&d='.$kal_anzeige_heute_timestamp;
    foreach($tage as $v){
            if($v['tag']==$kal_anzeige_heute_tag){
                $txtfarbe = 'green';
                
            }
        }
        
  
    
    if(date("w",$kal_anzeige_heute_timestamp)==0 || date("w",$kal_anzeige_heute_timestamp)==6){
        $bgfarbe = 'antiquewhite';
    }
        
    if(date("N",$kal_anzeige_heute_timestamp) == 1){
        echo "    <tr>\n";
    }
    if(isset($timestamp)){

        if($timestamp == $kal_anzeige_heute_timestamp){
            echo "      <td class=\"kal_aus_tag\"style=\"color: $txtfarbe;background-color: skyblue\"><a style=\"color: $txtfarbe;background-color: skyblue\" href=\"$link\">",$kal_anzeige_heute_tag,"</a></td>\n";
                   
            
                }elseif(date("dmY", $kal_datum) == date("dmY", $kal_anzeige_heute_timestamp)){
                    echo "      <td class=\"kal_aktueller_tag\"style=\"background-color: $bgfarbe\"><a style=\"background-color: $bgfarbe\" href=\"$link\">",$kal_anzeige_heute_tag,"</a></td>\n";
                }

                elseif($kal_anzeige_akt_tag >= 0 AND $kal_anzeige_akt_tag < $kal_tage_gesamt){


                    echo "      <td class=\"kal_standard_tag\" style=\"color: $txtfarbe;background-color: $bgfarbe\"><a style=\"color: $txtfarbe;background-color: $bgfarbe\" href=\"$link\">",$kal_anzeige_heute_tag,"</a></td>\n";
                }

                else {
                    echo "      <td class=\"kal_vormonat_tag\">",$kal_anzeige_heute_tag,"</td>\n";
                }

                if(date("N",$kal_anzeige_heute_timestamp) == 7){
                    echo "    </tr>\n";
                }
        
    }elseif(date("dmY", $kal_datum) == date("dmY", $kal_anzeige_heute_timestamp)){
        echo "      <td class=\"kal_aktueller_tag\"style=\"background-color: $bgfarbe\"><a style=\"background-color: $bgfarbe\" href=\"$link\">",$kal_anzeige_heute_tag,"</a></td>\n";
    }
      
    elseif($kal_anzeige_akt_tag >= 0 AND $kal_anzeige_akt_tag < $kal_tage_gesamt){
        
        
        echo "      <td class=\"kal_standard_tag\" style=\"color: $txtfarbe;background-color: $bgfarbe\"><a style=\"color: $txtfarbe;background-color: $bgfarbe\" href=\"$link\">",$kal_anzeige_heute_tag,"</a></td>\n";
    }
      
    else {
        echo "      <td class=\"kal_vormonat_tag\">",$kal_anzeige_heute_tag,"</td>\n";
    }
      
    if(date("N",$kal_anzeige_heute_timestamp) == 7){
        echo "    </tr>\n";
    }
      
  }

?>
  </tbody>
</table>
    </div>
</div>
    
</div>