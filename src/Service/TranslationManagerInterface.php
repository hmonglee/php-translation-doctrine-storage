<?php

namespace Translation\PlatformAdapter\Doctrine\Service;

use Translation\Common\Model\MessageInterface;

interface TranslationManagerInterface
{
    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     *
     * @return null|object
     */
    public function getTranslation($locale, $domain, $key);

    /**
     * @param MessageInterface $message
     */
    public function createTranslation(MessageInterface $message);

    /**
     * @param MessageInterface $message
     */
    public function updateTranslation(MessageInterface $message);

    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     */
    public function deleteTranslation($locale, $domain, $key);
}
