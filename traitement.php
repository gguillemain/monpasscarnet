<!DOCTYPE html>
<html>
    <head>
        <title>Traitement de la requ&ecirc;te</title>
        <meta charset="utf-8">
       <link rel="stylesheet" href="edt.css">
    </head>
    <body>
        <h1>V&eacute;rification de l'envoi</h1> 
<?php
$jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
$lettrejours=['A', 'B', 'C', 'D', 'E'];
$meridium=['M', 'S'];
$mat='1';

if(isset($_POST['cla'])) {
$classe = $_POST['cla'];
echo "<h2>Vous avez sélectionné pour la division :&nbsp;<span style='width:40px; height:40px; background: #900C3F; color:#FFC300; padding:2px;'>".$classe ."</span></h2></br>";
}

for($i = 0;$i < count($jours);$i++){
  echo "<div class=jour style='background: #DAF7A6; border: 2px solid #DAF7A6; width=250px;float:left;'>";
  echo $jours[$i]."</br>";
  for($j=0;$j<count($meridium);$j++){
    if($meridium[$j]=='M') echo "<div class='matin'>";
    if($meridium[$j]=='S') echo "<div class='am'>";
    for($k=1;$k<5;$k++){

      //echo $jours[$i]."\n";
      $mat= $lettrejours[$i].$meridium[$j].$k; //ai enlevé "matieres".
      $titre=$meridium[$j].$k.": ";
      ////////////////////////////////ESSAI
      //echo $mat;
      if(isset($_POST[$mat])) {
      $contenu = $_POST[$mat];
      if($_POST[$mat]=='PAS_COURS'){$contenu='pas cours';}
      echo $titre . $contenu."</br>";
    }
    //echo $mat;
    }
    echo "</div>";
  }
  echo "</div>";
}

echo '<pre>';
print_r($_POST);
echo '</pre>';

?>




<?php
            // $servname = 'mathebasetg.mysql.db';
            // $dbname = 'mathebasetg';
            // $user = 'mathebasetg';
            // $pass = 'Setg9169';

            // try{
            //     $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
            //     $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            //     //$sql = "INSERT INTO 3A(AM1,AM2,AM3,AM4)
            //       //      VALUES('Giraud','Pierre','4C','EXT')";
                
            //     $dbco->exec($sql);
            //     echo 'Entrée ajoutée dans la table';
            // }
            
            // catch(PDOException $e){
            //   echo "Erreur : " . $e->getMessage();
            // }
        ?>
    </body>
</html>