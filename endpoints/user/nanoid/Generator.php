<?php
namespace Hidehalo\Nanoid;

require_once "GeneratorInterface.php";

use Hidehalo\Nanoid\GeneratorInterface;

class Generator implements GeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function random($size)
    {
        return unpack('C*', \random_bytes($size));
    }
}