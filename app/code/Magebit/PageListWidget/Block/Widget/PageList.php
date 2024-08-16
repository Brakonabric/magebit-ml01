<?php
/**
 * @package Magebit_PageListWidget
 */

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Model\ResourceModel\Page\Collection;
use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class CmsPages
 *
 * Widget to display CMS pages based on configuration.
 */
class PageList extends Template implements BlockInterface
{
    /**
     * Path to the template file.
     *
     * @var string
     */
    protected $_template = "page-list.phtml";

    const string DISPLAY_MODE_ALL_PAGES = 'all_pages';
    const string DISPLAY_MODE_SPECIFIC_PAGES = 'specific_pages';

    /**
     * CMS Page Collection Factory
     *
     * @var CollectionFactory
     */
    protected CollectionFactory $pageCollectionFactory;

    /**
     * CmsPages constructor.
     *
     * @param Template\Context $context
     * @param CollectionFactory $pageCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $pageCollectionFactory,
        array $data = []
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve widget title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData('title');
    }

    /**
     * Retrieve CMS pages based on widget configuration
     *
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getCmsPages(): Collection
    {
        $displayMode = $this->getData('display_mode');
//        dd($this);
        $collection = $this->pageCollectionFactory->create()->addStoreFilter($this->_storeManager->getStore()->getId());

        if ($displayMode == self::DISPLAY_MODE_SPECIFIC_PAGES) {
            $selectedPages = $this->getData('selected_pages');
            if ($selectedPages) {
                $pageIds = explode(',', $selectedPages);
                $collection->addFieldToFilter('page_id', ['in' => $pageIds]);
            } else {
                $collection->addFieldToFilter('page_id', ['in' => []]); // No pages selected
            }
        }

        return $collection;
    }
}
