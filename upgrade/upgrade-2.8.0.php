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
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Update main function for module version 2.8.0
 *
 * @param Ps_checkout $module
 *
 * @return bool
 */
function upgrade_module_2_8_0($module)
{
    if (false === (bool) version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
        // Register hooks only for PrestaShop 1.6, used for ExpressCheckout
        $module->registerHook('actionBeforeCartUpdateQty');
        $module->registerHook('actionAfterDeleteProductInCart');
    } else {
        // Register hook only for PrestaShop 1.7, used for ExpressCheckout
        $module->registerHook('actionObjectProductInCartDeleteAfter');
    }

    return true;
}
