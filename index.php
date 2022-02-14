<?php
session_start();

require_once('functions/functions.php');


// nouvelle partie
if (isset($_POST["reset"])) {
    session_destroy();
    header("location: index.php");
}

if (!isset($_SESSION["mot"])) {
    // j'ouvre le fihier txt
    $arrayMot = trimTab(file("mots.txt"));
    // debug($arrayMot);
    // je compte le nombre de mot dans mon fichier (array) pour définir le nombre de mot que j'ai
    // -1 car il commence a 1 et on veut commencer a 0 
    $nombreDeMot =  count($arrayMot,) - 1;

    // on rend aléatoire le mot avec la function rand 
    $numrand = rand(0, $nombreDeMot);

    $_SESSION["mot"] = $arrayMot[$numrand];
}


$alphabet = "abcdefghijklmnopqrstuvwxyz";

$_SESSION['motActuelle'] = "";
$_SESSION["motAffiche"] = "";
$_SESSION["tiret"] = "_";

$_SESSION["nbError"] = 0;
$i = 0;



$nombreDeLettre = strlen($_SESSION["mot"]);
for ($i = 0; $i < $nombreDeLettre; $i++)
    $_SESSION["motAffiche"][$i] = $_SESSION["tiret"];


// echo $nombreDeLettre;


// for($i = 1 ; $i <= 6 ; $i++)
// {
//     $_SESSION['lettresJouees'][] = 0;
// }


if (isset($_GET["a"]) && strlen($_GET["a"]) == 1 && strpos($alphabet, $_GET["a"]) !== false) {
    $char = "";
    $char = $_GET["a"];

    

    if (!isset($_SESSION["history"]) && empty($_SESSION["history"])) {

        $_SESSION["history"]  = $char;
    } else {
        
        $_SESSION["history"] .= $char;
    }

    $found = false; //variable pour compter lettre erronée 

    for ($j = 0; $j < strlen($_SESSION["history"]); $j++) {


        for ($i = 0; $i < strlen($_SESSION['mot']); $i++) {


            if ($_SESSION['mot'][$i] == $_SESSION["history"][$j] && $_SESSION["mot"] !== $_SESSION["motAffiche"]) {

                $_SESSION['motAffiche'][$i] = $_SESSION["history"][$j];

                if ($_SESSION["mot"][$i] == $char) {

                    $found = true;

                    if (isset($_SESSION["nbError"]))
                        @$_SESSION["nbError"] = strlen($_SESSION["error"]);

                    if ($_SESSION["motAffiche"] != $_SESSION["mot"])
                        $msg = "Bravo , '$char' est dans le mot";

                    else {
                        $msg = "Tu as gagné bravo <br> <img src='images/ungif.gif' alt=''>" ;
                    }
                }
            }
        }
    }


    if (!$found) {

        if (!isset($_SESSION["error"]) && empty($_SESSION["error"])) {
            $_SESSION["error"] = $char;
            $_SESSION["nbError"] = strlen($_SESSION["error"]);
            $msg = "Désolé , '$char' n'est pas dans le mot";
        } else {

            $_SESSION['error'] .= $char;
            $_SESSION["nbError"] = strlen($_SESSION["error"]);


            $msg = "Désolé , '$char' n'est pas dans le mot";
        }
    }
}
if ($_SESSION["nbError"] === 7)
    $msg = "Vous avez perdu. Recommencer";
// }




?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu du pendu</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/pendu.css">
</head>
<body>
    <div class="d-flex justify-content-center">

    <header class='titre'>
        <h1>Jeu du pendu</h1> <br>
    </header>
    </div>
    <div class="d-flex justify-content-center">

        
    <main>

        <section>

            <article>
                <?php if (isset($msg)) {
                    echo $msg;
                }
                ?>

                <img src="images/<?= $_SESSION["nbError"] ?>.jpg" alt="hangman">

                <div class="alphabet">
                    <?php
                    //Affichage du mot + alphabet
                    if ($_SESSION["nbError"] <= 6 && $_SESSION['mot'] !== $_SESSION['motAffiche']) {

                        for ($i = 0; $i < strlen($alphabet); $i++) {

                            if (isset($_SESSION['history']) && strpos($_SESSION['history'], $alphabet[$i]) === false) {

                                echo " <a href='index.php?a=$alphabet[$i]'>$alphabet[$i]</a> ";
                            } else if (!isset($_SESSION["history"])) {

                                echo " <a href='index.php?a=$alphabet[$i]'>$alphabet[$i]</a> ";
                            }
                        }
                    }
                    
                    echo $_SESSION["motAffiche"];
                    debug($_SESSION["nbError"]);
                    debug($_SESSION["mot"]);
                    ?>
                </div>

                <form action="" method="POST">

                    <input type="submit" name="reset" value="Nouvelle partie">
                </form>
                <a href="admin.php">Ajouter un mot</a>
            </article>
        </section>
    </main>
    <footer>

    </footer>
</body>
</div>
</html>