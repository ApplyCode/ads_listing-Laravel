<?php

/*
 * ==========================================================
 * ADMIN_CODE.PHP
 * ==========================================================
 *
 * Admin area. © 2022-2023 boxcoin.dev. All rights reserved.
 *
 */

function bxc_box_admin() {
    bxc_colors_admin();
    bxc_load_custom_js_css();
    $is_shop = defined('BXC_SHOP');
    $css = bxc_is_rtl(bxc_language(true)) ? ' bxc-rtl' : '';
    if (!BXC_CLOUD && !bxc_ve_box()) {
        return;
    }
    bxc_version_updates();
    if ($is_shop) {
        bxc_shop_db_update();
    }
    if (bxc_is_agent()) {
        $css .= ' bxc-agent';
    }
    ?>
    <div class="bxc-main bxc-admin bxc-area-transactions<?php echo $css ?>">
        <div class="bxc-sidebar">
            <div>
                <img class="bxc-logo" src="https://thevenusguide.com/frontend/images/logo-white.png" />
                <img class="bxc-logo-icon" src="https://thevenusguide.com/frontend/images/logo-white.png" />
            </div>
            <div class="bxc-nav">
                <div id="transactions" class="bxc-active">
                    <i class="bxc-icon-shuffle"></i>
                    <span>
                        <?php bxc_e('Transactions') ?>
                    </span>
                </div>
                <div id="checkouts">
                    <i class="bxc-icon-automation"></i>
                    <span>
                        <?php bxc_e('Checkouts') ?>
                    </span>
                </div>
                <div id="balances">
                    <i class="bxc-icon-bar-chart"></i>
                    <span>
                        <?php bxc_e('Balances') ?>
                    </span>
                </div>
                <?php
                if (!bxc_is_agent()) {
                    echo '<div id="settings"><i class="bxc-icon-settings"></i><span>' . bxc_('Settings') . '</span></div>';
                }
                if ($is_shop) {
                    echo '<div id="analytics"><i class="bxc-icon-calendar"></i><span>' . bxc_('Analytics') . '</span></div>';
                }
                if (BXC_CLOUD) {
                    echo '<div id="account"><i class="bxc-icon-user"></i><span>' . bxc_('Account') . '</span></div>';
                }
                ?>
            </div>
            <div class="bxc-bottom">
                <div id="bxc-request-payment" class="bxc-btn">
                    <?php bxc_e('Request a payment') ?>
                </div>
                <div id="bxc-create-checkout" class="bxc-btn">
                    <?php bxc_e('Create checkout') ?>
                </div>
                <div id="bxc-save-settings" class="bxc-btn">
                    <?php bxc_e('Save settings') ?>
                </div>
                <div class="bxc-mobile-menu">
                    <i class="bxc-icon-menu"></i>
                    <div class="bxc-flex">
                        <div class="bxc-link" id="bxc-logout">
                            <?php bxc_e('Logout') ?>
                        </div>
                        <div id="bxc-version">
                            <?php echo BXC_VERSION ?>
                        </div>
                        <a class="bxc-btn-icon" href="<?php echo BXC_CLOUD ? CLOUD_DOCS : 'https://boxcoin.dev/docs' ?>" target="_blank">
                            <i class="bxc-icon-help"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bxc-body">
            <main>
                <div data-area="transactions" class="bxc-active">
                    <div class="bxc-nav-wide">
                        <div class="bxc-input bxc-search">
                            <input type="text" id="bxc-search-transactions" class="bxc-search-input" name="bxc-search" placeholder="<?php bxc_e('Search all transactions') ?>" autocomplete="false" />
                            <input type="text" class="bxc-hidden" />
                            <i class="bxc-icon-search"></i>
                        </div>
                        <div id="bxc-download-transitions" class="bxc-btn-icon">
                            <i class="bxc-icon-download"></i>
                        </div>
                        <?php bxc_admin_filters() ?>
                        <div id="bxc-filters" class="bxc-btn-icon">
                            <i class="bxc-icon-filters"></i>
                        </div>
                    </div>
                    <hr />
                    <table id="bxc-table-transactions" class="bxc-table">
                        <thead>
                            <tr>
                                <th data-field="id"></th>
                                <th data-field="date">
                                    <?php bxc_e('Date') ?>
                                </th>
                                <th data-field="from">
                                    <?php bxc_e('From') ?>
                                </th>
                                <th data-field="to">
                                    <?php bxc_e('To') ?>
                                </th>
                                <th data-field="status">
                                    <?php bxc_e('Status') ?>
                                </th>
                                <th data-field="amount">
                                    <?php bxc_e('Amount') ?>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div data-area="checkouts" class="bxc-loading">
                    <table id="bxc-table-checkouts" class="bxc-table">
                        <tbody></tbody>
                    </table>
                    <div id="bxc-checkouts-form">
                        <form>
                            <div class="bxc-info"></div>
                            <div class="bxc-top">
                                <div id="bxc-checkouts-list" class="bxc-btn bxc-btn-border">
                                    <i class="bxc-icon-back"></i>
                                    <?php bxc_e('Checkouts list') ?>
                                </div>
                            </div>
                            <div id="bxc-checkout-title" class="bxc-input">
                                <span>
                                    <?php bxc_e('Title') ?>
                                </span>
                                <input type="text" required />
                            </div>
                            <div id="bxc-checkout-description" class="bxc-input">
                                <span>
                                    <?php bxc_e('Description') ?>
                                </span>
                                <input type="text" />
                            </div>
                            <div class="bxc-flex">
                                <div id="bxc-checkout-price" data-type="select" class="bxc-input">
                                    <span>
                                        <?php bxc_e('Price') ?>
                                    </span>
                                    <input type="number" />
                                </div>
                                <div id="bxc-checkout-currency" data-type="select" class="bxc-input">
                                    <select>
                                        <option value="crypto" selected>
                                            <?php bxc_e('Cryptocurrency') ?>
                                        </option>
                                        <?php
                                        $cryptocurrencies = bxc_crypto_name();
                                        $code = '';
                                        
                                         $code .= '<option value="BTC" selected>Bitcoin</option>';
                                        // foreach ($cryptocurrencies as $key => $value) {
                                        //     $code .= '<option value="' . strtoupper($key) . '">' . $value[1] . '</option>';
                                        // }
                                        echo $code;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="bxc-checkout-type" data-type="select" class="bxc-input">
                                <span>
                                    <?php bxc_e('Type') ?>
                                </span>
                                <select>
                                    <option value="I" selected>
                                        <?php bxc_e('Inline') ?>
                                    </option>
                                    <option value="L">
                                        <?php bxc_e('Link') ?>
                                    </option>
                                    <option value="P">
                                        <?php bxc_e('Popup') ?>
                                    </option>
                                    <option value="H">
                                        <?php bxc_e('Hidden') ?>
                                    </option>
                                </select>
                            </div>
                            <div id="bxc-checkout-redirect" class="bxc-input">
                                <span>
                                    <?php bxc_e('Redirect URL') ?>
                                </span>
                                <input type="url" />
                            </div>
                            <div id="bxc-checkout-external_reference" class="bxc-input">
                                <span>
                                    <?php bxc_e('External reference') ?>
                                </span>
                                <input type="text" />
                            </div>
                            <div id="bxc-checkout-hide_title" class="bxc-input">
                                <span>
                                    <?php bxc_e('Hide title') ?>
                                </span>
                                <input type="checkbox" />
                            </div>
                            <?php
                            if (defined('BXC_SHOP')) {
                                echo bxc_shop_checkout_area();
                            }
                            if (defined('BXC_WP')) {
                                echo '<div id="bxc-checkout-shortcode" class="bxc-input"><span>Shortcode</span><div></div><i class="bxc-icon-copy bxc-clipboard bxc-toolip-cnt"><span class="bxc-toolip">' . bxc_('Copy to clipboard') . '</span></i></div>';
                            }
                            if (bxc_settings_get('url-rewrite-checkout') || BXC_CLOUD) {
                                echo '<div id="bxc-checkout-slug" class="bxc-input"><span>' . bxc_('Slug') . '</span><input type="text" /></div>';
                            }
                            ?>
                            <div id="bxc-checkout-embed-code" class="bxc-input">
                                <span>
                                    <?php bxc_e('Embed code') ?>
                                </span>
                                <div></div>
                                <i class="bxc-icon-copy bxc-clipboard bxc-toolip-cnt">
                                    <span class="bxc-toolip">
                                        <?php bxc_e('Copy to clipboard') ?>
                                    </span>
                                </i>
                            </div>
                            <div id="bxc-checkout-payment-link" class="bxc-input">
                                <span>
                                    <?php bxc_e('Payment link') ?>
                                </span>
                                <div></div>
                                <i class="bxc-icon-copy bxc-clipboard bxc-toolip-cnt">
                                    <span class="bxc-toolip">
                                        <?php bxc_e('Copy to clipboard') ?>
                                    </span>
                                </i>
                            </div>
                            <div class="bxc-bottom">
                                <div id="bxc-save-checkout" class="bxc-btn">
                                    <?php bxc_e('Save checkout') ?>
                                </div>
                                <a id="bxc-delete-checkout" class="bxc-btn-icon bxc-btn-red">
                                    <i class="bxc-icon-delete"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div data-area="balance">
                    <div>
                        <div id="bxc-balance-total" class="bxc-title"></div>
                        <div class="bxc-text">
                            <?php bxc_e('Available balance') ?>
                        </div>
                    </div>
                    <table id="bxc-table-balances" class="bxc-table">
                        <thead>
                            <tr>
                                <th data-field="cryptocurrency">
                                    <?php bxc_e('Crypto currency') ?>
                                </th>
                                <th data-field="balance">
                                    <?php bxc_e('Balance') ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div data-area="settings" class="bxc-loading">
                    <?php bxc_settings_populate() ?>
                </div>
                <?php
                if ($is_shop) {
                    bxc_shop_analytics_area();
                }
                if (BXC_CLOUD) {
                    require(__DIR__ . '/cloud/account.php');
                }
                ?>
            </main>
        </div>
        <div id="bxc-card" class="bxc-info-card"></div>
    </div>
    <div id="bxc-lightbox">
        <div>
            <div class="bxc-top">
                <div class="bxc-title"></div>
                <div class="bxc-flex">
                    <div class="bxc-lightbox-buttons bxc-flex"></div>
                    <div id="bxc-lightbox-close" class="bxc-btn-icon bxc-btn-red">
                        <i class="bxc-icon-close"></i>
                    </div>
                </div>
            </div>
            <div id="bxc-lightbox-main" class="bxc-scrollbar"></div>
        </div>
        <span></span>
    </div>
    <div id="bxc-lightbox-loading" class="bxc-loading"></div>
    <form id="bxc-upload-form" action="#" method="post" enctype="multipart/form-data">
        <input type="file" name="files[]" />
    </form>
<?php } ?>

<?php function bxc_admin_filters($show_all_statues = true) { ?>
    <div class="bxc-nav-filters">
        <div class="bxc-input">
            <input class="bxc-filter-date" placeholder="<?php bxc_e('Start date...') ?>" type="text" readonly />
            <input class="bxc-filter-date-2" placeholder="<?php bxc_e('End date...') ?>" type="text" readonly />
        </div>
        <div class="bxc-filter-status bxc-select bxc-right">
            <p>
                <?php bxc_e($show_all_statues ? 'All statuses' : 'Completed') ?>
            </p>
            <ul>
                <?php
                if ($show_all_statues) {
                    echo ' <li data-value="" class="bxc-active">' . bxc_('All statuses') . '</li>';
                }
                ?>
                <li data-value="C" <?php echo $show_all_statues ? '' : ' class="bxc-active"' ?>>
                    <?php bxc_e('Completed') ?>
                </li>
                <li data-value="P">
                    <?php bxc_e('Pending') ?>
                </li>
                <li data-value="R">
                    <?php bxc_e('Refunded') ?>
                </li>
            </ul>
        </div>
        <div class="bxc-filter-cryptocurrency bxc-select bxc-right">
            <p>
                <?php bxc_e('All currencies') ?>
            </p>
            <ul>
                <li data-value="" class="bxc-active">
                    <?php bxc_e('All currencies') ?>
                </li>
                <?php
                $cryptocurrencies = bxc_crypto_name(false, true);
                $currencies = bxc_db_get('SELECT cryptocurrency FROM bxc_transactions GROUP BY cryptocurrency UNION SELECT currency FROM bxc_transactions GROUP BY currency', false);
                $code = '';
                for ($i = 0; $i < count($currencies); $i++) {
                    $currency = $currencies[$i]['cryptocurrency'];
                    if (!in_array($currency, ['stripe', 'verifone', 'paypal'])) {
                        $code .= ' <li data-value="' . $currency . '">' . (isset($cryptocurrencies[$currency]) ? $cryptocurrencies[$currency][1] . ' ' . bxc_crypto_get_network($currency, true, true) : strtoupper($currency)) . '</li>';
                    }
                }
                echo $code;
                ?>
            </ul>
        </div>
        <div class="bxc-filter-checkout bxc-select bxc-right">
            <p>
                <?php bxc_e('All checkouts') ?>
            </p>
            <ul>
                <li data-value="" class="bxc-active">
                    <?php bxc_e('All checkouts') ?>
                </li>
                <?php
                $checkouts = bxc_checkout_get();
                $code = '';
                for ($i = 0; $i < count($checkouts); $i++) {
                    $code .= ' <li data-value="' . $checkouts[$i]['id'] . '">' . $checkouts[$i]['title'] . '</li>';
                }
                echo $code;
                ?>
            </ul>
        </div>
    </div>
<?php } ?>