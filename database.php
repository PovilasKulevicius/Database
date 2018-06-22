<?php
include_once 'check.php';

function InsertClient($stmt_insert){ //Funkcija skirta pridėti klientą

    $valid = false;

    //Ivedamas vardas ir tikrinama ar pirma raidė didžioji
    while($valid == false) {
        echo 'Enter name: ';
        $name = readline();

        $valid = checkCapital($name);
    }
    $valid = false;

    //Ivedama pavardė ir tikrinama ar pirma raidė didžioji
    while($valid == false) {
        echo 'Enter surname: ';
        $surname = readline();

        $valid = checkCapital($surname);
    }
    $valid = false;

    //Elektroninio pašto validacija
    while($valid == false) {
        echo 'Enter email: ';
        $email = readline();

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $valid = true;
        } else {
            echo "'$email' is not a valid email address\n";
        }
    }
    $valid = false;

    //Ivedamas ir tikrinamas telefono numeris
    while($valid == false) {
        echo 'Enter telephone number 1: ';
        $tel1 = readline();

        $valid = chechTelInput($tel1);
    }
    $valid = false;

    //Ivedamas ir tikrinamas telefono numeris
    while($valid == false) {
        echo 'Enter telephone number 2: ';
        $tel2 = readline();

        $valid = chechTelInput($tel2);
    }

    echo 'Enter a comment: ';
    $comment = readline();

    if(strlen($comment) == 0){
        $comment = '-';
    }

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_insert, 'ssssss', $name,$surname,  $email, $tel1, $tel2, $comment);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_insert);
}

function editName($email, $stmt_edit_name){

    $valid = false;

    //Ivedamas vardas ir tikrinama ar pirma raidė didžioji
    while($valid == false) {
        echo 'Enter new name'."\n";
        $name = readline();

        $valid = checkCapital($name);
    }

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_name, 'ss', $name,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_name);
}

function editSurname($email, $stmt_edit_lastname){
    $valid = false;

    //Ivedamas vardas ir tikrinama ar pirma raidė didžioji
    while($valid == false) {
        echo 'Enter new lastname'."\n";
        $lastname = readline();

        $valid = checkCapital($lastname);
    }

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_lastname, 'ss', $lastname,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_lastname);
}

function editEmail($email, $stmt_edit_email){
    echo 'Enter new email'."\n";
    $new_email = readline();

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_email, 'ss', $new_email,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_email);
}

function editTel1($email, $stmt_edit_tel1){
    $valid = false;

    while($valid == false) {
        echo 'Enter new telephone number' . "\n";
        $tel1 = readline();

        $valid = chechTelInput($tel1);
    }

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_tel1, 'ss', $tel1,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_tel1);
}

function editTel2($email, $stmt_edit_tel2){
    $valid = false;

    while($valid == false) {
        echo 'Enter new telephone number' . "\n";
        $tel2 = readline();

        $valid = chechTelInput($tel2);
    }

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_tel2, 'ss', $tel2,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_tel2);
}
function editComment($email, $stmt_edit_comment){
    echo 'Enter new comment'."\n";
    $comment = readline();

    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_edit_comment, 'ss', $comment,$email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_edit_comment);
}

function DeleteClient(&$stmt_delete, $stmt_get_email){ //Funkcija skirta ištrinti klieną

    $exists = false;
    while($exists == false) {
    echo 'Enter email of a client which you want to delete'."\n";

    $email = readline();

    $exists = checkEmail($email, $stmt_get_email); //tikrina ar yra toks pašto adresas
    }
    //parametrai priskiriami užklausai
    mysqli_stmt_bind_param($stmt_delete, 's', $email);

    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_delete);
}

function SeeAll($stmt_seeAll){ //Peržiūrėti visus
    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_seeAll);

    //gaunami rezultatai
    $result = mysqli_stmt_get_result($stmt_seeAll);

    //spausdinimas
    echo "----------------------------------------------------------------------------------\n";
    while ($row = mysqli_fetch_assoc($result)) {
            echo ' | '.$row['firstname'].' | '.$row['lastname'].' | '.$row['email'].' | '.
                $row['phonenumber1'].' | '.$row['phonenumber2'].' | '.$row['comment'].' |'."\n";
    }
    echo "----------------------------------------------------------------------------------\n";
}