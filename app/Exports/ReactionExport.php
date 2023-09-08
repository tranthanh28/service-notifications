<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class ReactionExport implements FromArray
{
    protected $postIds;

    public function __construct(array $postIds)
    {
        $this->postIds = $postIds;
    }

    public function array(): array
    {
        return $this->postIds;
    }
}
