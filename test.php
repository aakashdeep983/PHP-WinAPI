<?php
$com = new COM("DynamicWrapperX");
$com->Register("KERNEL32.DLL", "Beep", "i=ll", "f=s", "r=l");
$com->Beep(5000, 1000);
?>