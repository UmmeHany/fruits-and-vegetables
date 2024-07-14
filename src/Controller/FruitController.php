<?php

namespace App\Controller;

use App\Service\fruit\delete\FruitRemovalService;
use App\Service\fruit\FruitUnitConversionService;
use App\Service\fruit\insert\FruitInsertionService;
use App\Service\fruit\list\FruitDisplayService;
use App\Service\fruit\search\FruitSearchService;
use App\Service\jsonOperation\JsonParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/fruit")]
class FruitController extends AbstractController
{

    #[Route('/list', methods: ['GET'])]
    public function display(Request $request, FruitDisplayService $fruitDisplayService, FruitUnitConversionService $fruitUnitConversionService)
    {

        $unit = $request->query->get('unit');

        if ($unit) {
            $data = $fruitUnitConversionService->getConvertedData($unit);
        } else {
            $data = $fruitDisplayService->list();
        }

        return $this->json([
            'message' => 'Fruit List',
            'data' => $data,
        ]);

    }

    #[Route('/search/{id}', methods: ['GET'])]
    public function search(int $id, FruitSearchService $fruitSearch)
    {
    
        $item = $fruitSearch->search($id);

        return $this->json([
            'message' => 'Fruit search is operated',
            'response' => $item ? $item->getName() . ' is found' : 'not found',
        ]);
    }

    #[Route('/add', methods: ['POST'])]
    public function insert(Request $request, FruitInsertionService $fruitInsertionService, JsonParser $jsonParser)
    {

        $payLoad = $request->getContent();

        $foodItems = $jsonParser->parse($payLoad);

        $response = $fruitInsertionService->addItems($foodItems);

        return $this->json([
            'message' => 'Fruit insertion is being operated',
            'data' => $response,
        ]);
    }

    #[Route('/delete/{id}', methods: ['DELETE'])]
    public function delete(int $id, FruitRemovalService $fruitRemovalService)
    {

        $isDeleted = $fruitRemovalService->delete($id);

        return $this->json([
            'message' => 'Fruit removal is operated',
            'response' => $isDeleted ? 'successfully Deleted' : 'failed',
        ]);
    }

}
