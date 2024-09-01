<?php

namespace App\Core\Card;

use App\Entity\User;
use Symfony\Component\Filesystem\Path;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use \DantSu\PHPImageEditor\Image;
use chillerlan\QRCode\QROptions;

class CardGenerator
{

    public function __construct(
        private string $projectDir
    )
    {
    }

    /**
     * Generate the user card as a base64 image
     *
     * @param User $user
     * @return string
     */
    public function generateCard(User $user): string
    {
        $image = Image::fromData(file_get_contents(Path::makeAbsolute('var/storage/card_template.jpg', $this->projectDir)) ?: '');

        $options = new QROptions([
            'outputType' => QROutputInterface::GDIMAGE_PNG
        ]);

        /** @var string */
        $qrCode = (new QRCode($options))->render($user->getCode());
        $a = str_replace('data:image/png;base64,', '', $qrCode);
        $qrCodeSize = 500;

        $image
            ->writeText(strtoupper($user->getLastname() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/name.ttf', $this->projectDir), fontSize: 50, color: '00a4fd', posX: $image->getWidth() / 2 + 5, posY: 400)
            ->writeText(strtoupper($user->getFirstname() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/name.ttf', $this->projectDir), fontSize: 50, color: '00a4fd', posX: $image->getWidth() / 2 + 5, posY: 480)
            ->writeText(strtoupper($user->getGrade() ?: ''), fontPath: Path::makeAbsolute('var/storage/fonts/class.otf', $this->projectDir), fontSize: 50, color: '00a4fd', posX: $image->getWidth() / 2 + 5, posY: 570, letterSpacing: 3)
            ->pasteOn(
                Image::fromBase64($a)->resizeProportion($qrCodeSize, $qrCodeSize),
                posX: $image->getWidth() / 2 - $qrCodeSize / 2,
                posY: $image->getHeight() / 2 - $qrCodeSize / 2
            );

        return $image->getBase64JPG();
    }
}
