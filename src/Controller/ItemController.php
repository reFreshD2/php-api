<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @Route("/")
 */
class ItemController extends AbstractController
{
    /**
     * @Route("/api/{userId}/add", name="add", methods={"POST"})
     */
    public function add(Request $request)
    {
        if (!$request->request->has('name')) {
            $result = array('message' => 'smth goes wrong');
            return new JsonResponse($result);
        } else {
            $name = $request->request->get('name');
            $entityManager = $this->getDoctrine()->getManager();
            $newItem = new Item();
            $newItem->setName($name);
            $newItem->setUserId($request->attributes->get('userId'));
            $entityManager->persist($newItem);
            $entityManager->flush();
            $result = array('userId' => $newItem->getUserId(), 'name' => $newItem->getName());
            return new JsonResponse($result);
        }
    }

    /**
     * @Route("/api/{userId}/show", name="show", methods={"GET"})
     */
    public function show(Request $request, ItemRepository $itemRepository)
    {
        $result = array();
        $items = $itemRepository->findBy(array('userId' => $request->attributes->get('userId')));
        foreach ($items as $item) {
            $result[] = ['userId' => $item->getUserId(), 'name' => $item->getName()];
        }
        return new JsonResponse($result);
    }
}
