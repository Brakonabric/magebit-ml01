<?php

namespace Magebit\CustomCatalog\ViewModel;

use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

readonly class AvailabilityHelper implements ArgumentInterface
{
    public function __construct(
        private StockStateInterface $stockState
    ){
    }

    public function getStockQty(int $productId): int
    {
        return $this->stockState->getStockQty($productId);
    }
}
