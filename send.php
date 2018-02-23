<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$channel_check = $_POST['channel'];

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('192.168.1.2', 5672, 'admin', 'password');
$channel = $connection->channel();
$channel->queue_declare($channel_check, false, false, false, false);
$msg = new AMQPMessage($username . ':' . $password);
$channel->basic_publish($msg, '', $channel_check);
echo " [x] Sent 'Hello World!'\n";
$channel->close();
$connection->close();
?>
