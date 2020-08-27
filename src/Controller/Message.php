<?php


namespace App\Controller;


use App\Repository\Message as MessageRepo;
use App\Model\Message as MessageModel;

class Message extends Controller
{
    public function messages($id)
    {
        $connectedMember = $this->getConnectedMember();
        if (!$connectedMember) {
            //TODO fix proxies logic and add security firewall as a proxy
            header('HTTP/1.1 401 Unauthorized', true, 401);
            die;
        }

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $repo = $this->getService('repository')->get(MessageRepo::class);
        $messages = json_encode($repo->fetchAllByIds($connectedMember->getId(), $id));
        return "data: {$messages}\n\n";
    }

    public function sendMessage($id)
    {
        $connectedMember = $this->getConnectedMember();
        if (!$connectedMember) {
            //TODO fix proxies logic and add security firewall as a proxy
            header('HTTP/1.1 401 Unauthorized', true, 401);
            die;
        }

        $message = filter_var(trim($this->getRequest()->get('message')), FILTER_SANITIZE_STRING);

        if (!$message) {
            header('HTTP/1.1 422 Empty message', true, 422);
            die;
        }

        $repo = $this->getService('repository')->get(MessageRepo::class);

        $instance = new MessageModel();

        $instance
            ->setMessage($message)
            ->setFromMember($this->getConnectedMember()->getId())
            ->setToMember($id);
        try {
            $repo->insert($instance);
            header('HTTP/1.1 201 Created', true, 201);
            return '';
        } catch (Exception $exception) {
            header('HTTP/1.1 500 Server error', true, 500);
            die;
        }
    }
}