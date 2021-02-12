<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */

namespace PrestaShop\Module\PrestashopCheckout\PayPal;

use PrestaShop\Module\PrestashopCheckout\Configuration\PrestaShopConfiguration;
use PrestaShop\Module\PrestashopCheckout\Exception\PsCheckoutException;

class PayPalPayIn4XConfiguration
{
    const PAY_IN_4X_PRODUCT_PAGE = 'PAY_IN_4X_PRODUCT_PAGE';
    const PAY_IN_4X_ORDER_PAGE = 'PAY_IN_4X_ORDER_PAGE';

    /**
     * @var PrestaShopConfiguration
     */
    private $configuration;

    public function __construct(PrestaShopConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function isOrderPageEnabled()
    {
        return (bool) $this->configuration->get(self::PAY_IN_4X_ORDER_PAGE);
    }

    public function isProductPageEnabled()
    {
        return (bool) $this->configuration->get(self::PAY_IN_4X_PRODUCT_PAGE);
    }

    /**
     * @param bool $status
     *
     * @throws PsCheckoutException
     */
    public function setProductPage($status)
    {
        $this->configuration->set(self::PAY_IN_4X_PRODUCT_PAGE, $status);
    }

    /**
     * @param bool $status
     *
     * @throws PsCheckoutException
     */
    public function setOrderPage($status)
    {
        $this->configuration->set(self::PAY_IN_4X_ORDER_PAGE, $status);
    }
}