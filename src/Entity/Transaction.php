<?php

namespace App\Entity;

use Carbon\Carbon;

class Transaction {
    public function __construct(/*public int $id, */public int $userId, public float $amount, public string $date)
    {
        $this->setDate($date);
    }

    public function setDate(string $date): void
    {
        $this->date = Carbon::parse($date);
    }
}
