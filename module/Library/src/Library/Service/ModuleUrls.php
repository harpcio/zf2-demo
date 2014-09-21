<?php

namespace Library\Service;

use Zend\Mvc\Controller\Plugin\Url;

class ModuleUrls
{
    /**
     * @var Url
     */
    private $urlPlugin;

    public function __construct(Url $urlPlugin)
    {
        $this->urlPlugin = $urlPlugin;
    }

    /**
     * @return string
     */
    public function getIndexUrl()
    {
        return $this->urlPlugin->fromRoute('library/book');
    }

    /**
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->urlPlugin->fromRoute('library/book/create');
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getReadUrl($id)
    {
        $params = [
            'id' => $id
        ];

        return $this->urlPlugin->fromRoute('library/book/read', $params);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getUpdateUrl($id)
    {
        $params = [
            'id' => $id
        ];

        return $this->urlPlugin->fromRoute('library/book/update', $params);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function getDeleteUrl($id)
    {
        $params = [
            'id' => $id
        ];

        return $this->urlPlugin->fromRoute('library/book/delete', $params);
    }
}