<?php
/** destruye variables de sesion activas **/
session_unset();
setcookie(session_name(),0,1, ini_get("session.cookie_path"));
session_destroy();
header('Location: ../../index.php');
exit();
?>