<?php

declare(strict_types=1);

namespace Translation\PlatformAdapter\Doctrine\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Translation\Common\Model\MessageInterface;

/**
 * Class Translation.
 *
 * @ORM\Entity(repositoryClass="Translation\PlatformAdapter\Doctrine\Repository\TranslationRepository")
 * @ORM\Table(name="translation", uniqueConstraints={@ORM\UniqueConstraint(name="translation_idx", columns={"key", "domain", "locale"})})
 * @ORM\HasLifecycleCallbacks()
 */
class Translation implements MessageInterface
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @var string
     */
    protected $key;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @var string
     */
    protected $domain;

    /**
     * @ORM\Column(type="string", length=5, nullable=false)
     *
     * @var string
     */
    protected $locale;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    protected $translation;

    /**
     * @ORM\Column(type="json")
     *
     * @var array
     */
    protected $meta = [];

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @var DateTime
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime|null
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $status;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->status = self::STATUS_DRAFT;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdateAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function updateStatus()
    {
        $this->status = $this->key === $this->translation ? self::STATUS_DRAFT : self::STATUS_PUBLISHED;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return Translation
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     *
     * @return Translation
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     *
     * @return Translation
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->translation ?? '';
    }

    /**
     * @param string $translation
     *
     * @return Translation
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Translation
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return Translation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Translation
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param string $domain
     *
     * @return static
     */
    public function withDomain($domain): MessageInterface
    {
        $new = clone $this;
        $new->domain = $domain;

        return $new;
    }

    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param string $locale
     *
     * @return static
     */
    public function withLocale($locale): MessageInterface
    {
        $new = clone $this;
        $new->locale = $locale;

        return $new;
    }

    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param string $translation
     *
     * @return static
     */
    public function withTranslation($translation): MessageInterface
    {
        $new = clone $this;
        $new->translation = $translation;

        return $new;
    }

    /**
     * @return array
     */
    public function getAllMeta(): array
    {
        return $this->meta;
    }

    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param array $meta
     *
     * @return static
     */
    public function withMeta(array $meta): MessageInterface
    {
        $new = clone $this;
        $new->meta = $meta;

        return $new;
    }

    /**
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * changed request target.
     *
     * @param string $key
     * @param string $value
     *
     * @return static
     */
    public function withAddedMeta($key, $value): MessageInterface
    {
        $new = clone $this;
        $new->meta[$key] = $value;

        return $new;
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getMeta($key, $default = null)
    {
        if (array_key_exists($key, $this->meta)) {
            return $this->meta[$key];
        }

        return $default;
    }

    /**
     * @param $meta
     *
     * @return $this
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }
}
