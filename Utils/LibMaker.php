<?php
const FUNCTION_TYPE  = 1;
const FUNCTION_ALIAS = 2;
const FUNCTION_LIB   = 3;
const FUNCTION_NAME  = 4;

const FUNCTION_ARGUMENTS = 1;
const FUNCTION_RESULT    = 2;

const NOT_SUPPORT = 'NO::SUPPORT';

$replaces          = array(
    '/^Integer$/i'   => 'l',
    '/^Longint$/i'   => 'l',
    '/^THandle$/i'   => 'h',
    '/^DWORD$/i'     => 'u',
    '/^UINT$/i'      => 'u',
    '/^LongWord$/i'  => 'u',
    '/^Cardinal$/i'  => 'u',
    '/^HKEY$/i'      => 'u',
    '/^HDC$/i'       => 'u',
    '/^HGDIOBJ$/i'   => 'u',
    '/^BOOL$/i'      => 't',
    '/^Word$/i'      => 't',
    '/^(T)?Atom$/i'  => 't',
    '/^SHORT$/i'     => 'n',
    '/^SmallInt$/i'  => 'n',
    '/^Char$/i'      => 'c',
    '/^AnsiChar$/i'  => 's',
    '/^WideChar$/i'  => 'w',
    '/^PChar$/i'     => 'C',
    '/^PAnsiChar$/i' => 'S',
    '/^PWideChar$/i' => 'W',
    '/^Pointer$/i'   => 'P',
    '/^PWord$/i'     => 'T',
    '/^PDWORD$/i'    => 'U',
);
$replacesTemplates = array_keys($replaces);
$replacesAliases   = array_values($replaces);
$replacesValues    = array_keys(array_flip($replacesAliases));

$functionScope    = array();
$interfaceMatches = array();
$constantsScope   = '<?php';
$matches          = array();

$windows         = file(__DIR__ . '/Windows.pas');
$inConstantBlock = false;
foreach ($windows as $line) {
    $inConstantBlock = preg_match('/const/', $line) ? true : $inConstantBlock;
    $inConstantBlock = preg_match('/^(function|procedure|type|implementation)/', $line) ? false : $inConstantBlock;
    if ($inConstantBlock && preg_match('/\s\s(\w+)\s\=\s(.+)\;/', $line, $matches)) {
        $constantsScope.= PHP_EOL . sprintf('const %s = %s;', $matches[1], preg_replace(array('/\$(\w+)/i'),array('0x${1}'),$matches[2]));
    }
}

file_put_contents(__DIR__ . '/../WinAPI/Constants.php', $constantsScope);
die;
//constants extract
preg_match_all('/const?(\w+\:\s\w+\;)/', $windows, $constantsMatches);
var_dump($constantsMatches[1]);
die();
//functions extract
preg_match_all('/(function|procedure)\s+(\w+)\;\s+external\s+(\w+)\s+name\s+\'(\w+)\'/', $windows, $interfaceMatches);
foreach ($interfaceMatches[FUNCTION_ALIAS] as $index => $alias) {
    $pattern = sprintf('/%s\s%s\((\w)\)\:?\s?(\w+)?;/', $interfaceMatches[FUNCTION_TYPE][$index], $alias);
    if (preg_match($pattern, $windows, $matches)) {
        $arguments = array();
        if (preg_match_all('/\w+\:\s(\w+)/', $matches[FUNCTION_ARGUMENTS], $arguments)) {
            $arguments = implode(preg_replace(array_keys($replaces), array_values($replaces), $arguments[1]));
        } else {
            $arguments = '';
        }
        $result = preg_replace(array_keys($replaces), array_values($replaces), $matches[FUNCTION_RESULT]);
        if ((strlen(str_replace($replacesValues, '', $arguments)) === 0) && (strlen(str_replace($replacesValues,
                                                                                                '',
                                                                                                $result)) === 0)
        ) {
            $functionScope[$alias] = array(
                'type'      => $interfaceMatches[FUNCTION_TYPE][$index],
                'library'   => $interfaceMatches[FUNCTION_LIB][$index] . '.dll',
                'name'      => $interfaceMatches[FUNCTION_NAME][$index],
                'arguments' => $arguments,
                'return'    => $result
            );
        } else {
            //var_dump($arguments, $matches[FUNCTION_RESULT]);
        }
    }
}

file_put_contents(__DIR__ . '/../WinAPI/Functions.php',
                  '<?php' . PHP_EOL . 'return ' . var_export($functionScope, true) . ';');

function debug()
{
    call_user_func_array('var_dump', func_get_args());
    die();
}