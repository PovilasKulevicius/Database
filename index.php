<?php
include_once 'menu.php';
include_once 'database.php';

    $conn = new mysqli('localhost', 'root', '', 'database');
    //Šablonai
    $sql_insert = 'INSERT INTO klientai VALUES (?, ?, ?, ?, ?, ?)'; //Pridėjimas
    $sql_seeAll = 'SELECT * FROM klientai';                         //Peržiūra
    $sql_delete = 'DELETE FROM klientai WHERE email = ?';           //Trinimas
    $sql_get_email = 'SELECT email FROM klientai';

    //Redagavimo šablonai
    $sql_edit_name = 'UPDATE klientai SET firstname = ? WHERE email = ?'; //Redaguoti vardą
    $sql_edit_lastname = 'UPDATE klientai SET lastname = ? WHERE email = ?'; //Redaguoti pavardę
    $sql_edit_email = 'UPDATE klientai SET email = ? WHERE email = ?'; //Redaguoti paštą
    $sql_edit_tel1 = 'UPDATE klientai SET phonenumber1 = ? WHERE email = ?'; //Redaguoti telefono numerį 1
    $sql_edit_tel2 = 'UPDATE klientai SET phonenumber2 = ? WHERE email = ?'; //Redaguoti telefono numerį 2
    $sql_edit_comment = 'UPDATE klientai SET comment = ? WHERE email = ?'; //Redaguoti komentarą

    //Sukuriamas prepeared sakinys
    $stmt_insert = mysqli_stmt_init($conn);
    $stmt_seeAll = mysqli_stmt_init($conn);
    $stmt_delete = mysqli_stmt_init($conn);
    $stmt_edit_name = mysqli_stmt_init($conn);
    $stmt_edit_lastname = mysqli_stmt_init($conn);
    $stmt_edit_email = mysqli_stmt_init($conn);
    $stmt_edit_tel1 = mysqli_stmt_init($conn);
    $stmt_edit_tel2 = mysqli_stmt_init($conn);
    $stmt_edit_comment = mysqli_stmt_init($conn);
    $stmt_get_email = mysqli_stmt_init($conn);

    //Tikrinama ar pavyko sukurti sakinius
    if(!mysqli_stmt_prepare($stmt_insert, $sql_insert)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_seeAll, $sql_seeAll)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_delete, $sql_delete)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_name, $sql_edit_name)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_lastname, $sql_edit_lastname)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_email, $sql_edit_email)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_tel1, $sql_edit_tel1)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_tel2, $sql_edit_tel2)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_edit_comment, $sql_edit_comment)){
        echo 'sql statement failed';
        exit();
    } else if(!mysqli_stmt_prepare($stmt_get_email, $sql_get_email)){
        echo 'sql statement failed';
        exit();
    }

    while(true) {
        menuMain();

        $handle = fopen ('php://stdin','r');
        $input = fgets($handle);

        switch ($input) {
            case 1:
                //Įvedamas klientas
                InsertClient($stmt_insert);
                break;
            case 2:
                SeeAll($stmt_seeAll);
                //Redaguojamas klientas
                EditClient($stmt_edit_name, $stmt_edit_lastname, $stmt_edit_email,
                           $stmt_edit_tel1 ,$stmt_edit_tel2, $stmt_edit_comment, $stmt_get_email);
                break;
            case 3:
                SeeAll($stmt_seeAll);
                //Trinamas klientas
                DeleteClient($stmt_delete, $stmt_get_email);
                break;
            case 4:
                //Matomi visi klientai
                SeeAll($stmt_seeAll);
                break;
            case 5:
                exit();
                break;
            default:
                echo 'Wrong input!';
                break;

        }
    }

function EditClient($stmt_edit_name, $stmt_edit_lastname, $stmt_edit_email,
                    $stmt_edit_tel1, $stmt_edit_tel2 ,$stmt_edit_comment, $stmt_get_email){//Funkcija skirta redaguoti klientą

    $exists = false;
    while($exists == false) {
        echo 'Enter email of which client you want to edit' . "\n";
        $email = readline();

        $exists = checkEmail($email, $stmt_get_email); //Tikrina ar yra toks pašto adresas
    }

    menuEdit();

    $handle = fopen ('php://stdin','r');
    $input = fgets($handle);

    switch ($input) {
        case 1:
            editName($email, $stmt_edit_name);
            break;
        case 2:
            editSurname($email, $stmt_edit_lastname);
            break;
        case 3:
            editEmail($email ,$stmt_edit_email);
            break;
        case 4:
            editTel1($email ,$stmt_edit_tel1);
            break;
        case 5:
            editTel2($email, $stmt_edit_tel2);
            exit();
            break;
        case 6:
            editComment($email, $stmt_edit_comment);
            break;
        default:
            echo 'Wrong input!';
            break;

    }

}
