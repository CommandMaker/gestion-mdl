<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\CardScan;
use App\Repository\CardScanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class QueryCardScanController extends AbstractController
{
    public function __construct(
        private CardScanRepository $repo,
        private IriConverterInterface $iriConverter
    ) {}

    /**
     * @return CardScan[]
     */
    public function __invoke(Request $request): array
    {
        $data = $request->query;

        if ($data->getString('date') === '' || $data->getString('timePeriod') === '') {
            throw new UnprocessableEntityHttpException('Missing field');
        }

        return $this->repo->findBy(['date' => new \DateTimeImmutable($data->getString('date')), 'timePeriod' => $this->iriConverter->getResourceFromIri($data->getString('timePeriod'))]);
    }
}
