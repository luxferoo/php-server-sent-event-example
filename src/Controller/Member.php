<?php


namespace App\Controller;


use App\Repository\Member as MemberRepo;

class Member extends Controller
{
    public function members(){
        $repo = $this->getService('repository')->get(MemberRepo::class);
        return $this->json($repo->fetchAllButOne($this->getConnectedMember()->getUsername()));
    }

}