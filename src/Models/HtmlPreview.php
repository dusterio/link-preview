<?php

namespace Dusterio\LinkPreview\Models;

use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Traits\HasExportableFields;
use Dusterio\LinkPreview\Traits\HasImportableFields;

class HtmlPreview implements PreviewInterface
{
    use HasExportableFields;
    use HasImportableFields;

    /**
     * @var string $description Link description
     */
    private $description;

    /**
     * @var string $cover Cover image (usually chosen by webmaster)
     */
    private $cover;

    /**
     * @var array Images found while parsing the link
     */
    private $images = [];

    /**
     * @var string $title Link title
     */
    private $title;

    /**
     * Fields exposed
     * @var array
     */
    private $fields = [
        'cover',
        'images',
        'title',
        'description'
    ];
}