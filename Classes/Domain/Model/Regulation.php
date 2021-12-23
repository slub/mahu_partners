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
 * Regulation
 */
class Regulation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * id
     *
     * @var string
     */
    protected $id = '';
    
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * region
     *
     * @var string
     */
    protected $region = '';

    /**
     * tags
     *
     * @var string
     */
    protected $tags = '';
    
    /**
     * imgUrl
     * 
     * @var string
     */
    protected $imgUrl = '';

    /**
     * uri
     * 
     * @var string
     */
    protected $uri = '';

    /**
     * matchingExpression
     * 
     * @var string
     */
    protected $matchingExpression = '';

    /**
     * facetValues
     * 
     * @var string
     */
    protected $facetValues = '';

    /**
     * Returns the id
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Sets the id
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
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
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the region
     *
     * @return string $region
     */
    public function getRegion()
    {
        return $this->region;
    }
    
    /**
     * Sets the region
     *
     * @param string $region
     * @return void
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }
    
    /**
     * Returns the tags
     *
     * @return string $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Sets the tags
     *
     * @param string $tags
     * @return void
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    
    /**
     * Returns the imageUrl
     * 
     * @return string $imageUrl
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * Sets the imageUrl
     * 
     * @param string $imageUrl
     * @return void
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * Returns the uri
     * 
     * @return string $uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the uri
     * 
     * @param string $uri
     * @return void
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * Returns the matchingExpression
     * 
     * @return string $matchingExpression
     */
    public function getMatchingExpression()
    {
        return $this->matchingExpression;
    }

    /**
     * Sets the matchingExpression
     * 
     * @param string $matchingExpression
     * @return void
     */
    public function setMatchingExpression($matchingExpression)
    {
        $this->matchingExpression = $matchingExpression;
    }

    /**
     * Returns the facetValues
     * 
     * @return string $facetValues
     */
    public function getFacetValues()
    {
        return $this->facetValues;
    }

    /**
     * Sets the facetValues
     * 
     * @param string $facetValues
     * @return void
     */
    public function setFacetValues($facetValues)
    {
        $this->facetValues = $facetValues;
    }
}
