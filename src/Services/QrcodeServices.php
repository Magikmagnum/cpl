<?php

namespace App\Services;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class QrcodeServices
{

    protected const URL = ''; //https:/www.google.com/search?q=
    protected const SIZE = 332;
    protected const MARGIN = 10;

    /**
     * Le type d'encodege
     *
     * @var Encoding
     */
    protected $encoding;

    /**
     * Undocumented variable
     *
     * @var BuilderInterface
     */
    protected $customQrCodeBuilder;

    /**
     * Undocumented variable
     *
     * @var ErrorCorrectionLevelHigh
     */
    protected $error;


    public function __construct(BuilderInterface $customQrCodeBuilder)
    {
        $this->customQrCodeBuilder = $customQrCodeBuilder;
        $this->encoding = new Encoding('UTF-8');
        $this->error = new ErrorCorrectionLevelHigh();
    }


    public function qrcode($query, $labelText = null)
    {
        if ($labelText == null) {
            $objDateTime = new \DateTime("NOW");
            $labelText = $objDateTime->format('Y-m-d H:i:s');
        }

        $result = $this->customQrCodeBuilder
            ->data(SELF::URL . $query)
            ->encoding($this->encoding)
            ->errorCorrectionLevel($this->error)
            ->size(SELF::SIZE)
            ->margin(SELF::MARGIN)
            //->labelText($labelText)
            ->build();


        $namePng = uniqid('', '') . '.png';
        $result->saveToFile(\dirname(__DIR__, 2) . "/public/assets/qrcode/" . $namePng);

        return $result->getDataUri();
    }
}
