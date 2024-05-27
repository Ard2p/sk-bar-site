<?php

namespace App\Services;

use SimpleXMLElement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class RKService
{
    protected $client;

    public function __construct()
    {
        $config = (object)config('services.rk');

        $url = "https://{$config->host}:{$config->port}/rk7api/v0/xmlinterface.xml";

        $this->client = Http::withUrlParameters(['url' => $url])
            ->withHeaders(['Content-Type' => 'text/xml;charset=utf-8'])
            ->withBasicAuth($config->user, $config->pass)
            ->withOptions(['verify' => false]);
    }

    public function getCatalog()
    {
        $xml = '
            <?xml version="1.0" encoding="windows-1251"?>
            <RK7Query >
                <RK7CMD
                    CMD="GetRefData"
                    RefName="CLASSIFICATORGROUPS"
                    RefItemIdent="2816"
                    WithChildItems="3"
                    WithMacroProp="1"
                    OnlyActive="1"
                    PropMask="IDENT, CODE, NAME, RIChildItems.(IDENT, CODE, NAME, RIChildItems.(IDENT, CODE, NAME, Instruct, PRICETYPES^3))">
                </RK7CMD>
            </RK7Query>';

        $response = $this->client->send('POST', '{+url}', ['body' => $xml]);
        return $this->parseRKData($response->body());
    }

    public function parseRKData($xml)
    {
        $xml = new SimpleXMLElement($xml);
        $xmlCategories = $xml->RK7Reference->Items->Item->RIChildItems->TClassificatorGroup;

        $menu = [];
        foreach ($xmlCategories as $xmlCategory) {
            $products = [];

            if ($xmlCategory->RIChildItems)
                foreach ($xmlCategory?->RIChildItems?->TRK7MenuItem as $xmlProduct)
                    $products[] = (object)[
                        'ident' => (int)$xmlProduct['Ident'],
                        'code' => (int)$xmlProduct['Code'],
                        'name' => (string)$xmlProduct['Name'],
                        'price' => (int)$xmlProduct['PRICETYPES-3'],
                        'instruct' => (string)$xmlProduct['Instruct'],
                        'parent_ident' => (int)$xmlCategory['Ident']
                    ];

            $menu[] = (object)[
                'ident' => (int)$xmlCategory['Ident'],
                'code' => (int)$xmlCategory['Code'],
                'name' => (string)$xmlCategory['Name'],
                'products' => $products
            ];
        }

        return $menu;
    }
}
