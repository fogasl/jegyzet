<?php

namespace FLDSoftware\Jegyzet\Models;

use FLDSoftware\WebApp\Models\ModelBase;
use FLDSoftware\Jegyzet\Entities\User;

class UserModel extends ModelBase {

    // FIXME to base class
    protected User $_entity;

    // Model should contain primary key (id) field

    public function __construct() {
        parent::__construct();
    }

    public function __toString() {
        return sprintf("User: <%s>", $this->username);
    }

    public function __get(string $name): mixed {
        throw new \Exception("Not Implemented");
    }

    public function __set(string $property, mixed $value): void {
        throw new \Exception("Not Implemented");
    }

    public function rules() {
        return array(
            "id" => ""
        );
    }

}
