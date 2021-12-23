<?php
namespace Slub\MahuPartners\Domain\Model;

/***
 *
 * This file is part of the "MaHu Frontend" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Carsten Radeck <carsten.radeck@slub-dresden.de>, SLUB Dresden
 *
 ***/

/**
 * SocialNetworkAccount
 */
class SocialNetworkAccount extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * url
     * 
     * @var string
     */
    protected $url = '';

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the url
     * 
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     * 
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
