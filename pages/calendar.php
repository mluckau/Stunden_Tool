<?php

function getCalendar($month,$year) {

    $daten = new zeiten(1);
    $days = $daten->getMonth($month, $year);
    $summen = $daten->getSum($month, $year);
    
    $rowNames = array('Tag', ' ', 'Kommen', 'Gehen', 'Pause', 'Arbeitszeit', 'Pool', 'Mehrarbeit', 'B', 'Ü');
    $today = date('d');
    $thisMonth = date('n');
    $thisYear = date('Y');

    $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
 
    $calendarTable = '<table align="center"; style="text-align:center"><thead><th>';
    $calendarTable .= implode('</th><th>', $rowNames);
    $calendarTable .= '</th></thead>';

    /* Kalender ausfuellen */
    for($currentDay = 1; $currentDay <= $daysInMonth; $currentDay++) {
        $evorhanden = 0;
        $WeekDayName = date('D', mktime(0, 0, 0, $month, $currentDay, $year));
        $WeekDay = date('N', mktime(0, 0, 0, $month, $currentDay, $year));
        
        foreach ($days as $d){
            if($d['tag']==$currentDay){
                $evorhanden = 1;
                $eintrag['start']=$d['start'];
                $eintrag['ende']=$d['ende'];
                $eintrag['azeit']=$d['azeit'];
                $eintrag['pause']=$d['pause'];
                $eintrag['pool']=$d['pool'];
                $eintrag['mehr']=$d['mehr'];
                $eintrag['bereit']=$d['bereitschaft'];
                $eintrag['nacht']=$d['nacht'];
                $eintrag['poolfarbe']='initial';
                
                if(!$eintrag['pool']==0){
                    if($eintrag['pool']<0){
                        $eintrag['poolfarbe'] = 'lightcoral';
                    }else{
                        $eintrag['poolfarbe'] = 'lightgreen';
                    }
                }
                
            }
        }
        $backgroundwe = '';
         if($WeekDay==6 || $WeekDay==7)
             {
             $backgroundwe = 'background-color: darksalmon';
             } 
        $calendarTable .= '<tr style="'.$backgroundwe.'">';
        
        $calendarTable .= $today == $currentDay && $month == $thisMonth && $year == $thisYear ? '<td>' : '<td>';
        $calendarTable .= $currentDay;
        $calendarTable .= '.</td>';
        $calendarTable .= '<td style="text-align:left">'.$WeekDayName.'</td>';

        
        
        if($evorhanden==1){
            $calendarTable .= '<td>'.$eintrag['start'].'</td>';
            $calendarTable .= '<td>'.$eintrag['ende'].'</td>';
            $calendarTable .= '<td>'.minToHour($eintrag['pause']).'</td>';
            $calendarTable .= '<td>'.minToHour($eintrag['azeit']).'</td>';
            $calendarTable .= '<td style="background-color: '.$eintrag['poolfarbe'].'">'.minToHour($eintrag['pool']).'</td>';
            $calendarTable .= '<td>'.minToHour($eintrag['mehr']).'</td>';
            $calendarTable .= '<td>'.$eintrag['bereit'].'</td>';
            $calendarTable .= '<td>'.$eintrag['nacht'].'</td>';
            $calendarTable .= '</tr>';
        }else{
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';
            $calendarTable .= '<td></td>';

            $calendarTable .= '</tr>';
        }

    }
    
    $calendarTable .= '<tr>';    
    $calendarTable .= '<td></td>';
    $calendarTable .= '<td></td>';    
    $calendarTable .= '<td></td>';
    $calendarTable .= '<td></td>';
    $calendarTable .= '<td></td>';
    $calendarTable .= '<td>'.minToHour($summen['azeitges']).'</td>';
    $calendarTable .= '<td>'.minToHour($summen['poolges']).'</td>';
    $calendarTable .= '<td>'.minToHour($summen['mehrges']).'</td>';
    $calendarTable .= '<td>'.$summen['bereitges'].'</td>';
    $calendarTable .= '<td>'.$summen['nachtges'].'</td>';
    $calendarTable .= '</tr>';
    $calendarTable .= '</tr></table>';

    return $calendarTable;
}
?>

<div class="row">
    <div class="small-10 large-12 columns small-centered large-centered">
        <p></p>
        <?php echo getCalendar(02, 2014);?>
    </div>
</div>