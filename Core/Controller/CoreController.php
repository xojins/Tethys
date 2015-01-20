<?php
/**
* Tethys - a PHP 5.4 DI framework
*
* @author David Amatulli <xojins at gmail dot com>
* @copyright 2014 David Amatulli
* @link https://github.com/xojins
* @version 1.0
*
* MIT LICENSE
*
* Permission is hereby granted, free of charge, to any person obtaining
* a copy of this software and associated documentation files (the
* "Software"), to deal in the Software without restriction, including
* without limitation the rights to use, copy, modify, merge, publish,
* distribute, sublicense, and/or sell copies of the Software, and to
* permit persons to whom the Software is furnished to do so, subject to
* the following conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
* MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
* LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
* OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
* WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

namespace Core\Controller;

class CoreController
{
    protected $c;
    protected $model;
    protected $view;

    protected function __construct($controller,$action,$container)
    {

        $this->c = $container;

        $this->c->settings->model  = '\\App\\Application\\Models\\'.ucwords($controller);
        $this->c->settings->view   = '\\App\\Application\\Views\\'.ucwords($controller);
        $this->c->settings->header_template = '_header.html';
        $this->c->settings->footer_template = '_footer.html';
        $this->c->settings->action_template = $action.'.html';
        $this->c->settings->action = $action;

        return true;
    }

    protected function createModel()
    {
        if(!is_object($this->model))
            $this->model = new $this->c->settings->model($this->c);

        call_user_func_array(array($this->model,$this->c->settings->action),array());

        return true;
    }

    protected function createView()
    {
        if(!is_object($this->view))
            $this->view = new $this->c->settings->view($this->c);

        call_user_func_array(array($this->view,$this->c->settings->action),array());

        return true;
    }

    protected function createUser()
    {
        if(!is_object($this->c))
            return false;

    }

    protected function outputHtml()
    {
        echo $this->c->output->header;
        echo $this->c->output->body;
        echo $this->c->output->footer;

        return true;
    }

    protected function outputJson($value)
    {
        echo json_encode($value);
        return true;
    }

}

