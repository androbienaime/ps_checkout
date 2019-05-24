<?php
/**
* 2007-2019 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2019 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

use PrestaShop\Module\PrestashopCheckout\Payment;

class ps_checkoutValidateOrderModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if ($this->checkIfContextIsValid()) {
            throw new \PrestaShopException('The context is not valid');
        }

        if ($this->checkIfPaymentOptionIsAvailable()) {
            throw new \PrestaShopException('This payment method is not available.');
        }

        parent::initContent();
    }

    public function postProcess()
    {
        $paypalOrderId = Tools::getValue('orderId');
        $paymentMethod = Tools::getValue('paymentMethod');

        if (false === $paypalOrderId) {
            throw new \PrestaShopException('Paypal order id is missing.');
        }

        switch ($paymentMethod) {
            case 'card':
                $paymentMethod = $this->l('Payment by card');
                break;
            case 'paypal':
                $paymentMethod = $this->l('Payment by PayPal');
                break;
            default:
                $paymentMethod = $this->l('Payment by PrestaShop Checkout');
                break;
        }

        $cart = $this->context->cart;

        $customer = new Customer($cart->id_customer);

        if (false === Validate::isLoadedObject($customer)) {
            Tools::redirect('index.php?controller=order&step=1');
        }

        $currency = $this->context->currency;
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);

        $payment = new Payment($paypalOrderId);

        $dataOrder = [
            'cartId' => (int)$cart->id,
            'orderStateId' => Configuration::get('PS_OS_CHEQUE'),
            'amount' => $total,
            'paymentMethod' => $paymentMethod,
            'message' => null,
            'extraVars' => array('transaction_id' => $paypalOrderId),
            'currencyId' => (int)$currency->id,
            'secureKey' => $customer->secure_key
        ];

        $payment->validateOrder($dataOrder);

        Tools::redirect('index.php?controller=order-confirmation&id_cart='.(int)$cart->id.'&id_module='.(int)$this->module->id.'&id_order='.$this->module->currentOrder.'&key='.$customer->secure_key);
    }

    /**
     * Check if the context is valid and if the module is active
     *
     * @return bool
     */
    public function checkIfContextIsValid()
    {
        $cart = $this->context->cart;

        // check if customer and adresses are correctly set in the cart
        if ($cart->id_customer == 0 || $cart->id_address_delivery == 0 || $cart->id_address_invoice == 0) {
            return false;
        }

        // check if module is active
        if (false === $this->module->active) {
            return false;
        }

        return true;
    }

    /**
     * Check that this payment option is still available in case the customer changed
     * his address just before the end of the checkout process
     *
     * @return bool
     */
    public function checkIfPaymentOptionIsAvailable()
    {
        foreach (Module::getPaymentModules() as $module) {
            if ($module['name'] == 'ps_checkout') {
                return true;
            }
        }

        return false;
    }
}