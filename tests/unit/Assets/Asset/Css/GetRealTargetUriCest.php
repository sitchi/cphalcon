<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Unit\Assets\Asset\Css;

use Phalcon\Assets\Asset\Css;
use Phalcon\Test\Fixtures\Traits\AssetsTrait;
use UnitTester;

/**
 * Class GetRealTargetUriCest
 */
class GetRealTargetUriCest
{
    use AssetsTrait;

    /**
     * Tests Phalcon\Assets\Asset :: getRealTargetUri() - css local
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function assetsAssetCssGetAssetKeyLocal(UnitTester $I)
    {
        $I->wantToTest('Assets\Asset - getRealTargetUri() - css local');
        $asset = new Css('css/docs.css');

        $expected = 'css/docs.css';
        $this->assetGetRealTargetUri($I, $asset, $expected);
    }

    /**
     * Tests Phalcon\Assets\Asset :: getRealTargetUri() - css remote
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function assetsAssetCssGetAssetKeyRemote(UnitTester $I)
    {
        $I->wantToTest('Assets\Asset - getRealTargetUri() - css remote');
        $asset = new Css('https://phalcon.ld/css/docs.css', false);

        $expected = 'https://phalcon.ld/css/docs.css';
        $this->assetGetRealTargetUri($I, $asset, $expected);
    }
}
