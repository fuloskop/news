<?php

namespace App\Logger\Contact;

interface LoggerInterface
{
    public function error($message);

    public function debug($message);

    public function warning($message);

    public function critical($message);

    public function info($message); // user yorum yaptı , Haber create

    public function activity($message);  // user giriş yaptı vs
}
