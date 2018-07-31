<?php
declare(strict_types=1);

namespace Planet\Domain\Exception;

interface DomainException
{
    public function message();
}
