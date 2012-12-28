<?php

class Win32api
{
    /**
     * @var COM
     */
    protected $comObject;

    public function __construct()
    {
        spl_autoload_register(function ($className) {
            include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . str_replace('\\',
                                                                                                  DIRECTORY_SEPARATOR,
                                                                                                  $className) . '.php';
        });

        $this->comObject = new COM('DynamicWrapperX');

        foreach (glob(__DIR__ . DIRECTORY_SEPARATOR . 'Libs/*') as $fileName) {
            foreach (include_once($fileName) as $function => $arguments) {
                $this->register(basename(str_replace('.php', '', $fileName)), $function, $arguments);
            }
        }
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->comObject, $method), $arguments);
    }

    /**
     * @param string $dllFileName
     * @param string $functionName
     * @param array  $usedTypes
     *
     * @return mixed
     */
    public function register($dllFileName, $functionName, array $usedTypes = array())
    {
        $returnType = array_pop($usedTypes);
        return call_user_func_array(array(
                                        $this->comObject,
                                        'Register'
                                    ),
                                    array(
                                        $dllFileName,
                                        $functionName,
                                        'i=' . implode('', $usedTypes),
                                        'r=' . $returnType
                                    ));
    }
}

