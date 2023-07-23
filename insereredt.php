<!DOCTYPE html>
<html>
    <head>
        <title>Insérer un EDT</title>
        <meta charset="utf-8">
       <link rel="stylesheet" href="edt.css">
    </head>
    <body>
        <h1>Envoi d'emploi de temps</h1>  

        
            <!-- Formulaire qui enverra une requête POST à l'URL actuelle -->
           <form method="post" action="traitement.php">
        <!--select classe-->
        <div class="classe">
        <label for="classe"><h3>classe :</h3></label>
         <?php
            $lettreclasse=['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            $niveau=['3', '4', '5', '6'];
            echo "<select name='cla' id='cla'>";
            for($m = 0;$m < count($niveau);$m++){
                for($n = 0;$n < count($lettreclasse);$n++){
                echo "<option value='".$niveau[$m].$lettreclasse[$n]."'>".$niveau[$m].$lettreclasse[$n]."</option>";
                }
            }
        echo "</select></br>";
        ?>
        </div>


        <!--select EDT-->
        <?php
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $lettrejours=['A', 'B', 'C', 'D', 'E'];
        $meridium=['M', 'S'];
        $matiere=['PAS_COURS', 'MATHEMATIQUES', 'FRANCAIS', 'HG/EMC', 'ANGLAIS', 'ALLEMAND', 'S.PHYSIQUES','SVT', 'TECHNOLOGIE', 'MUSIQUE','ARTS', 'EPS', 'LATIN'];
        $nom='matieres';
        
        for($i = 0;$i < count($jours);$i++){
          echo "<div class=jour>";
          echo "<h3>".$jours[$i]."</h3>";
            for($j=0;$j<count($meridium);$j++){
            if($meridium[$j]=='M') echo "<div class='matin'>";//class css matin
            if($meridium[$j]=='S') echo "<div class='am'>";//class css am
                for($k=1;$k<5;$k++){
                echo "<label>".$meridium[$j].$k." :</label>";
                $nom= $lettrejours[$i].$meridium[$j].$k; //ai enlevé "matieres".
                echo "<select name=".$nom." id=".$nom.">";
                for($r = 0;$r < count($matiere);$r++){
                    echo "<option value=".$matiere[$r].">".$matiere[$r]."</option>";
                }
                echo "</select></br>";
            }
            echo "</div>";
          }
          echo "</div>";
        }
        ?>
        
        <input type="submit" value="Envoyer" /> 
           </form>
    </body>
</html>
