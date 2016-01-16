--TEST--
ssh2_sftp - SFTP tests, fopen wrappers
--SKIPIF--
<?php
  require('ssh2_skip.inc');
  ssh2t_needs_auth();
  ssh2t_remote_writes();
--FILE--
<?php require('ssh2_test.inc');

$ssh = ssh2_connect(TEST_SSH2_HOSTNAME, TEST_SSH2_PORT);
ssh2t_auth($ssh);
$sftp = ssh2_sftp($ssh);

$filename = ssh2t_tempnam();
$sshpath = "ssh2.sftp://$sftp/$filename";

$fp = fopen($sshpath, 'w');
fwrite($fp, "Hello World");
fclose($fp);

var_dump(is_array(stat($sshpath)));
var_dump(is_dir($sshpath));
var_dump(is_file($sshpath));
var_dump(is_link($sshpath));

var_dump(ssh2_sftp_unlink($sftp, $filename));
--EXPECT--
bool(true)
bool(false)
bool(true)
bool(false)
bool(true)
