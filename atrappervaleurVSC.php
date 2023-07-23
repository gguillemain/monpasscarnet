<!DOCTYPE html>
<html>

<head>
    <title>Scan DB Eleve</title>
    <meta charset='utf-8'>
    <link rel="stylesheet" href="edt.css">
</head>

<body>
    <h1>R&eacute;sultat du scan :</h1>
    <?php
    $servname = "mathebasetg.mysql.db";
    $dbname = "mathebasetg";
    $user = "mathebasetg";
    $pass = "Setg9169";
    $nom = $_GET["nom"];
    $prenom = $_GET["prenom"];
    $classe = $_GET["classe"];
    $meridium = ['M', 'S'];
    //preparation pour essai
    $creneau = 'ES4'; // test creneau
    //$creneau='F';//test weekend
    //$creneau=creneaucourant();//test creneau courant



    try {


        echo "<div class='conteneur'>";

        $dbco = new PDO("mysql:host=$servname;dbname=$dbname", $user, $pass);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*Sélectionne les valeurs dans les colonnes prenom et mail de la table
                 *users pour chaque entrée de la table -- 
                Premiere requete afficher le creneau:matiere de la classe concernée*/
        $sth = $dbco->prepare("SELECT * FROM $classe ");
        $sth->execute();
        /*Retourne un tableau associatif pour chaque entrée de notre table
                 *avec le nom des colonnes sélectionnées en clefs*/
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

        //Deuxieme requete concernant le regime de l'eleve
        $rth = $dbco->prepare("SELECT regime FROM membres WHERE nom='$nom' and prenom='$prenom' and classe='$classe' ");
        $rth->execute();
        /*Retourne un tableau associatif pour chaque entrée de notre table
                 *avec le nom des colonnes sélectionnées en clefs*/
        $regime = $rth->fetchAll(PDO::FETCH_ASSOC);
        $result=$resultat[0];
        $sortir = verifsortie($creneau, $result,$regime);

        echo "<div class=regime>";
        echo $regime[0]['regime'];
        echo "</div>";

        //Affiche le nom prenom et classe de l'eleve
        echo "<div class='resultat' style='background-color:" . $sortir[10] . "'>";
        echo "<h1>" . $classe . "<h1></br><h2>" . $nom . "&nbsp;" . $prenom . "</h2></br>";
        echo "<div><h2>Mati&egrave;re courante : " . $result[$creneau] . " </h2></div>";
        echo "</div>";


        //Affiche l'edt du jour courant de l'eleve
        //$jourcourant=trim($creneau,"MS1234");
        echo "<div class='edtjour'>";

        echo $creneau . "</br>"; //afficher à quoi correspond l'edt
        //$horshoraire=ltrim($creneau,"ABCDE\t");////////
        for ($i = 0; $i < 8; $i++) {
            echo "<div>";
            echo $sortir[$i] . "</br>";
        }
        echo "</div>";

        if ($sortir[9] == '') {
            echo "Sortie apr&egrave;s " . $sortir[8] . "</br>";
        } else {
            echo $sortir[9] . "</br>";
        }

        //////////////////////////////////////////////////////////////////////////////////////:ESSAI


        //////////////////////////////////////////////////////////////////////////////////////FIN ESSAI
        echo "</div>";
    }
    /*print_r permet un affichage lisible des résultats,
                 *<pre> rend le tout un peu plus lisible*/
    // echo '<pre>';
    // print_r($resultat);
    // echo '</pre>';
    //}


    catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
    ///////////////////////////////////////////////////////////FONCTIONS////////////////////////////////////////////////:
    function datefr($jour = 'none')
    {
        $lettrejour = ['A', 'B', 'C', 'D', 'E', 'F', 'F'];
        $day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        for ($i = 0; $i < count($lettrejour); $i++) {
            if (date("l") == $day[$i]) {
                $jour = $lettrejour[$i];
            }
        }
        return $jour;
    }

    function jourfrancais($jour = 'none')
    {
        $jourfr = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        for ($i = 0; $i < count($jourfr); $i++) {
            if (date("l") == $day[$i]) {
                $jour = $jourfr[$i];
            }
        }
        return $jour;
    }

    function creneaucourant()
    {
        // Définir le nouveau fuseau horaire et recuperer la lettre du jour et le creneau actuel
        date_default_timezone_set('Europe/Paris');
        $date = date('H:i');
        $heurestr = stristr($date, ':', true);
        $minutetemp = stristr($date, ':');
        $minutestr = substr($minutetemp, 1, 2);
        $heure = intval($heurestr);
        $minute = intval($minutestr);
        $somme = $heure * 60 + $minute;
        $creneau = 'rien';
        echo 'Week-end !';
        $creneau = datefr(date("l"));
        if (datefr(date("l")) !== 'F') {

            if ($somme > 475 and $somme < 535) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " M1</h1></div>";
                $creneau = datefr(date("l")) . 'M1';
            }
            if ($somme > 536 and $somme < 590) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " M2</h1></div>";
                $creneau = datefr(date("l")) . 'M2';
            }
            if ($somme > 591 and $somme < 605) {
                echo 'RECRE';
                $creneau = 'RECRE';
            }
            if ($somme > 606 and $somme < 665) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " M3</h1></div>";
                $creneau = datefr(date("l")) . 'M3';
            }
            if ($somme > 666 and $somme < 720) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " M4</h1></div>";
                $creneau = datefr(date("l")) . 'M4';
            }
            if ($somme > 721 and $somme < 810) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " REPAS</h1></div>";
                $creneau = datefr(date("l")) . 'REPAS';
            }
            if ($somme > 811 and $somme < 865) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " S1</h1></div>";
                $creneau = datefr(date("l")) . 'S1';
            }
            if ($somme > 866 and $somme < 920) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " S2</h1></div>";
                $creneau = datefr(date("l")) . 'S2';
            }
            if ($somme > 921 and $somme < 935) {
                echo 'RECRE';
                $creneau = datefr(date("l")) . 'RECRE';
            }
            if ($somme > 936 and $somme < 990) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " S3</h1></div>";
                $creneau = datefr(date("l")) . 'S3';
            }
            if ($somme > 991 and $somme < 1045) {
                echo "<div class='classe'><h1>Creneau : " . jourfrancais(date("l")) . " S4</h1></div>";
                $creneau = datefr(date("l")) . 'S4';
            }
            if ($somme > 1046) {
                echo 'Fini la journée';
                $creneau = datefr(date("l")) . 'S5';
            }
            if ($somme < 474) {
                echo 'Allez en cours!';
                $creneau = datefr(date("l")) . 'M0';
            }
        }
        return $creneau;
    }

    function premiercours($creneau = 'DM3', $result = [''])
    {
        $rep = 'salut';
        if (ltrim($creneau, "ABCDE") == 'M0') {
            $c = trim($creneau, "MS01234");
            foreach ($result as $matiere => $valeur) {
                $m = trim($matiere, "MS1234");
                //$meri=trim($matiere,"ABCDEF1234");
                if ($c == $m and $valeur != 'pas cours') {
                    $rep = $valeur;
                    break;
                }
            }
        }
        return $rep;
    }

    function verifsortie($creneau = 'DM3', $result = [''],$regime=[''])
    {
        $pascoursM = 0;
        $pascoursS = 0;

        //elements à retourner :
        $sortie = '';
        $autrecas = '';
        $couleursortie = 'white';
        $retour = ['', '', '', '', '', '', '', '', $sortie, $autrecas, $couleursortie];
        $horshoraire = ltrim($creneau, "ABCDE");
        //Parcourt l'edt du jour courant on récupère le premier cours non vide
        $p = 0;
        foreach ($result as $matiere => $valeur) {

            $c = trim($creneau, "MS1234");
            $m = trim($matiere, "MS1234");
            $meri = trim($matiere, "ABCDEF1234");
            if ($c == $m) {
                $retour[$p] = trim($matiere, "ABCDEF") . ' : ' . $valeur . '<br>';
                $p = $p + 1;
                if ($valeur == 'pas cours' and $meri == 'M') {
                    $pascoursM = $pascoursM + 1;
                }
                if ($valeur == 'pas cours' and $meri == 'S') {
                    $pascoursS = $pascoursS + 1;
                }
            }
        }

        switch ($pascoursS) {
            case 0:
                $sortie = 'S4';
                break;
            case 1:
                $sortie = 'S3';
                break;
            case 2:
                $sortie = 'S2';
                break;
            case 3:
                $sortie = 'S1';
                break;
            case 4:
                $autrecas = "pas cours de l'am</br>";
                break;
        }
        if ($regime[0]['regime'] == 'EXT') {
            switch ($pascoursM) {
                case 0:
                    $sortie = 'M4';
                    break;
                case 1:
                    $sortie = 'M3';
                    break;
                case 2:
                    $sortie = 'M2';
                    break;
                case 3:
                    $sortie = 'M1';
                    break;
                case 4:
                    $autrecas = "pas cours de la matinée</br>";
                    break;
            }
            switch ($pascoursS) {
                case 0:
                    $sortie = 'S4';
                    break;
                case 1:
                    $sortie = 'S3';
                    break;
                case 2:
                    $sortie = 'S2';
                    break;
                case 3:
                    $sortie = 'S1';
                    break;
                case 4:
                    $autrecas = "pas cours de l'am</br>";
                    break;
            }
        }


        //Gestion des cas hors horaire scolaire
        $horshoraire = ltrim($creneau, "ABCDE");
        switch ($horshoraire) {
            case 'RECRE':
                $autrecas = 'R&eacute;cr&eacute;ation';
                break;
            case 'REPAS':
                $autrecas = 'Bon app&eacute;tit';
                break;
            case 'S5':
                $autrecas = 'Les cours sont finis';
                break;
            case 'M0':
                $autrecas = 'Les cours commencent bientôt';
                $retour[3] = 'Premier cours :';
                $retour[4] = premiercours($creneau, $result);
                break;
            case 'F';
                $autrecas = "Reposez-vous, c" . "'" . "est le week-end";
                break;
        }


        //option de retour de fonction
        $couleursortie = "#C70039";
        if (trim($creneau, "ABCDEF1234") == trim($sortie, "1234") and intval(trim($creneau, "ABCDEFGMS")) >= intval(trim($sortie, "MS")) + 1) {
            $couleursortie = '#DAF7A6';
        }
        if ($autrecas != '') {
            $couleursortie = "#FFC300";
        }
        $retour[8] = $sortie;
        $retour[9] = $autrecas;
        $retour[10] = $couleursortie;
        return $retour;
    }
    ?>
</body>

</html>