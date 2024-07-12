<?php

declare(strict_types=1);

class Response
{
    public function Response($num, $message)
    {
        return [
            'status' => $num,
            'message' => $message
        ];
    }
    public function R200message($message)
    {
        return [
            'status' => 200,
            'message' => $message,
        ];
    }
    public function R200($posts)
    {
        return [
            'status' => 200,
            'message' => 'OK',
            'data' => $posts
        ];
    }
    public function R201message($message)
    {
        return [
            'status' => 201,
            'message' => $message,
        ];
    }
}