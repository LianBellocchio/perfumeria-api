<?php
class Request {
    public $body = null;
    public $params = null;
    public $query = null;

    public function __construct() {
        $this->body = json_decode(file_get_contents('php://input'));
        $this->query = (object) $_GET;
    }
}
?>
