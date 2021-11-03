<?php

namespace CryptWerk\Controller\Admin\Improve\Catalog;

use CryptWerk;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Security\Annotation\AdminSecurity;
use PrestaShopBundle\Security\Annotation\ModuleActivated;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ModuleActivated(moduleName="cryptwerk", redirectRoute="admin_module_manage")
 */
class ConfigureController extends FrameworkBundleAdminController
{
	/**
	 * @AdminSecurity("is_granted('read', request.get('_legacy_controller'))", message="Access denied.")
	 */
	public function configureAction(): Response
	{
		return $this->redirect($this->getContext()->link->getModuleLink('cryptwerk', 'feed'));
	}
}
