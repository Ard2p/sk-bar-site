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
        /* $xml = '
            <?xml version="1.0" encoding="utf-8"?>
            <RK7Query>
                <RK7CMD CMD="GetRefData" RefName="MODIFIERS" OnlyActive="1" WithMacroProp="1" PropMask="items.(*)">
                 <RK7CMD CMD="GetRefData" RefName="CATEGLIST" OnlyActive="true" WithChildItems="1000" PropMask="items.(*)">
                  <RK7CMD CMD="GetRefList">
                    <Station code="1"/>
                    PropMask="RIChildItems.TClassificatorGroup.RIChildItems.TRK7MenuItem.(*)"
                    PropMask="items.(IDENT, CODE, NAME, PRICETYPES^4)"
                      RIChildItems.TClassificatorGroup.(*),
                RIChildItems.TClassificatorGroup.RIChildItems.(*),
                TClassificatorGroup
                RIChildItems
                TRK7MenuItem
IDENT, CODE, NAME, STATUS, PRICETYPES^3
                        TRK7MenuItem.(IDENT, CODE, NAME, Instruct, PRICETYPES^3),
                </RK7CMD>
            </RK7Query>';*/
        /* $xml = '
            <?xml version="1.0" encoding="utf-8"?>
            <RK7Query>
                <RK7CMD CMD="GetRefData" RefName="GETORDERMENU" OnlyActive="1"/>
            </RK7Query>';*/

        // GETORDERMENU

        // items.(IDENT, CODE, NAME, PRICETYPES^4)

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


        // return $this->parseRKData(Storage::get('xml/menu.xml'));

        $response = $this->client->send('POST', '{+url}', ['body' => $xml]);
        // Storage::put('xml/menu.xml', (string)$response);
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
