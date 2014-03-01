<?php
include '/../inc/db.php';

if (!isset($_SESSION)) {
  session_start();
}

if (isset($_POST['pw_change'])){
    $changepw = NEW user();
    if($changepw->updatePW($_POST['oldpw'], $_POST['newpw'])){
        header ("Location: ../index.php?p=profile&passchange=1");
    }else{
        echo "Fehler aufgetreten";
    }
}

if (isset($_GET['action'])){
    if ($_GET['action']=='logout'){
        $logout = new user();
        $logout->logout();
    }
}

if (isset($_POST['login_send'])) {
    if ($_POST['benutzer'] != '' AND $_POST['pass'] != '') {
        
        $benutzer = mysql_escape_string($_POST['benutzer']);
        $pass = $_POST['pass'];
        
        
        $user = NEW user();
        $user->login($benutzer, $pass);
        
     } else {
        
    }
    
}

if (isset($_POST['time_send'])){
    
    
    $eintrag = $_POST;
    if(isset($_POST['bereit'])){
        $time['bereitschaft'] = $_POST['bereit'];
    }else{
        $time['bereitschaft'] = 0;
    }
    
    if(isset($_POST['feier'])){
        $time['feiertag'] = $_POST['feier'];
    }else{
        $time['feiertag'] = 0;
    }
    
    if(isset($_POST['nacht'])){
        $time['nacht'] = $_POST['nacht'];
    }else{
        $time['nacht'] = 0;
    }
    
    $kommen = strtotime($_POST['kommen']);
    $gehen = strtotime($_POST['gehen']);
    
    $time['samstag'] = 0;
    $time['sonntag'] = 0;
    $time['mehrarbeit'] = 0;
    $time['date'] = $_POST['date'];
    $time['wtag'] = date('N',strtotime($_POST['date']));
    $time['tag'] = date('d',strtotime($_POST['date']));
    $time['monat'] = date('m',strtotime($_POST['date']));
    $time['jahr'] = date('Y',strtotime($_POST['date']));
    $time['kommen'] = date('H:i:s',strtotime($_POST['kommen']));
    $time['gehen'] = date('H:i:s',strtotime($_POST['gehen']));
    $diff = $gehen-$kommen;
    $time['zeit'] = $diff/60;
    if ($time['zeit']>=540){
        $time['pause'] = 45;
    }elseif($time['zeit']>=360){
        $time['pause'] = 30;
    }else {
        $time['pause'] = 0;
    }
    $time['azeit']=$time['zeit']-$time['pause'];
    
    if($time['azeit']>600){
        $time['mehrarbeit']=$time['azeit']-600;
        $time['pool']=$time['azeit']-$time['mehrarbeit']-456;
    }elseif($time['azeit']<456){
        $time['pool']=(456-$time['azeit'])*-1;
    }else{
        $time['pool']=$time['azeit']-456;
    }
    if($time['wtag']==7){
        $time['sonntag']=1;
    }
    if($time['wtag']==6){
        $time['samstag']=1;
    }
    
    $writeTime = new zeiten($_SESSION['userid']);
    $writeTime->writeTime($time);
   
}


 


function getUrlaub(){
    
}




    


function minToTime($min){
    new DateTimeZone('GMT');
    $time = date("H:i",$min*60+strtotime("1970/1/1"));
    return $time;
}

function minToHour($min){
    if($min<0){
        $positiv=$min*-1;
        $ergebniss = '-'.minToHour($positiv);
        return $ergebniss;
    }else{
        $time = sprintf("%02d", intval($min/60)).":".sprintf("%02d",($min - floor($min / 60) * 60));
        return $time;
    }
    
}

function getDays($userid,$month){
    global $db;
    $overview = " ";
    $mehrges = 0;
    $poolges = 0;
    $azges = 0;
    $sql = $db->prepare("SELECT *, DATE_FORMAT(`datum`, '%d') as `date`, TIME_FORMAT(`start`, '%H:%i') as `kommen`, TIME_FORMAT(`ende`, '%H:%i') as `gehen` FROM `stunden` WHERE `userid` = :userid AND `monat` = :monat ORDER BY `datum` ASC");
    
    $sql->bindParam('userid', $userid);
    $sql->bindParam('monat', $month);
    
    try 
    {
        $sql->execute();

    }
    catch (PDOException $e)
    {
        echo 'Datenbank-Fehler: ' . $e->getMessage();
        die();
    }
    
    while($daten = $sql->fetch()){
        $overview .= "<tr>";
        $overview .= "<td>".$daten['date']."</td>";
        $overview .= "<td>".$daten['kommen']."</td>";
        $overview .= "<td>".$daten['gehen']."</td>";
        $overview .= "<td>".minToTime($daten['pause'])."</td>";
        $overview .= "<td>".minToTime($daten['azeit'])."</td>";
        $overview .= "<td>".minToTime($daten['pool'])."</td>";
        $overview .= "<td>".minToTime($daten['mehr'])."</td>";
        $overview .= "</tr>";
        $poolges = $poolges+$daten['pool'];
        $mehrges = $mehrges+$daten['mehr'];
        $azges = $azges+$daten['azeit'];
    }
    $overview .= "<tr>";
        $overview .= "<td></td>";
        $overview .= "<td></td>";
        $overview .= "<td></td>";
        $overview .= "<td></td>";
        $overview .= "<td>".minToHour($azges)."</td>";
        $overview .= "<td>".minToHour($poolges)."</td>";
        $overview .= "<td>".minToHour($mehrges)."</td>";
        $overview .= "</tr>";
    
    return $overview;
}

class zeiten {
    
    private $entries = array();
    private $user;
    private $month;
    private $year;
    private $time;
    private $dayEntrie;
    private $sum;
    
    public function __construct($userid) {
        global $db;
        $this->db = $db;
        $this->user = $userid;
        
    }
    
    private function getMonthDB(){
        $sql = $this->db->prepare("SELECT *, DATE_FORMAT(`datum`, '%d') as `date`, TIME_FORMAT(`start`, '%H:%i') as `kommen`, TIME_FORMAT(`ende`, '%H:%i') as `gehen` FROM `stunden` WHERE `userid` = :userid AND `monat` = :monat AND `jahr` = :jahr ORDER BY `datum` ASC");
        $sql->bindParam('userid', $this->user);
        $sql->bindParam('monat', $this->month);
        $sql->bindParam('jahr', $this->year);
        $sql->execute();
        $this->entries = $sql->fetchAll();
    }
    
    public function getMonth($month,$year){
        
        $this->month = $month;
        $this->year = $year;
        $this->getMonthDB();
        return $this->entries;
    }
    
    public function writeTime($time){
        $this->time = $time;
        $tag = strtotime($this->time['date']);
        if($this->insTimeDB()){
            header ("Location: ../index.php?p=std&d=$tag&e=1");
        }
    }

    private function insTimeDB(){
        
        if($this->checkDuplicate()==false){
            $sql = $this->db->prepare("INSERT INTO `stunden` (`userid`, `datum`, `wtag`, `tag`, `monat`, `jahr`, `start`, `ende`, `pause`, `zeit`, `azeit`, `pool`, `mehr`, `bereitschaft`, `feiertag`, `sonntag`, `samstag`, `nacht`, `eintrag`) VALUES (:userid, :datum, :wtag, :tag, :monat, :jahr, :start, :ende, :pause, :zeit, :azeit, :pool, :mehr, :bereitschaft, :feiertag, :sonntag, :samstag, :nacht, NOW())");

            $sql->bindParam('userid', $this->user);
            $sql->bindParam('datum', $this->time['date']);
            $sql->bindParam('wtag', $this->time['wtag']);
            $sql->bindParam('tag', $this->time['tag']);
            $sql->bindParam('monat', $this->time['monat']);
            $sql->bindParam('jahr', $this->time['jahr']);
            $sql->bindParam('start', $this->time['kommen']);
            $sql->bindParam('ende', $this->time['gehen']);
            $sql->bindParam('pause', $this->time['pause']);
            $sql->bindParam('zeit', $this->time['zeit']);
            $sql->bindParam('azeit', $this->time['azeit']);
            $sql->bindParam('pool', $this->time['pool']);
            $sql->bindParam('mehr', $this->time['mehrarbeit']);
            $sql->bindParam('bereitschaft', $this->time['bereitschaft']);
            $sql->bindParam('feiertag', $this->time['feiertag']);
            $sql->bindParam('sonntag', $this->time['sonntag']);
            $sql->bindParam('samstag', $this->time['samstag']);
            $sql->bindParam('nacht', $this->time['nacht']);

        } else {

            $sql = $this->db->prepare("UPDATE `stunden` SET `start`=:start, `ende`=:ende, `pause`=:pause, `zeit`=:zeit, `azeit`=:azeit, `pool`=:pool, `mehr`=:mehr, `bereitschaft`=:bereitschaft, `feiertag`=:feiertag, `nacht`=:nacht WHERE  `userid`= :userid AND `datum` = :datum");

            $sql->bindParam('userid', $this->user);
            $sql->bindParam('datum', $this->time['date']);
            $sql->bindParam('start', $this->time['kommen']);
            $sql->bindParam('ende', $this->time['gehen']);
            $sql->bindParam('pause', $this->time['pause']);
            $sql->bindParam('zeit', $this->time['zeit']);
            $sql->bindParam('azeit', $this->time['azeit']);
            $sql->bindParam('pool', $this->time['pool']);
            $sql->bindParam('mehr', $this->time['mehrarbeit']);
            $sql->bindParam('bereitschaft', $this->time['bereitschaft']);
            $sql->bindParam('feiertag', $this->time['feiertag']);
            $sql->bindParam('nacht', $this->time['nacht']);
        }

            try 
            {
                $sql->execute();
                return true;
                

            }
            catch (PDOException $e)
            {
                echo 'Datenbank-Fehler: ' . $e->getMessage();
                die();
            }
   
    }
    
    private function checkDuplicate(){
        
            $sql = $this->db->prepare("SELECT `datum`, COUNT(*) FROM `stunden` WHERE `userid` = :userid AND `datum` = :datum GROUP BY `datum`");

            $sql->bindParam('userid', $this->user);
            $sql->bindParam('datum', $this->time['date']);

            try 
            {
                $sql->execute();

            }
            catch (PDOException $e)
            {
                echo 'Datenbank-Fehler: ' . $e->getMessage();
                die();
            }
            $count = $sql->rowCount();

            if($count>=1){
                return true;
            }else{
                return false;
            }
    }
    
    public function getDay($day){
        $this->day = $day;
        $this->getDayDB();
        return $this->dayEntrie;
    }
    
    private function getDayDB(){
        $sql = $this->db->prepare("SELECT *, DATE_FORMAT(`datum`, '%d') as `date`, TIME_FORMAT(`start`, '%H:%i') as `kommen`, TIME_FORMAT(`ende`, '%H:%i') as `gehen` FROM `stunden` WHERE `userid` = :userid AND `datum` = :datum");
        $sql->bindParam('userid', $this->user);
        $sql->bindParam('datum', $this->day);
        $sql->execute();
        $this->dayEntrie = $sql->fetch();
        
    }
    
    public function getSum($month,$year){
        $this->month = $month;
        $this->year = $year;
        $this->getSumDB();
        return $this->sum;
    }
    
    private function getSumDB(){
        $sql = $this->db->prepare("SELECT sum(`pool`) as `poolges`, sum(`azeit`) as `azeitges`, sum(`mehr`) as mehrges, sum(`bereitschaft`) as `bereitges`, sum(`nacht`) as `nachtges` FROM `stunden` WHERE `userid` = :userid AND `monat` = :monat AND `jahr` = :jahr");
        $sql->bindParam('userid', $this->user);
        $sql->bindParam('monat', $this->month);
        $sql->bindParam('jahr', $this->year);
        $sql->execute();
        $this->sum = $sql->fetch();
    }
    
    public function __destruct() {
        $this->db = null;
    }
}

class berechnungen {
    private $daten = array();
    private $zeiten = array();
    
    public function __construct($zeiten){
        $this->zeiten = $zeiten;
    }
    
    private function poolstd(){
        
    }
    
    public function zeiten(){
                
        $this->daten['poll'] = $this->poolstd();
    }
}

class user {
    
    private $userData = array();
    private $db;
    private $data = array();
    
    public function __construct(){
        global $db;
        $this->db = $db;
    }
    
    public function login($benutzer, $pass) {

        $this->userData = $this->userLogin($benutzer, $pass);
   
        if ($this->userData==false){
                header ("Location: ../index.php?login=false");
        } else {
                
                $this->set_Session($this->userData);
                header ("Location: ../index.php");
                     
        } 
        
    }
    
    private function userLogin($benutzer,$pass){
    
        
    
    $sql = $this->db->prepare("SELECT * FROM `user` WHERE `username` = :username");
            
    $sql->bindParam('username', $benutzer);
    $this->executeStm($sql);
    
    $count = $sql->rowCount();
    
        if ($count > 0) {
            $this->data = $sql->fetch();
                if($this->verifyPW($pass, $this->data['ID'])){
                    return $this->data;
                }
        } else {
            $this->db = null;
            return false;
        }
    }
    
    private function set_Session($loginData) {
                $b_id = $loginData["ID"];
                $this->lastLogin($b_id);
                $_SESSION["userid"] = $loginData["ID"];
                $_SESSION["username"] = $loginData["username"];
                $_SESSION["useremail"] = $loginData["email"];
                $_SESSION["user_name"] = $loginData["name"];
                $_SESSION["user_vorname"] = $loginData["vorname"];
    }
    
    private function lastLogin($b_id){
        
    $sql = $this->db->prepare("UPDATE `user` SET `last_login`= NOW() WHERE  `ID` = :b_id");
    
    $sql->bindParam('b_id', $b_id);
    
    $this->executeStm($sql);
    
    }
    
    public function getUserData($b_id){
        
    $sql = $this->db->prepare("SELECT * FROM `user` WHERE `ID` = :b_id");
    
    $sql->bindParam('b_id', $b_id);
    
    $this->executeStm($sql);
    
        $count = $sql->rowCount();
    
    if ($count > 0) {
            $User = $sql->fetch();
            return $User;
        } else {
            $this->db = null;
            return false;
        }
    }
    
    public function logout(){
        ob_start (); 
        session_start ();

        session_unset (); 
        session_destroy ();

        header ("Location: index.php?logout=true"); 
        ob_end_flush ();
    }
    
    public function register($newuser){
        $sql = $this->db->prepare('');
        
    }
    
    public function updatePW($oldPW,$newPW){
        
        $hashnewPW = $this->hashPW($newPW);
        if($this->verifyPW($oldPW,$_SESSION['userid'])){
            $sql = $this->db->prepare('UPDATE `user` SET `password` = :newPW WHERE `ID` = :userid');
            $sql->bindParam('newPW', $hashnewPW);
            $sql->bindParam('userid', $_SESSION['userid']);
               try 
        {
            $sql->execute();
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Datenbank-Fehler: ' . $e->getMessage();
            die();
        }
        }
     }
    
    private function checkPW($pass){
        $sql = $this->db->prepare('SELECT * FROM `user` WHERE `ID` = :userid AND `password` = :PW');
        $sql->bindParam('userid', $_SESSION['userid']);
        $sql->bindParam('PW', $this->hashPW($pass));
        $count = $sql->rowCount();
        if ($count>0){
            return true;
        }else{
            return false;
        }
    }
    
    private function hashPW($pass){
        $cost = 12;
        $hash = password_hash($pass, PASSWORD_BCRYPT, ["cost" => $cost]);
        return $hash;
    }
    
    private function verifyPW($pass,$userid){
        if(password_verify($pass, $this->getPW($userid))){
            return true;
        }else{
            return false;
        }
    }
    
    private function getPW($userid){
        $sql = $this->db->prepare('SELECT `password` FROM `user` WHERE `ID` = :userid');
        $sql->bindParam('userid', $userid);
        $this->executeStm($sql);
        $count = $sql->rowCount();
        if ($count>0){
            $PW = $sql->fetch();
            return $PW['password'];
        }else{
            return false;
        }
        
    }
    
    private function executeStm($sql){
            try 
        {
            $sql->execute();
            return true;
        }
        catch (PDOException $e)
        {
            echo 'Datenbank-Fehler: ' . $e->getMessage();
            die();
        }
    }
    
    public function __destruct() {
        $this->db = NULL;
    }
    
}

?>