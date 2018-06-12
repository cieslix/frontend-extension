<?php

namespace Creativestyle\FrontendExtension\Helper;

class Product extends \Magento\Framework\App\Helper\AbstractHelper
{
    const SPECIAL_PRICE = 'special';

    const REGULAR_PRICE = 'regular';

    /**
     * @var \Magento\Review\Model\Review
     */
    private $review;

    /**
     * Rating resource option model
     *
     * @var \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection
     */
    protected $voteCollection;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Review\Model\Review $review,
        \Magento\Review\Model\ResourceModel\Rating\Option\Vote\Collection $voteCollection,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    )
    {
        parent::__construct($context);
        $this->review = $review;
        $this->voteCollection = $voteCollection;
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
    }

    public function getReviewSummary($product, $includeVotes = false)
    {
        $reviewData = false;

        if ($product) {
            $storeId = $this->storeManager->getStore()->getId();
            $ratingSummary = $product->getRatingSummary();

            if (!$ratingSummary) {
                $this->review->getEntitySummary($product, $storeId);
                $ratingSummary = $product->getRatingSummary();
            }

            if ($ratingSummary) {
                $activeStars = ($ratingSummary->getRatingSummary()) ? (round($ratingSummary->getRatingSummary() / 10) / 2) : 0;

                $reviewData = [
                    'data' => [
                        'maxStars' => 5,
                        'activeStars' => $activeStars,
                        'count' => (int)$ratingSummary->getReviewsCount(),
                        'votes' => array_fill(1, 5, 0)
                    ]
                ];

                if ($includeVotes and $reviewData['data']['count']) {
                    $votes = $this->voteCollection
                        ->setEntityPkFilter($product->getId())
                        ->setStoreFilter($storeId);

                    foreach ($votes->getItems() AS $vote) {
                        $reviewData['data']['votes'][$vote->getValue()]++;
                    }
                }
            }
        }

        return $reviewData;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param string|null $date
     * @return bool
     */
    public function isNew($product, $date = null)
    {
        $newsFromDate = $product->getNewsFromDate();
        $newsToDate = $product->getNewsToDate();
        $date = $date ?: date('Y-m-d');

        $fromTimestamp = strtotime($newsFromDate);
        $toTimestamp = strtotime($newsToDate);
        $dateTimestamp = strtotime($date);

        if(!$fromTimestamp && !$toTimestamp){
            return false;
        }

        if(!$fromTimestamp && $dateTimestamp <= $toTimestamp){
            return true;
        }

        if(!$toTimestamp && $dateTimestamp >= $fromTimestamp){
            return true;
        }

        if($dateTimestamp >= $fromTimestamp && $dateTimestamp <= $toTimestamp){
            return true;
        }

        return false;
    }

    public function isOnSale($product)
    {
        if($product->getTypeId() == 'simple'){
            return $this->checkIsProductOnSale($product);
        }

        if($product->getTypeId() == 'configurable'){
            $simpleProducts = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($simpleProducts as $simpleProduct) {
                $result = $this->checkIsProductOnSale($simpleProduct);

                if($result){
                    return true;
                }
            }
        }
        return false;
    }

    public function checkIsProductOnSale($product)
    {
        $specialprice = $product->getSpecialPrice();
        $specialPriceFromDate = $product->getSpecialFromDate();
        $specialPriceToDate = $product->getSpecialToDate();
        $todayTimestamp =  $this->dateTime->timestamp();

        if(!$specialprice){
            return false;
        }

        if($product->getPrice()<=$product->getFinalPrice()){
            return false;
        }

        if ($todayTimestamp >= strtotime($specialPriceFromDate) && is_null($specialPriceToDate)) {
            return true;
        }

        if (is_null($specialPriceFromDate) && $todayTimestamp <= strtotime($specialPriceToDate)) {
            return true;
        }

        if ($todayTimestamp >= strtotime($specialPriceFromDate) && $todayTimestamp <= strtotime($specialPriceToDate)) {
            return true;
        }

        return false;
    }

    public function getSalePercentage($product)
    {
        if(!$this->isOnSale($product)){
            return false;
        }

        $regularPrice = $product->getPrice();
        $salePrice = $product->getFinalPrice();

        if(!$regularPrice){
            return false;
        }

        $discountPercentage = (($regularPrice - $salePrice)/$regularPrice) * 100;

        $roundDiscount = round($discountPercentage, 0);

        if((int) $roundDiscount >= 5){
            return $roundDiscount;
        }

        return false;
    }

    public function getAddToCartUrl($productId)
    {
        $routeParams = [
            'product' => $productId,
            '_secure' => $this->_getRequest()->isSecure()
        ];

        return $this->_getUrl('checkout/cart/add', $routeParams);
    }

    public function getSaleOrigin($product)
    {
        if ($product->getSpecialPrice() && $this->isOnSale($product)) {
            return self::SPECIAL_PRICE;
        }

        return self::REGULAR_PRICE;
    }
}
