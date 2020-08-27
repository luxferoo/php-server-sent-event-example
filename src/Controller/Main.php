<?php


namespace App\Controller;


class Main extends Controller
{
    public function index()
    {
        return $this->getService('view')->render('home', ["connected_member" => $this->getConnectedMember()]);
    }
}