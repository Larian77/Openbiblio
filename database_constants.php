<?php
/*********************************************************************************
 *
 *                           A C H T U N G !
 *
 *  ||  Bitte verändern Sie die folgenden Datenbankkonstanten zu der        ||
 *  \/  MySQL Datenbank und dem MySQL-Benutzer, den Sie erstellt haben.     \/
 *********************************************************************************
 */
define("OBIB_HOST",     getenv('DB_HOST')     ?: "localhost");
define("OBIB_DATABASE", getenv('DB_NAME')     ?: "openbiblio");
define("OBIB_USERNAME", getenv('DB_USER')     ?: "db_user");
define("OBIB_PWD",      getenv('DB_PASSWORD') ?: "db_passw");
define("MAIN_LOCALE",   getenv('DB_LOCALE')   ?: "de"); // de oder en
/*********************************************************************************
 *  /\                                                                      /\
 *  ||                                                                      ||
 *********************************************************************************
 */
?>
