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
import * as types from './mutation-types';

export default {
  [types.UNLINK_ACCOUNT](state) {
    state.idMerchant = '';
    state.emailMerchant = '';
    state.onboardingCompleted = false;
  },
  [types.UPDATE_ONBOARDING_LINK](state, onboardingLink) {
    state.paypalOnboardingLink = onboardingLink;
  },
  [types.UPDATE_PAYPAL_ACCOUNT_STATUS](state, paypalAccount) {
    Object.assign(state, paypalAccount.paypal);
  },
  [types.UPDATE_CONFIRMED_LIVE_STEP](state, confirmed) {
    state.isLiveStepConfirmed = confirmed;
  },
  [types.UPDATE_VALUE_BANNER_CLOSED](state, closed) {
    state.isValueBannerClosed = closed;
  }
};
