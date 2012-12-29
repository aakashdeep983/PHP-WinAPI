<?php
return array(
    'OpenProcess'        =>
    array(
        'type'      => 'function',
        'library'   => 'kernel32.dll',
        'name'      => 'OpenProcess',
        'arguments' => 'utu',
        'return'    => 'h',
    ),
    'ReadProcessMemory'  =>
    array(
        'type'      => 'function',
        'library'   => 'kernel32.dll',
        'name'      => 'ReadProcessMemory',
        'arguments' => 'hPPuu',
        'return'    => 't',
    ),
    'WriteProcessMemory' =>
    array(
        'type'      => 'function',
        'library'   => 'kernel32.dll',
        'name'      => 'WriteProcessMemory',
        'arguments' => 'hPPuu',
        'return'    => 't',
    ),
    'Beep' => array(
        'type'      => 'function',
        'library'   => 'kernel32.dll',
        'name'      => 'Beep',
        'arguments' => 'uu',
        'return'    => 't',
    ),

    'CloseHandle'        =>
    array(
        'type'      => 'function',
        'library'   => 'kernel32.dll',
        'name'      => 'CloseHandle',
        'arguments' => 'h',
        'return'    => 't',
    ),
);