<?php
// ============================================================
// LOGOUT - Hapus semua cookie
// ============================================================
setcookie('user_login', '', time() - 3600, '/');
setcookie('user_id',    '', time() - 3600, '/');
setcookie('user_nama',  '', time() - 3600, '/');
setcookie('user_role',  '', time() - 3600, '/');

header("Location: login.php");
exit;
?>