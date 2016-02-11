<?php

namespace Pyz\Yves\Category\Plugin\Provider;

use Pyz\Yves\Application\Plugin\Provider\AbstractServiceProvider;
use Silex\Application;

/**
 * @method \Pyz\Yves\Category\CategoryFactory getFactory()
 */
class CategoryServiceProvider extends AbstractServiceProvider
{

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        $this->addGlobalTemplateVariable($app, [
            'categories' => $this->getFactory()->getCategoryExporterClient()->getNavigationCategories($app['locale']),
        ]);
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }

}
