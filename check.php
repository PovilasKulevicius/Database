<?php
function checkEmail($email, $stmt_get_email){
    //pateikiame užklausą duomenų bazei
    mysqli_stmt_execute($stmt_get_email);

    //gaunami rezultatai
    $result = mysqli_stmt_get_result($stmt_get_email);

    //tikrinimas
    $exists = false;
    while($row = mysqli_fetch_assoc($result)){
        if($row['email'] == $email){
            $exists = true;
        }
    }

    if($exists == true){
        return true;
    } else {
        echo 'No such email exist'."\n";
        return false;
    }
}

function checkCapital($str){
    if(preg_match("/^[A-Z]/", $str ) == true ){//Tikrina ar pirma raidė didžioji
        return true;
    } else {
        echo "'$str' has to start with a capital letter\n";
        return false;
    }
}

function chechTelInput($tel){
    if(strlen($tel) == 12) { //Tikrinamas ilgis
        if (preg_match("/^[+][0-9]{11}/", $tel) == false) { //Tikrinama sudėtis
            echo 'Invalid telephone number' . "\n";
            return false;
        }
    } else {
        echo 'Invalid telephone number'."\n";
        return false;
    }
    return true;
}