<?php

// Notez par ailleurs qu’on ajoutera généralement la lettre b au paramètre « mode » de fopen(). 
// Cela permet une meilleure compatibilité et évite les erreurs pour les systèmes qui différencient 
// les fichiers textes et binaires comme Windows par exemple.





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page admin</title>
</head>
<body>
   
    <form method="post">
<table>



<tr>
<td> <input type="text" name="delete" value="" placeholder="Enter delete word"/> </td>
</tr>
<tr>
<td> <input type="text" name="add" value="" placeholder="Add word"/> </td>
</tr>

<tr>
<td> <input type="submit" name="submit" value="Submit"/> </td>
</tr>

</table>
</form>

<?php
if(isset($_POST['submit']))
{
$content = file_get_contents('mots.txt','w');
$fcontent = str_replace($_POST['delete'], '', $content);
$file = fopen('mots.txt', 'w+');
fwrite($file,$fcontent);
fclose($file);

}


if (isset($_POST['submit'])){
    if (!empty($_POST['add'])){
       $fichier = fopen('mots.txt','c+b');
       fseek($fichier, filesize('mots.txt'));
       fwrite($fichier,$_POST['add']);
    }

}
$ressources = fopen('mots.txt', 'rb');


while (!feof($ressources)) {
    echo 'Le pointeur est au niveau du caractère ' . ftell($ressources) .
        '<br>';
    $ligne = fgets($ressources);
    echo 'La ligne "' . $ligne . '"contient '
        . strlen($ligne) . 'caractères <br><br>';
}
?>


</body>

</html>