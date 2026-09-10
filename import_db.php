<?php
if (!isset($_GET['k']) || $_GET['k'] !== 'dc-import-2026') {
    header('HTTP/1.1 404 Not Found');
    exit;
}

header('Content-Type: text/plain; charset=utf-8');
set_time_limit(300);
ini_set('memory_limit', '256M');
error_reporting(E_ALL);
ini_set('display_errors', '1');

define('BASEPATH', 'check');
define('ENVIRONMENT', 'production');
define('APPPATH', __DIR__ . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR);

include APPPATH . 'config/database.php';

$d = isset($db['default']) ? $db['default'] : array();
$sql_file = __DIR__ . DIRECTORY_SEPARATOR . 'install' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'modesy_db.sql';

echo 'php=' . PHP_VERSION . PHP_EOL;
echo 'database=' . (isset($d['database']) ? $d['database'] : '') . PHP_EOL;
echo 'sql_file=' . (is_file($sql_file) ? 'yes (' . filesize($sql_file) . ' bytes)' : 'NO') . PHP_EOL;

if (!is_file($sql_file)) {
    echo 'status=FAIL missing SQL dump' . PHP_EOL;
    exit;
}

mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(
    isset($d['hostname']) ? $d['hostname'] : 'localhost',
    isset($d['username']) ? $d['username'] : '',
    isset($d['password']) ? $d['password'] : '',
    isset($d['database']) ? $d['database'] : ''
);

if ($mysqli->connect_errno) {
    echo 'status=FAIL connect: ' . $mysqli->connect_error . PHP_EOL;
    exit;
}

$mysqli->set_charset('utf8mb4');
$existing = $mysqli->query("SHOW TABLES LIKE 'general_settings'");
if ($existing && $existing->num_rows > 0) {
    $count = $mysqli->query('SELECT COUNT(*) AS c FROM general_settings');
    $row = $count ? $count->fetch_assoc() : array('c' => 0);
    if (!empty($row['c'])) {
        echo 'status=SKIP tables already exist' . PHP_EOL;
        echo 'general_settings=' . $row['c'] . PHP_EOL;
        $mysqli->close();
        exit;
    }
}

$sql = file_get_contents($sql_file);
if ($sql === false || $sql === '') {
    echo 'status=FAIL could not read SQL file' . PHP_EOL;
    exit;
}

if (!$mysqli->multi_query($sql)) {
    echo 'status=FAIL import: ' . $mysqli->error . PHP_EOL;
    $mysqli->close();
    exit;
}

do {
    if ($result = $mysqli->store_result()) {
        $result->free();
    }
} while ($mysqli->more_results() && $mysqli->next_result());

if ($mysqli->errno) {
    echo 'status=FAIL after import: ' . $mysqli->error . PHP_EOL;
    $mysqli->close();
    exit;
}

$tables = $mysqli->query('SHOW TABLES');
$gs = $mysqli->query("SHOW TABLES LIKE 'general_settings'");
echo 'status=OK' . PHP_EOL;
echo 'tables=' . ($tables ? (int) $tables->num_rows : 0) . PHP_EOL;
echo 'general_settings=' . ($gs && $gs->num_rows ? 'yes' : 'NO') . PHP_EOL;
$mysqli->close();
