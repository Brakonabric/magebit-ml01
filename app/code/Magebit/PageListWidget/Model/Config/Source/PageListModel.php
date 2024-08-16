<?php
/**
 * @package Magebit_PageListWidget
 */
namespace Magebit\PageListWidget\Model\Config\Source;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
/**
 * Class PageListModel
 *
 * Source model for CMS pages selection in widget configuration.
 */
class PageListModel implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $pageCollectionFactory;

    /**
     * CmsPages constructor.
     *
     * @param CollectionFactory $pageCollectionFactory
     */
    public function __construct(CollectionFactory $pageCollectionFactory)
    {
        $this->pageCollectionFactory = $pageCollectionFactory;
    }

    public function toOptionArray(): array
    {
        $collection = $this->pageCollectionFactory->create();
        $pages = [];

        foreach ($collection as $page) {
            $pages[] = [
                'value' => $page->getId(),
                'label' => $page->getTitle(),
            ];
        }

        return $pages;
    }
}
