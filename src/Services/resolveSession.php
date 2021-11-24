<?php
namespace App\Services;
use Symfony\Component\HttpFoundation\Session\Session;


class resolveSession
{
    private $session;
    public function __construct()
    {
        $this->session = new Session();
    }

    public function exist_elem($key)
    {
        if ($key && count($key) > 0)
        {
            foreach($key as $k => $v)
            {
                $result = $this->session->get($v);
                if ($result) {

                } else {
                    return null;
                }
            }
            return true;
        }
        else return null;
    }

    public function get($key)
    {
        return $this->session->get($key);
    }

    public function set($key, $val)
    {
        $this->session->set($key, $val);
    }
}