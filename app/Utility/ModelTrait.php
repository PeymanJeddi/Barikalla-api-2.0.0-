<?php

namespace App\Utility;

use Carbon\Carbon;

trait ModelTrait {
    public function getUpdatedAtAttribute() {
        return jdate($this->getRawOriginal('updated_at'))->format('Y-m-d H:i');
    }

    public function getCreatedAtAttribute() {
        return jdate($this->getRawOriginal('created_at'))->format('Y-m-d H:i');
    }

    public function getCreatedAttribute() {
        return jdate($this->getRawOriginal('created_at'))->format('Y-m-d');
    }

    public function getUpdatedAttribute() {
        return jdate($this->getRawOriginal('updated_at'))->format('Y-m-d');
    }

}
