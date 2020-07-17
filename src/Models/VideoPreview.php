<?php

namespace Dusterio\LinkPreview\Models;

use Dusterio\LinkPreview\Contracts\PreviewInterface;
use Dusterio\LinkPreview\Traits\HasExportableFields;
use Dusterio\LinkPreview\Traits\HasImportableFields;

/**
 * Class VideoLink.
 */
class VideoPreview implements PreviewInterface
{
    use HasExportableFields;
    use HasImportableFields;

    /**
     * @var string Video embed code
     */
    private $embed;

    /**
     * @var string Url to video
     */
    private $video;

    /**
     * @var string Video identification code
     */
    private $id;

    /**
     * @var array
     */
    private $fields = [
        'embed',
        'id',
    ];
}
