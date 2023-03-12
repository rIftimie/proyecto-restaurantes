<?php
namespace App\Service;

use App\Service\ApiFormatter;
use App\Entity\Orders;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MercureGenerator
{
    public function __construct(ApiFormatter $formatter,HubInterface $hub)
    {
        $this->formatter= $formatter;
        $this->hub= $hub;
    }

    // Publish order update.
    public function publish(Orders $order): Response
    {
        // Mercure: Publicar actualizacion
        $update = new Update(
            'http://localhost:8000/api/orders/'.$order->getId(),
            json_encode($this->formatter->orderToArray($order))
        );

        $this->hub->publish($update);
        
        return new Response(Response::HTTP_OK);
    }
}