<?php

namespace App\Interfaces;

interface FilesRepositoryInterface
{
    public function store(array $data);

    public function update(int $id, array $data);
}
