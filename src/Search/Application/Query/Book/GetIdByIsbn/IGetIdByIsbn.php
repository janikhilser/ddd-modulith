<?php

declare(strict_types=1);

namespace App\Search\Application\Query\Book\GetIdByIsbn;

use App\Search\Domain\Book\ValueObject\BookId;
use App\Search\Domain\Book\ValueObject\Isbn;

interface IGetIdByIsbn
{
    public function getIdByIsbn(Isbn $isbn): BookId;
}
