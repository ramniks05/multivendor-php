<?php
if (!isset($_GET['k']) || $_GET['k'] !== 'dc-check-2026') {
    header('HTTP/1.1 404 Not Found');
    exit;
}

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('BASEPATH', 'check');
define('ENVIRONMENT', 'production');
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR);

include APPPATH . 'config/database.php';

$d = isset($db['default']) ? $db['default'] : array();
$local = APPPATH . 'config/database.local.php';

echo 'php=' . PHP_VERSION . PHP_EOL;
echo 'host=' . (isset($d['hostname']) ? $d['hostname'] : '') . PHP_EOL;
echo 'user=' . (isset($d['username']) ? $d['username'] : '') . PHP_EOL;
echo 'database=' . (isset($d['database']) ? $d['database'] : '') . PHP_EOL;
echo 'password_loaded=' . (!empty($d['password']) ? 'yes (' . strlen($d['password']) . ' chars)' : 'NO') . PHP_EOL;
echo 'database.local.php=' . (is_file($local) ? 'yes' : 'NO') . PHP_EOL;

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(
    isset($d['hostname']) ? $d['hostname'] : 'localhost',
    isset($d['username']) ? $d['username'] : '',
    isset($d['password']) ? $d['password'] : '',
    isset($d['database']) ? $d['database'] : ''
);

if ($mysqli->connect_errno) {
    echo 'status=FAIL' . PHP_EOL;
    echo 'mysql_error=' . $mysqli->connect_error . PHP_EOL;
    exit;
}

echo 'status=OK' . PHP_EOL;
$r = $mysqli->query('SHOW TABLES');
echo 'tables=' . ($r ? (int) $r->num_rows : 0) . PHP_EOL;
if ($r && $r->num_rows > 0) {
    $need = array('general_settings', 'users', 'products');
    foreach ($need as $t) {
        $q = $mysqli->query('SHOW TABLES LIKE \'' . $mysqli->real_escape_string($t) . '\'');
        echo $t . '=' . ($q && $q->num_rows ? 'yes' : 'NO') . PHP_EOL;
    }
}
$mysqli->close();
