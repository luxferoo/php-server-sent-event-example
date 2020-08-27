<?php


namespace App\Controller;


use App\Repository\Member;
use App\Service\View;

class Security extends Controller
{
    /**
     * @var View
     */
    private $view;

    public function __construct()
    {
        parent::__construct();
        $this->view = $this->getService("view");
    }

    public function login(): String
    {
        switch ($this->getRequest()->getMethod()) {
            case 'GET':
                return $this->view->render("login");
            case 'POST':
                return $this->handleLogin();
        }
    }

    private function handleLogin()
    {
        $username = trim($this->getRequest()->get('username')) ?? '';
        $password = trim($this->getRequest()->get('password')) ?? '';

        if (!$username || !$password) {
            return $this->view->render("login", ["message" => "wrong credentials"]);
        }

        $repo = $this->getService('repository')->get(Member::class);

        /** @var \App\Model\Member $member */
        $member = $repo->fetchByUsername($username);

        if (!$member || !password_verify($password, $member->getPassword())) {
            return $this->view->render("login", ["message" => "wrong credentials"]);
        } else {
            $this->setConnectedMember($member);
            return $this->redirect("home");
        }
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect("login");
    }
}