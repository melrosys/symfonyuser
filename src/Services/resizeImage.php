<?php
namespace App\Services;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;

class resizeImage
{
    private const MAX_WIDTH = 350;
    private const MAX_HEIGHT = 350;
    private const CADRE_SIZE = 200;

    private $imagine;

    public function __construct()
    {
    $this->imagine = new Imagine();
    }

    public function resize(string $filename): void
    {
        list($iwidth, $iheight) = getimagesize($filename);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
            if($width < self::CADRE_SIZE)
            {
                $width = $iwidth;
                $height = $iheight;
            }
        } else {
            $height = $width / $ratio;
            if ($height < self::CADRE_SIZE) {
                $width = $iwidth;
                $height = $iheight;
            }
        }

        $posi = $this->position($width, $height);

        $photo = $this->imagine->open($filename);
        $photo->resize(new Box($width, $height))
            ->crop(new Point($posi[0], $posi[1]), new Box(self::CADRE_SIZE, self::CADRE_SIZE))
            ->save($filename);
    }

    public function position(int $width, int $height): array
    {
        $posi = Array(0, 0);
        if($width > self::CADRE_SIZE)
        {
            $xx = $width - self::CADRE_SIZE;
            $xx = $xx / 2;
            $posi[0] = $xx;
        }

        if ($height > self::CADRE_SIZE) {
            $yy = $height - self::CADRE_SIZE;
            $yy = $yy / 2;
            $posi[1] = $yy;
        }
        return $posi;
    }
}