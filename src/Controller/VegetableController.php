<?php

namespace App\Controller;

use App\Service\jsonOperation\JsonParser;
use App\Service\vegetable\delete\VegetableRemovalService;
use App\Service\vegetable\insert\VegetableInsertionService;
use App\Service\vegetable\list\VegetableDisplayService;
use App\Service\vegetable\search\VegetableSearchService;
use App\Service\vegetable\VegetableUnitConversionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/vegetable")]
class VegetableController extends AbstractController
{

    #[Route('/list', methods: ['GET'])]
    public function display(Request $request, VegetableDisplayService $vegetableDisplayService, VegetableUnitConversionService $vegetableUnitConversionService)
    {

        $unit = $request->query->get('unit');

        if ($unit) {
            $data = $vegetableUnitConversionService->getConvertedData($unit);
        } else {

            $data = $vegetableDisplayService->list();
        }

        return $this->json([
            'message' => 'Vegetable List',
            'data' => $data,
        ]);

    }

    #[Route('/search/{id}', methods: ['GET'])]
    public function search(int $id, VegetableSearchService $vegetableSearch)
    {

        $item = $vegetableSearch->search($id);

        return $this->json([
            'message' => 'Vegetable search is operated',
            'response' => $item ? $item->getName() . ' is found' : 'not found',
        ]);
    }

    #[Route('/add', methods: ['POST'])]
    public function insert(Request $request, VegetableInsertionService $vegetableInsertionService, JsonParser $jsonParser)
    {

        $payLoad = $request->getContent();

        $foodItems = $jsonParser->parse($payLoad);

        $response = $vegetableInsertionService->addItems($foodItems);

        return $this->json([
            'message' => 'Vegetable insertion is being operated',
            'data' => $response,
        ]);
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function delete(int $id, VegetableRemovalService $vegetableRemovalService)
    {

        $isDeleted = $vegetableRemovalService->delete($id);

        return $this->json([
            'message' => 'Vegetable removal is operated',
            'response' => $isDeleted ? 'successfully Deleted' : 'failed',
        ]);
    }

}
