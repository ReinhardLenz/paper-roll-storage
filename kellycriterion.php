<?php
 include('templates/header.php');

$xml=simplexml_load_file("languages_kelly.xml") or die("xml not found!");
$KE1 =$xml->KE1->$lang;
$KE2 =$xml->KE2->$lang;
$KE3 =$xml->KE3->$lang;
$KE4 =$xml->KE4->$lang;
$KE5 =$xml->KE5->$lang;
$KE6 =$xml->KE6->$lang;
$KE7 =$xml->KE7->$lang;
$KE8 =$xml->KE8->$lang;
$KE9 =$xml->KE9->$lang;
$KE10 =$xml->KE10->$lang;
$KE11 =$xml->KE11->$lang;
$KE12 =$xml->KE12->$lang;
$KE13 =$xml->KE13->$lang;
$KE14 =$xml->KE14->$lang;
$KE15 =$xml->KE15->$lang;
$KE16 =$xml->KE16->$lang;



// vuorovaikuta-v2.php

echo "<h1>";
echo $KE13;
echo "</h1>";

echo "<h2>";
echo "<p>";
echo $KE7;
echo "</h2>";

echo "<br>";
echo "<p>";
echo $KE16;
echo "</p>";
?>
<br>
<img src="casino.jpeg"  width="300" height="160">
<br>

<?php

echo "<br>";
echo "<p>";
echo $KE8;
echo "</p>";

?>
<br>
<a href="https://dqydj.com/kelly-criterion-asset-allocation-calculator/">Online calculator</a>
<br>

<?php

echo "<br>";
echo "<p>";
echo $KE9;
echo "</p>";
?>
<br>
<img src="Kelly-formular.png"  width="673" height="53">
<br>

<?php
echo "<br>";
echo "<p>";
echo $KE10;
echo "</p>";


$probability   = 60;
$odds     = 1;
$start_cap     = 25;
$fraction_wagered =20;
$tulostaa_kaikki  = 0;

if (isset($_GET['painike'])) {
   $probability   = $_GET['probability'];
   $odds     = $_GET['odds'];
   $start_cap   = $_GET['start_cap'];
   $fraction_wagered   = $_GET['fraction_wagered'];

   $tulostaa_kaikki  = tulostaa_kaikki($probability, $odds, $start_cap,$fraction_wagered);
}

tulosta_sivun_alku();
tulosta_lomake($probability, $odds,$start_cap,$fraction_wagered);
if (isset($_GET['painike'])) {
    $tulostaa_kaikki  = tulostaa_kaikki($probability, $odds, $start_cap,$fraction_wagered);
    echo $tulostaa_kaikki;
}

// Huomaa: tulosta_lomake-funktion aluksi vaihdetaan
// HTML-moodiin, jotta HTML-kieltä voidaan kirjoittaa sellaisenaan

function tulosta_lomake($probability, $odds,$start_cap,$fraction_wagered) {
global $KE2 ,$KE3,$KE4,$KE5,$KE11;
?>
<form method="get"
        action="<?php echo $_SERVER['PHP_SELF'];?>">
<?php echo $KE2?> 0..100%:<br><input type="text"    name="probability" value="<?php
                echo $probability;?>"><br>
<?php echo $KE3?>:<br><input type="text" name="odds" value="<?php
                echo $odds;?>"><br>
<?php echo $KE4?>:<br><input type="text" name="start_cap" value="<?php
                 echo $start_cap;?>"><br>
<?php echo $KE11?>:<br><input type="text" name="fraction_wagered" value="<?php
                 echo $fraction_wagered;?>"><br>
    <p>
<input type="submit" name="painike"
       value=<?php echo $KE5?>>
</form>

<?php
}

function tulosta_sivun_alku() {

  global $KE1 ,$KE3,$KE4,$KE5,$KE11;
   $aikaleima = time();

   echo "<a href='{$_SERVER['PHP_SELF']}?tt=$aikaleima'>";
   echo $KE1."</a>";
}

function tulostaa_kaikki($probability, $odds,$start_cap,$fraction_wagered) {
    global $KE1, $KE2,$KE3,$KE4,$KE5,$KE6,$KE11,$KE12;
   
    $html = "<hr>" .
            $KE2. "  <strong>$probability</strong> %<br>" .
            $KE3. " <strong>$odds</strong><br>" .
            $KE4. "  <strong>$start_cap</strong> Dollar<br>" .           
            $KE11. "  <strong>$fraction_wagered</strong> %<p>" .           "<hr>";

           $fraction_wagered_float_p=(100-$fraction_wagered)/100;
           $fraction_wagered_float_q=$fraction_wagered/100;
           $day=range(1,20,1);
           $winloose=range(1,20,1);
           $capital=range(1,20,1);
           $capital[0]=$start_cap;
           for($n=1;$n<20;$n++){
               $winloose[$n]=rand(0,100);    
                   if($winloose[$n]<$probability){
                       $winloose[$n]=1;
                   }
                   else{$winloose[$n]=0;}
           }
           for($n=1;$n<20;$n++){
               if($winloose[$n]==0){
                   $capital[$n]=round($capital[$n-1]*$fraction_wagered_float_p,0, PHP_ROUND_HALF_DOWN);
               }else{
                   $capital[$n]=round($capital[$n-1]*(1+($odds*$fraction_wagered_float_q)), 0, PHP_ROUND_HALF_UP);
               }

           }

           $max_height_corresponds=max($capital);
           for($n=1;$n<20;$n++){

           $height[$n]=strval(round(300*$capital[$n]/$max_height_corresponds,PHP_ROUND_HALF_DOWN));
                if($height[$n]==0){$height[$n]=1;}
        }
           $html .= "<table>";
           $html .= "<tr>";

        for($n=1;$n<20;$n++){
            $html .= "<th valign='bottom'>";
            $temporary="<img src='bar.png'  width='10' height='".$height[$n]."'>";
            $html .=$temporary;
            $html .= "</th>";
        }
        $html .= "</tr>";
        $html .= "</table>";
        $html .="<hr>";

        for($n=1;$n<20;$n++){
            $html .= $KE6;
            $html .= " ";
            $html .= $day[$n-1];
            if($winloose[$n]==1){
                $html .= " win ";    
            }else{
                $html .= " lost ";
            }
            $html .= $KE12;
            $html .= $capital[$n];
            $html .= " Dollars";
            $html .="<br>";
        }


   return $html;
}

include('templates/footer.php');

?>