<?php

class database
{

    public static $getdatabase = NULL;

    public static function getConnection()
    {

        if (database::$getdatabase == NULL) {

            $server = "89.117.188.103";
            $username = "u100003642_ease_sk";
            $userpass = "ease_M_track_1234";
            $db_name = "u100003642_ease_m_track";

            $conn = new mysqli($server, $username, $userpass, $db_name);

            if ($conn->connect_error == true) {
                return false;
            } else {
                database::$getdatabase = $conn;

                return database::$getdatabase;
            }
        } else {
            return database::$getdatabase;
        }
    }
}
