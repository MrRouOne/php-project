<?php

namespace App\egal;

use App\Models\Post;
use Illuminate\Http\Request;


class EgalRequest extends Request
{

    public function getModelInstanse(): EgalModel
    {
        // парсинг запроса
        return new Post();
    }
}