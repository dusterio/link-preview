<?php

namespace LinkPreview\Parser;

use LinkPreview\Model\LinkInterface;

class GeneralParser implements ParserInterface
{
    /**
     * Url validation pattern taken from symfony UrlValidator
     */
    const PATTERN = '~^
            (http|https)://                                 # protocol
            (
                ([\pL\pN\pS-]+\.)+[\pL]+                   # a domain name
                    |                                     #  or
                \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}      # a IP address
                    |                                     #  or
                \[
                    (?:(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){6})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:::(?:(?:(?:[0-9a-f]{1,4})):){5})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){4})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,1}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){3})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,2}(?:(?:[0-9a-f]{1,4})))?::(?:(?:(?:[0-9a-f]{1,4})):){2})(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,3}(?:(?:[0-9a-f]{1,4})))?::(?:(?:[0-9a-f]{1,4})):)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,4}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:(?:(?:(?:[0-9a-f]{1,4})):(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9]))\.){3}(?:(?:25[0-5]|(?:[1-9]|1[0-9]|2[0-4])?[0-9])))))))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,5}(?:(?:[0-9a-f]{1,4})))?::)(?:(?:[0-9a-f]{1,4})))|(?:(?:(?:(?:(?:(?:[0-9a-f]{1,4})):){0,6}(?:(?:[0-9a-f]{1,4})))?::))))
                \]  # a IPv6 address
            )
            (:[0-9]+)?                              # a port (optional)
            (/?|/\S+)                               # a /, nothing or a / with something
        $~ixu';

    /**
     * @var LinkInterface $link
     */
    private $link;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return 'general';
    }

    /**
     * @inheritdoc
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @inheritdoc
     */
    public function isValidParser()
    {
        $isValid = false;

        $url = $this->getLink()->getUrl();

        if (is_string($url) && preg_match(static::PATTERN, $url)) {
            $isValid = true;
        }

        return $isValid;
    }

    /**
     * Get content from link
     *
     * @return array
     */
    protected function getLinkData()
    {
        $url = $this->getLink()->getUrl();

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => "LinkPreview",
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $data = array(
            'content' => $content,
            'content_type' => $header['content_type'],
            'url' => $header['url'],
        );

        return $data;
    }

    /**
     * Extract required data from link
     *
     * @return array
     */
    protected function parseLink()
    {
        $data = array(
            'url' => $this->getLink()->getUrl(),
            'image' => '',
            'title' => '',
            'description' => '',
        );

        $linkData = $this->getLinkData();

        if (!strncmp($linkData['content_type'], 'text/', strlen('text/'))) {
            $htmlData = $this->parseHtml($linkData['content']);

            $data = array(
                'url' => $linkData['url'],
                'image' => $htmlData['image'],
                'title' => $htmlData['title'],
                'description' => $htmlData['description'],
            );

        } elseif (!strncmp($linkData['content_type'], 'image/', strlen('image/'))) {
            $data = array(
                'url' => $linkData['url'],
                'image' => $linkData['url'],
            );
        }

        return $data;
    }

    /**
     * Extract required data from html source
     *
     * @param $html
     * @return array
     */
    protected function parseHtml($html)
    {
        $data = array(
            'image' => '',
            'title' => '',
            'description' => '',
        );

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($html);

        /** @var \DOMElement $meta */
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            if ($meta->getAttribute('itemprop') == 'image') {
                $data['image'] = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('property') == 'og:image') {
                $data['image'] = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('itemprop') == 'name') {
                $data['title'] = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('property') == 'og:title') {
                $data['title'] = $meta->getAttribute('content');
            }

            if ($meta->getAttribute('itemprop') == 'description') {
                $data['title'] = $meta->getAttribute('content');
            }
            if ($meta->getAttribute('property') == 'og:description') {
                $data['description'] = $meta->getAttribute('content');
            }
        }

        if (empty($data['title'])) {
            /** @var \DOMElement $title */
            foreach ($doc->getElementsByTagName('title') as $title) {
                $data['title'] = $title->nodeValue;
            }
        }

        if (empty($data['description'])) {
            foreach ($doc->getElementsByTagName('meta') as $meta) {
                if ($meta->getAttribute('name') == 'description') {
                    $data['description'] = $meta->getAttribute('content');
                }
            }
        }

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getParsedLink()
    {
        $data = $this->parseLink();

        $link = $this->getLink();
        $link->setRealUrl($data['url']);
        $link->setImage($data['image']);
        $link->setTitle($data['title']);
        $link->setDescription($data['description']);

        return $link;
    }
}