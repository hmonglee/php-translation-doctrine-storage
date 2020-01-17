<?php

declare(strict_types=1);

namespace Translation\PlatformAdapter\Doctrine\Service;

use Doctrine\Common\Persistence\ObjectRepository;
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
     * @return array
     */
    public function findAllDomains()
    {
        return $this->getRepository()->findAllDomains();
    }

    /**
     * @param string $locale
     * @param string $domain
     *
     * @return array
     */
    public function findAllMessages($locale, $domain)
    {
        $messages = $this->getRepository()->findBy(['locale' => $locale, 'domain' => $domain]);
        $result = [];

        foreach ($messages as $message) {
            $result[$message->getKey()] = $message->getTranslation();
        }

        return $result;
    }

    /**
     * @param string $locale
     * @param string $domain
     * @param string $key
     *
     * @return object|null
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
        $translation = $this->findOneBy($message->getLocale(), $message->getDomain(), $message->getKey());

        if ($translation) {
            $this->updateTranslation($message);

            return;
        }

        $translation = (new Translation())->setLocale($message->getLocale())
            ->setDomain($message->getDomain())
            ->setKey($message->getKey())
            ->setTranslation($message->getTranslation())
            ->setMeta($message->getAllMeta())
            ->setStatus($message->getKey() === $message->getTranslation() ? Translation::STATUS_DRAFT : Translation::STATUS_PUBLISHED);

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
            $this->createTranslation($message);

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
        return $this->getRepository()->findOneBy([
            'locale' => $locale,
            'domain' => $domain,
            'key' => $key,
        ]);
    }

    /**
     * @return ObjectRepository
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository(Translation::class);
    }
}
