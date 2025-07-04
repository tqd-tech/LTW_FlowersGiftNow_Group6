<?php
require_once './db.php';

if ($pdo) {
    echo "Kết nối thành công!";
} else {
    echo "Kết nối thất bại!";
}
?>
