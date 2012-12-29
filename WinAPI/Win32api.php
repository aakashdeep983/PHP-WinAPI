<?php

namespace WinAPI;

use WinAPI\Patterns\SingletonTrait;

class Win32api
{
    use SingletonTrait;
    /**
     * @var \COM
     */
    protected $comObject;
    /**
     * @var array
     */
    protected $aliases = array();

    final protected function __construct()
    {
        $this->comObject = new \COM('DynamicWrapperX');
        foreach (include_once(__DIR__ . '/Libs.php') as $alias => $parameters) {
            $fileName = $parameters['library'];
            $this->register($fileName, $alias, $parameters['name'], $parameters['arguments'], $parameters['return']);
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
        if( isset($this->aliases[$method])){
            $method = $this->aliases[$method];
        }
        return call_user_func_array(array($this->comObject, $method), $arguments);
    }

    /**
     * @param string $dllFileName
     * @param string $alias
     * @param string $name
     * @param array  $arguments
     * @param array  $return
     *
     * @return mixed
     */
    public function register($dllFileName, $alias, $name, $arguments, $return)
    {
        $this->aliases[$alias] = $name;
        return call_user_func_array(
            array(
                 $this->comObject,
                 'Register'
            ),
            array(
                 $dllFileName,
                 $name,
                 'i=' . $arguments,
                 'r=' . $return
            )
        );
    }
}

