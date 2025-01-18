<?php

add_hook('AdminHomeWidgets', 1, function() {
    return new ServicesStatusWidget();
});

/**
 * Services Status Widget.
 *
 * @copyright Copyright (c) AppVZ Online 2025
 * @license https://appvz.com
 */
 
 use WHMCS\Database\Capsule;
 
class ServicesStatusWidget extends \WHMCS\Module\AbstractWidget
{
    protected $title = 'Services Status';
    protected $description = 'Displays the count of active and suspended services.';
    protected $weight = 150; 
    protected $columns = 1;
    protected $cache = false;
    protected $cacheExpiry = 120;
    protected $requiredPermission = '';

    public function getData()
    {
        return array();
    }

    public function generateOutput($chartData = null) {
        // Fetch data from the database
        $activeServices = Capsule::table('tblhosting')->where('domainstatus', 'Active')->count();
        $suspendedServices = Capsule::table('tblhosting')->where('domainstatus', 'Suspended')->count();
        
        return '
<div class="icon-stats">
    <div class="row">
        <div class="col-sm-6">
            <div class="item">
                <div class="icon-holder text-center color-green">
                    <i class="pe-7s-check"></i>
                </div>
                <div class="data">
                    <div class="note">
                        Active Services
                    </div>
                    <div class="number">
                            <span class="color-green">' . $activeServices . '</span>
                            <span class="unit">Active</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="item">
                <div class="icon-holder text-center color-orange">
                    <a href="services?status=suspended"><i class="pe-7s-lock"></i></a>
                </div>
                <div class="data">
                    <div class="note">
                        <a href="services?status=suspended">Suspended Services</a>
                    </div>
                    <div class="number">
						<a href="services?status=suspended">
                        <span class="color-orange">' . $suspendedServices . '</span>
                        <span class="unit">Suspended</span>
						</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        ';
    }
}
