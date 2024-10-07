<?php

namespace App\Core\Card;

use App\Entity\User;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use DantSu\PHPImageEditor\Image;
use Symfony\Component\Filesystem\Path;

class CardGenerator
{
    public function __construct(
        private string $projectDir
    ) {}

    /**
     * Generate the user card as a base64 image
     */
    public function generateCard(User $user): string
    {
        $image = Image::fromData(file_get_contents(Path::makeAbsolute('var/storage/card_template_an.png', $this->projectDir)) ?: '');

        $options = new QROptions([
            'outputType' => QROutputInterface::GDIMAGE_PNG,
        ]);

        /** @var string */
        $color = 'bd9e57';
        /** @var string */
        $qrCode = (new QRCode($options))->render($user->getCode());
        $a = str_replace('data:image/png;base64,', '', $qrCode);
        $qrCodeSize = 600;

        $image
            ->writeText(mb_strtoupper($user->getLastname() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/name.ttf', $this->projectDir), fontSize: 70, color: $color, posX: $image->getWidth() / 2 + 5, posY: 477)
            ->writeText(mb_strtoupper($user->getFirstname() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/name.ttf', $this->projectDir), fontSize: 70, color: $color, posX: $image->getWidth() / 2 + 5, posY: 577)
            ->writeText(mb_strtoupper($user->getGrade() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/class.otf', $this->projectDir), fontSize: 70, color: $color, posX: $image->getWidth() / 2 + 5, posY: 689, letterSpacing: 3)
            ->pasteOn(
                Image::fromBase64($a)->resizeProportion($qrCodeSize, $qrCodeSize),
                posX: $image->getWidth() / 2 - $qrCodeSize / 2,
                posY: $image->getHeight() / 2 - $qrCodeSize / 2
            );

        return $image->getBase64JPG();
    }
}
