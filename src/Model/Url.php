<?php


namespace Christiana\SitemapBundle\Model;


use App\Attribute\IgnoreService;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[IgnoreService]
class Url implements \Stringable
{
    /**
     * @var string
     * @SerializedName("loc")
     */
    private string $location;

    /**
     * @var string
     * @SerializedName("priority")
     */
    private ?string $priority = null; //Default : 0.5

    /**
     * @var ?string
     * @SerializedName("changeFreq")
     */
    private ?string $changeFrequency = null;

    /**
     * @var ?\DateTimeInterface
     * @SerializedName("lastmod")
     */
    private ?\DateTimeInterface $lastModified = null;

    const NEVER = 'never';
    const HOURLY = 'hourly';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const ALWAYS = 'always';

    public function __construct(string $location, ?\DateTimeInterface $lastModified = null, ?string $priority = '0.5', ?string $changeFrequency = null)
    {
        $this->location = $location;
        $this->lastModified = $lastModified;
        $this->priority = $priority;
        $this->changeFrequency = $changeFrequency;
    }

    public function __toString()
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return Url
     */
    public function setLocation(string $location): Url
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getPriority(): string
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return Url
     */
    public function setPriority(string $priority): Url
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @return ?string
     */
    public function getChangeFrequency(): ?string
    {
        return $this->changeFrequency;
    }

    /**
     * @param ?string $changeFrequency
     * @return Url
     */
    public function setChangeFrequencey(?string $changeFrequency): Url
    {
        $this->changeFrequency = $changeFrequency;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastModified(): ?\DateTimeInterface
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTimeInterface|null $lastModified
     * @return Url
     */
    public function setLastModified(?\DateTimeInterface $lastModified): Url
    {
        $this->lastModified = $lastModified;
        return $this;
    }

}
