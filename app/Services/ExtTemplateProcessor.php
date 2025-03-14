<?php

namespace App\Services;

use PhpOffice\PhpWord\TemplateProcessor;

class ExtTemplateProcessor extends TemplateProcessor
{
    private const OPEN_BODY_TAG = '<w:body>';
    private const CLOSE_BODY_TAG = '</w:body>';

    public function getBodyContent(): string
    {
        $bodyStart = mb_strpos($this->tempDocumentMainPart, self::OPEN_BODY_TAG) + mb_strlen(self::OPEN_BODY_TAG);
        $bodyEnd = mb_strpos($this->tempDocumentMainPart, self::CLOSE_BODY_TAG, $bodyStart);

        $bodyContent = mb_substr($this->tempDocumentMainPart, $bodyStart, $bodyEnd - $bodyStart);

        return $bodyContent;
    }

    public function mergeXmlBody(string $xmlBody): void
    {
        $this->tempDocumentMainPart = str_replace(
            self::CLOSE_BODY_TAG,
            $xmlBody . self::CLOSE_BODY_TAG,
            $this->tempDocumentMainPart
        );
    }
}
