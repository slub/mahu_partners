<?php
/*******************************************************************************
 * Copyright notice
 *
 * Copyright 2013 Sven-S. Porst, Göttingen State and University Library
 *                <porst@sub.uni-goettingen.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 ******************************************************************************/

namespace Slub\MahuPartners\ViewHelpers;



/**
 * View Helper to return the number of the page the result at position resultNumber
 * appears on with resultsPerPage items per page, i.e. returns
 * resultNumber mod resultsPerPage.
 */
class PageNumberForResultNumberViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {


    /**
     * Registers own arguments.
     */
    public function initializeArguments() {
        parent::initializeArguments();
        $this->registerArgument('resultNumber', 'int', 'Number of the rsult to determine the page number for', TRUE);
        $this->registerArgument('resultsPerPage', 'int', 'Number of results per page', TRUE);
        $this->registerArgument('defaultResultsPerPage', 'int', 'default Number of results per page', TRUE);
    }


    /**
     * @return string
     */
    public function render() {
        $this->arguments['resultsPerPage'] = $this->arguments['resultsPerPage'] ? $this->arguments['resultsPerPage'] : $this->arguments['defaultResultsPerPage']; // prevent division by zero
        return ceil($this->arguments['resultNumber'] / $this->arguments['resultsPerPage']);
    }

}

?>