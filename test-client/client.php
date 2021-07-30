<?php
$handle = stream_socket_client('udp://127.0.0.1:8083', $errno, $errstr);
if (!$handle)
{
    exit("ERROR: {$errno} - {$errstr}\n");
}

fwrite($handle,json_encode([
    'action'    =>    'hello',
    'format'    =>    'Y-m-d H:i:s',
]));
var_dump(fread($handle, 4096));

fwrite($handle,json_encode([
    'action'    =>    'hello',
    'format'    =>    'c',
]));
var_dump(fread($handle, 4096));

fclose($handle);
