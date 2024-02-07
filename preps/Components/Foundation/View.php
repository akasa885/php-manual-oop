<?php

namespace Preps\Components\Foundation;

class View
{
    protected $view;
    protected $data = [];

    public function __construct($view, $data = [])
    {
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        extract($this->data);
        require $this->view;
    }
}