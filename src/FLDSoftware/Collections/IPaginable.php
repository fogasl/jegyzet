<?php

namespace FLDSoftware\Collections;

interface IPaginable {

    public function getCurrentPage();

    public function previousPage();

    public function nextPage();

}
