<?php

namespace Translation\PlatformAdapter\Doctrine;

use Psr\Http\Message\ResponseInterface;
use Translation\Common\Model\Message;
use Translation\Common\Model\MessageInterface;
use Translation\Common\Storage;
use Translation\PlatformAdapter\Doctrine\Service\TranslationManager;

/**
 * @author Yenkong Lybliamay <yenkong@lybliamay.fr>
 */
class Doctrine implements Storage
{
    /** @var TranslationManager */
    private $manager;

    /**
     * Doctrine constructor.
     *
     * @param TranslationManager $manager
     */
    public function __construct(TranslationManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function get($locale, $domain, $key)
    {
        $translation = $this->manager->getTranslation($locale, $domain, $key);

        if (!$translation) {
            return null;
        }

        return new Message($key, $domain, $locale, $translation);
    }

    /**
     * @inheritDoc
     */
    public function create(MessageInterface $message)
    {
        $this->manager->createTranslation($message);
    }

    /**
     * @inheritDoc
     */
    public function update(MessageInterface $message)
    {
        $this->manager->updateTranslation($message);
    }

    /**
     * @inheritDoc
     */
    public function delete($locale, $domain, $key)
    {
        $this->manager->deleteTranslation($locale, $domain, $key);
    }
}