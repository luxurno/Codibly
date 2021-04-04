<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Core\Request\Filter\FilterParamsTrait;
use App\Product\Application\Create\CreateProductCommand;
use App\Product\Application\Read\ReadAllProductQuery;
use App\Product\Application\Read\ReadProductQuery;
use App\Product\Application\Update\UpdateProductCommand;
use App\Product\Domain\Exception\NotFoundProductException;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api", name: '_api')]
class ProductController extends AbstractController
{
    use FilterParamsTrait;

    public function __construct(
        private MessageBusInterface $commandBus,
        private MessageBusInterface $queryBus
    ) { }

    #[Route("/product", methods: ["POST"])]
    public function createProduct(Request $request): Response
    {
        $name = $request->get('name', null);
        $price = $request->get('price', null);

        try {
            $this->commandBus->dispatch(
                new CreateProductCommand(
                    new ProductName($name),
                    new ProductPrice((int) $price)
                )
            );
            return new Response('', Response::HTTP_CREATED);
        } catch (HandlerFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route("/product/{id}", methods: ["GET"])]
    public function getProduct(int $id, Request $request): Response
    {
        try {
            $product = $this->queryBus->dispatch(
                new ReadProductQuery($id)
            );
            /** @var HandledStamp $handledStamp */
            $handledStamp = $product->last(HandledStamp::class);

            $result = $handledStamp->getResult();
            if (null === $result) {
                throw NotFoundProductException::createMessage($id);
            }

            $response = json_encode(
                $handledStamp->getResult(),
                JSON_THROW_ON_ERROR
            );
            return new Response($response, Response::HTTP_OK);
        } catch (NotFoundProductException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (HandlerFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\JsonException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route("/product/{id}", methods: ["PUT"])]
    public function saveProduct(int $id, Request $request): Response
    {
        $name = $request->get('name', null);
        $price = $request->get('price', null);

        try {
            $this->commandBus->dispatch(
                new UpdateProductCommand(
                    new ProductId($id),
                    new ProductName($name),
                    new ProductPrice((int)$price)
                )
            );
            return new Response('', Response::HTTP_ACCEPTED);
        } catch (HandlerFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }

    #[Route("/products", methods: ["GET"])]
    public function listProducts(Request $request): Response
    {
        $params = [
            'name' => $request->get('name', null),
            'price' => $request->get('price', null),
        ];

        try {
            $products = $this->queryBus->dispatch(
                new ReadAllProductQuery(
                    $this->filterRequestParams($params)
                )
            );
            /** @var HandledStamp $handledStamp */
            $handledStamp = $products->last(HandledStamp::class);

            $response = json_encode(
                $handledStamp->getResult(),
                JSON_THROW_ON_ERROR
            );
            return new Response($response, Response::HTTP_OK);
        } catch (HandlerFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\JsonException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
