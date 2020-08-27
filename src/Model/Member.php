<?php


namespace App\Model;


class Member extends Model implements \JsonSerializable
{
    private $username;
    private $password;
    static $table = "member";

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;

    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "username" => $this->getUsername()
        ];
    }

    public static function fromArray(Array $array): Model
    {
        $member = new Member();
        $member
            ->setId($array['id'])
            ->setUsername($array['username'])
            ->setPassword(isset($array['password']) ? $array['password'] : '');
        return $member;
    }
}