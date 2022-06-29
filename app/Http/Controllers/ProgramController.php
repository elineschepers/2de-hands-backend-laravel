<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Resources\Program\ProgramResource;

class ProgramController
{
    public function index()
    {
        return ProgramResource::collection(Program::all());
    }
}
