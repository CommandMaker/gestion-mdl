<?php

namespace App\Core\Http;

use GuzzleHttp\Psr7\Response;

trait ControllerTrait
{
    /**
     * Return the specified data in a JSON format
     *
     * @param  Response  $response  The response to write the data in
     * @param  array<string, mixed>  $data  The data to write
     * @param  int  $status  HTTP Status returned (default = 200)
     */
    protected function json(Response $response, mixed $data, int $status = 200): Response
    {

        $response->getBody()->write(json_encode($this->serializeObject($data)) ?: '');

        return $response->withStatus($status)->withHeader('Content-Type', 'application/json')->withHeader('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param  array<string, mixed>|object  $object
     * @return array<string, mixed>
     */
    private function serializeObject(array|object $object): array
    {
        if (gettype($object) === 'object') {
            if (method_exists($object, 'toArray')) {
                return $object->toArray();
            }

            return (array) $object;
        }

        if (gettype($object) === 'array') {
            $serialized = [];
            foreach ($object as $key => $value) {
                if (gettype($value) === 'array' || gettype($value) === 'object') {
                    $serialized[$key] = $this->serializeObject($value);

                    continue;
                }

                $serialized[$key] = $value;
            }

            return $serialized;
        }
    }
}
