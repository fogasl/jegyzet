<?php

namespace FLDSoftware\Jegyzet\Models;

use FLDSoftware\WebApp\Models\ModelBase;

class UserModel extends ModelBase {

    protected $id;

    protected $username;

    protected $password;

    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return sprintf("User: <%s>", $this->username);
    }

    public function rules() {
        return array(
            "id" => ""
        );
    }

}
