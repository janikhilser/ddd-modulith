<?php

declare(strict_types=1);

namespace App\Loan\Application\Query\Book\GetBookById;

interface IGetBookById
{
    /**
     * @throws BookNotFoundException
     */
    public function getBookById(string $id): BookDto;
}
