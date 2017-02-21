<?php

namespace Synch\Image;

class Agent {

    static public function upload() {
        Upload::start();
        return '\Synch\Image\Agent::upload();';
    }

}
