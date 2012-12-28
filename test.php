<?php
require_once 'WinAPI/Win32api.php';
$win32api = new Win32api();
$win32api->beep(1000, 500);