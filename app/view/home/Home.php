<?php
namespace app\view\home;

use core\mvc\view\HtmlPage;

class Home extends HtmlPage{

    public function __construct()
    {
        $this->htmlFile = 'app/view/home/home.phtml';
    }


}