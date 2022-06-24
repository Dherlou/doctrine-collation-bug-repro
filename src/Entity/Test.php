<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Test
{
    public function __construct(
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private int $id,
        /**
         * @ORM\Column(type="string", nullable=false, length=255, options={"collation"="utf8mb4_unicode_ci"})
         * to see the difference, add '"charset"="utf8mb4"' to the column options above
         **/
        private string $name
    ) {
    }
}
