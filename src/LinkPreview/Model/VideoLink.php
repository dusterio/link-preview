<?php

namespace LinkPreview\Model;

/**
 * Class VideoLink
 */
class VideoLink extends Link
{
    /**
     * @var string $embedCode Video embed code
     */
    private $embedCode;
    /**
     * @var string $video Url to video
     */
    private $video;
    /**
     * @var string $videoId Video identification code
     */
    private $videoId;

    /**
     * @return string
     */
    public function getEmbedCode()
    {
        return $this->embedCode;
    }

    /**
     * @param string $embedCode
     * @return $this
     */
    public function setEmbedCode($embedCode)
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param string $video
     * @return $this
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }
}