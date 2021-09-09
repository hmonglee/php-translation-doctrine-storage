<?php

declare(strict_types=1);

namespace Translation\PlatformAdapter\Doctrine;

use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageCatalogueInterface;
use Translation\Common\Model\Message;
use Translation\Common\Model\MessageInterface;
use Translation\Common\Storage;
use Translation\Common\TransferableStorage;
use Translation\PlatformAdapter\Doctrine\Service\TranslationManager;

/**
 * @author Yenkong Lybliamay <yenkong@lybliamay.fr>
 */
class Doctrine implements Storage, TransferableStorage
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
     * {@inheritdoc}
     */
    public function get(string $locale, string $domain, string $key): MessageInterface
    {
        $translation = $this->manager->getTranslation($locale, $domain, $key);

        if (!$translation) {
            return null;
        }

        return new Message($key, $domain, $locale, $translation);
    }

    /**
     * {@inheritdoc}
     */
    public function create(MessageInterface $message): void
    {
        $this->manager->createTranslation($message);
    }

    /**
     * {@inheritdoc}
     */
    public function update(MessageInterface $message): void
    {
        $this->manager->updateTranslation($message);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($locale, $domain, $key): void
    {
        $this->manager->deleteTranslation($locale, $domain, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function export(MessageCatalogueInterface $catalogue, array $options = []): void
    {
        $locale = $catalogue->getLocale();

        foreach ($this->manager->findAllDomains() as $domain) {
            $arrayLoader = new ArrayLoader();
            $newCatalogue = $arrayLoader->load($this->manager->findAllMessages($locale, $domain), $locale, $domain['domain']);
            $catalogue->addCatalogue($newCatalogue);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function import(MessageCatalogueInterface $catalogue, array $options = []): void
    {
        $locale = $catalogue->getLocale();

        foreach ($catalogue->getDomains() as $domain) {
            foreach ($catalogue->all($domain) as $key => $translation) {
                $message = new Message($key, $domain, $locale, $translation);
                $this->create($message);
            }
            $this->manager->flush();
        }
    }
}
