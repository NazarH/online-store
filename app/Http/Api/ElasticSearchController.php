<?php

namespace App\Http\Api;

use App\Http\Controllers\Controller;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class ElasticSearchController extends Controller
{
    public function search(Request $request)
    {
        $searchParams = [
            'index' => 'products',
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match_phrase' => [
                                    'name' => $request->input('name')
                                ]
                            ],
                            [
                                'range' => [
                                    'created_at' => [
                                        'gte' => $request->input('gte'),
                                        'lte' => $request->input('lte')
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->elasticResponse($searchParams);
    }

    public function filterByCategoryId(Request $request)
    {
        $searchParams = [
            'index' => 'products',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            [
                                'terms' => [
                                    'category_id' => $request->input('category_ids')
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->elasticResponse($searchParams);
    }

    public function filterByPriceRange(Request $request)
    {
        $searchParams = [
            'index' => 'products',
            'body' => [
                'query' => [
                    'bool' => [
                        'filter' => [
                            'range' => [
                                'price' => [
                                    'gte' => $request->input('from'),
                                    'lte' => $request->input('to')
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->elasticResponse($searchParams);
    }

    public function sortingByField(Request $request)
    {
        $searchParams = [
            'index' => 'products',
            'body' => [
                'sort' => [
                    [
                        $request->input('field').'.keyword' => $request->input('method')
                    ]
                ]
            ]
        ];

        return $this->elasticResponse($searchParams);
    }

    private function elasticResponse($searchParams)
    {
        $client = ClientBuilder::create()->setHosts(['elasticsearch:9200'])->build();

        $response = $client->search($searchParams);

        $products = $response['hits']['hits'];

        return response()->json($products);
    }

}
