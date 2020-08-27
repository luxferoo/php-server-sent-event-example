<?php


namespace App\Model;


class Message extends Model implements \JsonSerializable
{
    static $table = "message";
    private $fromMember;
    private $toMember;
    private $message;
    private $createdAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @return int
     */
    public function getFromMember(): int
    {
        return $this->fromMember;
    }

    /**
     * @param int $fromMember
     * @return Message
     */
    public function setFromMember(int $fromMember): Message
    {
        $this->fromMember = $fromMember;
        return $this;
    }

    /**
     * @return int
     */
    public function getToMember(): int
    {
        return $this->toMember;
    }

    /**
     * @param mixed $toMember
     * @return Message
     */
    public function setToMember(int $toMember): Message
    {
        $this->toMember = $toMember;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage(): String
    {
        return $this->message;
    }

    /**
     * @param String $message
     * @return Message
     */
    public function setMessage(String $message): Message
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Message
     */
    public function setCreatedAt(\DateTime $createdAt): Message
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    public static function fromArray(array $array): Model
    {
        return (new Message())
            ->setId($array['id'])
            ->setFromMember($array['fromMember'])
            ->setToMember($array['toMember'])
            ->setMessage($array['message'])
            ->setCreatedAt(new \DateTime(isset($array['createdAt']) ? $array['createdAt'] : null));
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
            "fromMember" => $this->getFromMember(),
            "toMember" => $this->getToMember(),
            "message" => $this->getMessage(),
            "createdAt" => $this->getCreatedAt()->format('Y:m:d H:i:s'),
        ];
    }
}