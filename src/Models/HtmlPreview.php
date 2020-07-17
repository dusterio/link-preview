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
     * @var string Link description
     */
    private $description;

    /**
     * @var string Cover image (usually chosen by webmaster)
     */
    private $cover;

    /**
     * @var array Images found while parsing the link
     */
    private $images = [];

    /**
     * @var string Link title
     */
    private $title;

    /**
     * @var string Video for the page (chosen by the webmaster)
     */
    private $video;

    /**
     * @var string If there is  video, what type it is
     */
    private $videoType;

    /**
     * Fields exposed.
     *
     * @var array
     */
    private $fields = [
        'cover',
        'images',
        'title',
        'description',
        'video',
        'videoType',
    ];
}
