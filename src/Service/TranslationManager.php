<?php

namespace Translation\PlatformAdapter\Doctrine\Service;

use Doctrine\ORM\EntityManagerInterface;
use Translation\Common\Model\MessageInterface;
use Translation\PlatformAdapter\Doctrine\Entity\Translation;

class TranslationManager implements TranslationManagerInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * TranslationManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     *
     * @return null|object
     */
    public function getTranslation($locale, $domain, $key)
    {
        return $this->findOneBy($locale, $domain, $key);
    }

    /**
     * @param MessageInterface $message
     */
    public function createTranslation(MessageInterface $message)
    {
        $translation = (new Translation())->setLocale($message->getLocale())
            ->setDomain($message->getDomain())
            ->setKey($message->getKey())
            ->setTranslation($message->getTranslation());

        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }

    /**
     * @param MessageInterface $message
     */
    public function updateTranslation(MessageInterface $message)
    {
        $translation = $this->findOneBy($message->getLocale(), $message->getDomain(), $message->getKey());

        if (!$translation) {
            return;
        }

        $translation->setTranslation($message->getTranslation());
        $this->entityManager->flush();
    }

    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     */
    public function deleteTranslation($locale, $domain, $key)
    {
        $translation = $this->findOneBy($locale, $domain, $key);

        if (!$translation) {
            return;
        }

        $this->entityManager->remove($translation);
        $this->entityManager->flush();
    }

    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     *
     * @return object|null
     */
    private function findOneBy($locale, $domain, $key)
    {
        return $this->entityManager->getRepository(Translation::class)
            ->findOneBy([
                'locale' => $locale,
                'domain' => $domain,
                'key' => $key,
            ]);
    }
}
