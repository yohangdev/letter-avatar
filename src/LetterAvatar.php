<?php

namespace YoHang88\LetterAvatar;

use function foo\func;
use Intervention\Image\ImageManager;

class LetterAvatar
{
    /**
     * @var string
     */
    protected $name;


    /**
     * @var string
     */
    protected $name_initials;


    /**
     * @var string
     */
    protected $shape;


    /**
     * @var int
     */
    protected $size;

    /**
     * @var ImageManager
     */
    protected $image_manager;


    public function __construct(string $name, string $shape = 'circle', int $size = 48)
    {
        $this->setName($name);
        $this->setImageManager(new ImageManager());
        $this->setShape($shape);
        $this->setSize($size);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager(): ImageManager
    {
        return $this->image_manager;
    }

    /**
     * @param ImageManager $image_manager
     */
    public function setImageManager(ImageManager $image_manager): void
    {
        $this->image_manager = $image_manager;
    }

    /**
     * @return string
     */
    public function getShape(): String
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     */
    public function setShape(string $shape): void
    {
        $this->shape = $shape;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }


    /**
     * @return \Intervention\Image\Image
     */
    public function generate(): \Intervention\Image\Image
    {
        $this->name_initials = $this->getInitials($this->name);

        $color = $this->stringToColor($this->name);

        if ($this->shape == 'circle') {
            $canvas = $this->image_manager->canvas(480, 480);

            $canvas->circle(480, 240, 240, function ($draw) use ($color) {
                $draw->background($color);
            });

        } else {

            $canvas = $this->image_manager->canvas(480, 480, $color);
        }

        $canvas->text($this->name_initials, 240, 240, function ($font) {
            $font->file(__DIR__ . '/fonts/arial-bold.ttf');
            $font->size(220);
            $font->color('#ffffff');
            $font->valign('middle');
            $font->align('center');
        });

        return $canvas->resize($this->size, $this->size);
    }

    private function getInitials(string $name): string
    {
        $nameParts = $this->break_name($name);
        $secondLetter = $nameParts[1] ? $this->getFirstLetter($nameParts[1]) : '';

        return $this->getFirstLetter($nameParts[0]) . $secondLetter;

    }

    private function getFirstLetter(string $word): string
    {
        return mb_strtoupper(trim(mb_substr($word, 0, 1, 'UTF-8')));
    }

    public function saveAs($path, $mimetype = 'image/png', $quality = 90): bool
    {
        if (empty($path) || empty($mimetype) || $mimetype != "image/png" && $mimetype != 'image/jpeg') {
            return false;
        }

        return \is_int(@file_put_contents($path, $this->generate()->encode($mimetype, $quality)));
    }

    public function __toString(): string
    {
        return (string)$this->generate()->encode('data-url');
    }

    /**
     * Explodes Name into an array.
     * The function will check if a part is , or blank
     *
     * @param string $name Name to be broken up
     * @return array Name broken up to an array
     */
    private function break_name(string $name): array
    {
        $words = \explode(' ', $name);
        $words = array_filter($words, function($word) {
            return $word!=='' && $word !== ',';
        });
        return array_values($words);
    }

    protected function stringToColor(string $string): string
    {
        // random color
        $rgb = substr(dechex(crc32($string)), 0, 6);
        // make it darker
        $darker = 2;
        [$R16, $G16, $B16] = str_split($rgb, 2);
        $R = sprintf('%02X', floor(hexdec($R16) / $darker));
        $G = sprintf('%02X', floor(hexdec($G16) / $darker));
        $B = sprintf('%02X', floor(hexdec($B16) / $darker));
        return '#' . $R . $G . $B;
    }

}
