<?php

namespace Dusterio\LinkPreview\Models;

use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Traits\HasExportableFields;
use Dusterio\LinkPreview\Traits\HasImportableFields;

/**
 * Class VideoLink
 */
class VideoPreview implements PreviewInterface
{
    use HasExportableFields;
    use HasImportableFields;

    /**
     * @var string $embed Video embed code
     */
    private $embed;

    /**
     * @var string $video Url to video
     */
    private $video;

    /**
     * @var string $id Video identification code
     */
    private $id;

    /**
     * @var array
     */
    private $fields = [
        'embed',
        'id'
    ];
}