<?php

namespace Nadeem0035\General\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ObjectManager;
use Magento\Catalog\Helper\Category;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;

class Quote extends Template
{

    /**
     * @var Registry
     */
    protected $registry;
    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $categoryHelper;
    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    protected $categoryRepository;
    protected $productRepository;
    /**
     * @var Product
     */
    private $product;
    protected $authSession;

    public function __construct(Template\Context $context,
                                Registry $registry,
                                Category $categoryHelper,
                                CategoryRepository $categoryRepository,
                                ProductRepositoryInterface $productRepository,
                                Session $authSession,
                                array $data)
    {
        $this->registry = $registry;
        $this->categoryHelper = $categoryHelper;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->authSession = $authSession;
        parent::__construct($context, $data);
    }

    public function getProductName()
    {
        return $this->getProduct()->getName();
    }

    public function isCustomerLoggedIn()
    {
        return $this->authSession->isLoggedIn();
    }

    public function getCurrentUser()
    {
        if($this->isCustomerLoggedIn()) {
            $customer = $this->authSession->getCustomer();
            return array('first_name' => $customer->getFirstname(),'last_name' => $customer->getLastname(), 'email' => $customer->getEmail());
        } else {
            return array('first_name' => '','last_name' => '', 'email' => '');
        }
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getNextPreviousProduct()
    {
        $product = $this->getProduct();

        $productId = $product->getId();
        $cat_ids = $product->getCategoryIds();

        $previous = $next = '';

        if (!empty($cat_ids)) {
            foreach ($cat_ids as $cat_id) {

                $category = $this->categoryRepository->get($cat_id);

                $category_product = $category->getProductCollection()->addAttributeToSort('position', 'asc');
                $category_product->addAttributeToFilter('status', 1);
                $category_product->addAttributeToFilter('visibility', 4);

                $cat_prod_ids = $category_product->getAllIds();


                $_pos = array_search($productId, $cat_prod_ids); // get position of current product
                $_next_pos = $_pos + 1;
                $_prev_pos = $_pos - 1;
                $keys = array_keys($cat_prod_ids);

                if (in_array($_next_pos, $keys)) {
                    $_next_prod = $this->productRepository->getById($cat_prod_ids[$_next_pos]);
                    $next = $_next_prod->getProductUrl();
                }
                if (in_array($_prev_pos, $keys)) {
                    $_prev_prod = $this->productRepository->getById($cat_prod_ids[$_prev_pos]);
                    $previous = $_prev_prod->getProductUrl();
                }

                if (!empty($next) && !empty($next)) {
                    break;
                }

            }
        }
        return array('previous' => $previous, 'next' => $next);
    }

    public function getFormAction()
    {
        return $this->getUrl().'quote_request/index/booking';
    }

}